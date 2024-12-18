<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Midtrans\Config;
use App\Models\OrdersModel;
use App\Models\OrderItemsModel;

class PaymentController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        // Set your Merchant Server Key
        Config::$serverKey = ''; // Sesuaikan dengan Server Key Midtrans Anda
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        Config::$isProduction = false;
        // Set sanitization on (default)
        Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        Config::$is3ds = true;

        // Ambil data yang dikirimkan melalui form
        $orderType = $this->request->getPost('order_type'); // 'delivery' atau 'dine-in'
        $address = $this->request->getPost('address') ?: user()->address; // Alamat untuk delivery
        $tableNumber = $this->request->getPost('table_number'); // Nomor meja untuk dine-in
        $items = json_decode($this->request->getPost('items'), true); // Item keranjang dari frontend
        $totalAmount = $this->request->getPost('total_amount'); // Total jumlah pembayaran
        $productIds = [];
        foreach ($items as $item) {
            $productIds[] = $item['id'];  // Menambahkan product_id ke array
        }
        $quantities = [];
        foreach ($items as $item) {
            $quantities[] = $item['quantity'];
        }
        $prices = [];
        foreach ($items as $item) {
            $prices[] = $item['price'];
        }

        // Ambil detail pelanggan
        $userId = $this->request->getPost('user_id');
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $phoneNumber = $this->request->getPost('phone_number');

        // Set data billing dan shipping berdasarkan jenis pesanan
        $billingAddress = [
            'first_name'   => $username,
            'address'      => $tableNumber ? '' : $address, // Gunakan alamat dari form jika delivery, kosongkan jika dine-in
            'phone'        => $phoneNumber,
            'country_code' => 'IDN'
        ];

        $shippingAddress = $orderType === 'delivery' ? $billingAddress : null; // Shipping address hanya untuk delivery

        // Detail pelanggan
        $customerDetails = [
            'first_name'       => $username,
            'last_name'        => '',
            'email'            => $email,
            'phone'            => $phoneNumber,
            'billing_address'  => $billingAddress,
            'shipping_address' => $shippingAddress
        ];

        // Transaction details untuk Midtrans
        $params = [
            'transaction_details' => [
                'order_id'   => 'ORD-' . date('Ymd') . '-' . uniqid(),
                'gross_amount' => $totalAmount,  // Ambil total dari form
            ],
            'item_details'        => $items,
            'customer_details'    => $customerDetails
        ];

        // Mendapatkan token untuk Snap Midtrans
        $snapToken = \Midtrans\Snap::getSnapToken($params);

        // Kirim token ke view untuk digunakan di frontend
        $data = [
            'order_id' => $params['transaction_details']['order_id'],
            'user_id' => $userId,
            'order_date' => date('Y-m-d H:i:s'),
            'order_type' => $orderType,
            'order_status' => 'menunggu',
            'table_number' => $tableNumber,
            'address' => $tableNumber ? null : $address,
            'payment_status' => 'belum bayar',
            'payment_date' => null,
            'payment_method' => null,
            'total_amount' => $params['transaction_details']['gross_amount'],
            'product_ids' => $productIds,
            'quantity' => $quantities,
            'price' => $prices,
            'snapToken' => $snapToken
        ];

        return $this->response->setJSON($data);
    }

    public function insertOrderData() {
        // Ambil raw input JSON
        $jsonData = $this->request->getJSON(true); // Gunakan true untuk mengonversi ke array
    
        if ($jsonData) {
            try {
                $orderModel = new OrdersModel();
                $orderItemsModel = new OrderItemsModel();
    
                // Validasi data
                if (!isset($jsonData['order_id']) || !isset($jsonData['user_id'])) {
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'Invalid order data'
                    ])->setStatusCode(400);
                }
    
                // Persiapkan data order
                $orderData = [
                    'order_id' => $jsonData['order_id'],
                    'user_id' => $jsonData['user_id'],
                    'order_date' => $jsonData['order_date'] ?? date('Y-m-d H:i:s'),
                    'order_type' => $jsonData['order_type'] ?? null,
                    'order_status' => $jsonData['order_status'] ?? 'menunggu',
                    'table_number' => $jsonData['table_number'] ?? null,
                    'address' => $jsonData['address'] ?? null,
                    'payment_status' => $jsonData['payment_status'] ?? 'lunas',
                    'payment_date' => $jsonData['payment_date'] ?? date('Y-m-d H:i:s'),
                    'payment_method' => $jsonData['payment_method'] ?? null,
                    'total_amount' => $jsonData['total_amount'] ?? 0
                ];
    
                // Mulai transaksi
                $this->db->transStart();
    
                // Insert order
                $orderModel->insert($orderData);
    
                // Persiapkan dan insert order items
                // Pastikan product_ids, quantity, dan price adalah array
                if (
                    isset($jsonData['product_ids']) && 
                    isset($jsonData['quantity']) && 
                    isset($jsonData['price']) && 
                    is_array($jsonData['product_ids'])
                ) {
                    foreach ($jsonData['product_ids'] as $index => $productId) {
                        $orderItemsModel->insert( [
                            'order_id' => $jsonData['order_id'],
                            'product_id' => $productId,
                            'quantity' => $jsonData['quantity'][$index] ?? 1,
                            'price' => ($jsonData['price'][$index] * $jsonData['quantity'][$index]) ?? 0
                        ]);
                    }
                }
    
                // Selesaikan transaksi
                $this->db->transComplete();
    
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Order saved successfully',
                    'order_id' => $jsonData['order_id']
                ]);
    
            } catch (\Exception $e) {
                // Rollback transaksi jika ada error
                $this->db->transRollback();
    
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ])->setStatusCode(500);
            }
        }
    
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'No data received'
        ])->setStatusCode(400);
    }
}
