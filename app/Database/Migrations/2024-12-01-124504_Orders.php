<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Orders extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'order_id' => [
                'type' => 'VARCHAR',
                'constraint' => 25,
            ],
            'user_id' => [
                'type' => 'BIGINT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'order_date' => [
                'type' => 'DATETIME',
                'NULL' => false,
            ],
            'order_type' => [
                'type' => 'ENUM',
                'constraint' => ['dine-in', 'takeaway'],
                'default' => 'dine-in',
            ],
            'order_status' => [
                'type' => 'ENUM',
                'constraint' => ['menunggu', 'diproses', 'selesai'],
                'default' => 'menunggu',
            ],
            'table_number' => [
                'type' => 'BIGINT',
                'constraint' => 2,
                'NULL' => true,
                'unsigned' => true
            ],
            'address' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'NULL' => true,
            ],
            'payment_status' => [
                'type' => 'ENUM',
                'constraint' => ['belum bayar', 'sudah bayar'],
                'default' => 'belum bayar',
            ],
            'payment_date' => [
                'type' => 'DATETIME',
                'NULL' => true
            ],
            'payment_method' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'NULL' => true
            ],
            'total_amount' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'NULL' => false,
                'unsigned' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('order_id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('orders');
    }

    public function down()
    {
        $this->forge->dropTable('orders');
    }
}
