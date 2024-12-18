<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Feedbacks extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'feedback_id' => [
                'type' => 'BIGINT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'BIGINT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'username' => [
                'type' => 'VARCHAR', 
                'constraint' => 30, 
            ],
            'email' => [
                'type' => 'VARCHAR', 
                'constraint' => 255
            ],
            'message' => [
                'type' => 'VARCHAR',
                'constraint' => '500',
                'null' => true,
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
        $this->forge->addKey('feedback_id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('feedbacks');
    }

    public function down()
    {
        $this->forge->dropTable('feedbacks');
    }
}
