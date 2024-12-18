<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Products extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'product_id' => [
                'type' => 'BIGINT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'category_id' => [
                'type' => 'BIGINT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'product_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'NULL' => false,
            ],
            'price' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'NULL' => false,
            ],
            'description' => [
                'type' => 'TEXT',
            ],
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'stock' => [
                'type' => 'INT',
                'unsigned' => true,
                'NULL' => false,
            ],
        ]);
        $this->forge->addKey('product_id', true);
        $this->forge->addForeignKey('category_id', 'categories', 'category_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('products');
    }

    public function down()
    {
        $this->forge->dropTable('products');
    }
}
