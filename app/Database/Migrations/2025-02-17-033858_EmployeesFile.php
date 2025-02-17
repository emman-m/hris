<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class EmployeesFile extends Migration
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
            'created_user' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'is_approved' => [
                'type' => 'BOOLEAN',
                'default' => false
            ],
            'approving_user' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'approve_datetime' => [
                'type' => 'DATETIME',
            ],
            'file' => [
                'type' => 'VARCHAR',
                'constraint' => '500',
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('employees_files', true);

        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('employees_files', true);
    }
}
