<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PositionHistory extends Migration
{
    public function up()
    {
        $this->db->disableForeignKeyChecks();

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'position' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
            ],
            'date_from' => [
                'type' => 'DATE',
                'charset' => 'utf8mb4',
            ],
            'date_to' => [
                'type' => 'DATE',
                'charset' => 'utf8mb4',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'on_update' => 'CURRENT_TIMESTAMP',
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('position_history', true);

        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('position_history', true);
    }
}
