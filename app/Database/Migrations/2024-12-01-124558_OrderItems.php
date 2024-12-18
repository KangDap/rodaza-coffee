<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class OrderItems extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'order_item_id' => [
                'type' => 'BIGINT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'order_id' => [
                'type' => 'VARCHAR',
                'constraint' => 25,
            ],
            'product_id' => [
                'type' => 'BIGINT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'quantity' => [
                'type' => 'INT',
                'constraint' => 5,
                'NULL' => false,
                'unsigned' => true,
            ],
            'price' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'NULL' => false,
                'unsigned' => true,
            ],
        ]);
        $this->forge->addKey('order_item_id', true);
        $this->forge->addForeignKey('order_id', 'orders', 'order_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('product_id', 'products', 'product_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('order_items');
    }

    public function down()
    {
        $this->forge->dropTable('order_items');
    }
}
