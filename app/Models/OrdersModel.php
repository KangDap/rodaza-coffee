<?php

namespace App\Models;

use CodeIgniter\Model;
use Config\Database;

class OrdersModel extends Model
{
    protected $table            = 'orders';
    protected $primaryKey       = 'order_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'order_id', 
        'user_id', 
        'order_date', 
        'order_type', 
        'order_status', 
        'table_number', 
        'address', 
        'payment_status', 
        'payment_date', 
        'payment_method', 
        'total_amount'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function updateTotalAmount($orderId){
        $db = Database::connect();
        $builder = $db->table('order_items');
        
        $totalAmount = $builder ->selectSum('price * quantity', 'total')
                                ->where('order_id', $orderId)
                                ->get()
                                ->getRow()
                                ->total;

        $orderBuilder = $db ->table('orders');
        $orderBuilder       ->where('order_id', $orderId)
                            ->update(['total_amount' => $totalAmount]);
    }

    public function addOrderItem($data){
        $this->db->table('order_items')->insert($data);

        $this->updateTotalAmount($data['order_id']);
    }

    public function updateOrderItem($orderItemId, $data){
        $this->db->table('order_items')
                ->where('order_item_id', $orderItemId)
                ->update($data);

        $this->updateTotalAmount($data['order_id']);
    }

    public function deleteOrderItem($orderItemId, $orderId){
        $this->db->table('order_items')
                ->where('order_item_id', $orderItemId)
                ->delete();

        $this->updateTotalAmount($orderId);
    }
}
