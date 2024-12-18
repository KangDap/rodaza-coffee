<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\OrdersModel;

class Admin extends BaseController
{
    protected $db;

    public function __construct(){
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        return view('admin/indexAdmin');
    }

    public function processOrder()
    {
        $orderId = $this->request->getUri()->getSegment(3);

        if ($orderId === null) {
            return redirect()->back()->with('error', 'ID Pesanan tidak valid');
        }

        $orderModel = new OrdersModel();
        $order = $orderModel->where('order_id', $orderId)->first();
        
        if ($order) {
            $orderModel->update($order['order_id'], [
                'order_status' => 'diproses'
            ]);

            return redirect()->back()->with('success', 'Pesanan dengan ID ' . $orderId . ' sedang diproses.');
        } else {
            return redirect()->back()->with('error', 'Pesanan tidak ditemukan');
        }
    }

    public function completeOrder()
    {
        $orderId = $this->request->getUri()->getSegment(3);

        if ($orderId === null) {
            return redirect()->back()->with('error', 'ID Pesanan tidak valid');
        }

        $orderModel = new OrdersModel();
        $order = $orderModel->where('order_id', $orderId)->first();
        
        if ($order) {
            $orderModel->update($order['order_id'], [
                'order_status' => 'selesai'
            ]);

            return redirect()->back()->with('success', 'Pesanan dengan ID ' . $orderId . ' sudah diterima.');
        } else {
            return redirect()->back()->with('error', 'Pesanan tidak ditemukan');
        }
    }
}
