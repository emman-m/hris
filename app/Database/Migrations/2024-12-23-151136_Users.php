<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
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
            'role' => [
                'type' => 'ENUM',
                'constraint' => ['Admin', 'HR Admin', 'HR Staff', 'Employee'],
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
            ],
            'status' => [
                'type' => 'ENUM',
                'default' => 'Active',
                'constraint' => ['Active', 'Inactive'],
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
            ],
            'code' => [
                'type' => 'VARCHAR',
                'constraint' => '6',
                'collation' => 'utf8mb4_general_ci',
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
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('users', true);

        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('users', true);
    }
}
