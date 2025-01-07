<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UsersInfo extends Migration
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
            'first_name' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
            ],
            'middle_name' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
            ],
            'last_name' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
            ],
            'birth' => [
                'type' => 'DATE',
                'charset' => 'utf8mb4',
                'null' => false
            ],
            'birth_place' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
                'charset' => 'utf8mb4',
                'null' => false
            ],
            'gender' => [
                'type' => 'ENUM',
                'constraint' => ['Male', 'Female'],
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['Single', 'Married', 'Widow/Widower'],
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
            ],
            'spouse' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
            ],
            'permanent_address' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
            ],
            'present_address' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
            ],
            'fathers_name' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
            ],
            'mothers_name' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
            ],
            'mothers_maiden_name' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
            ],
            'religion' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
            ],
            'tel' => [
                'type' => 'VARCHAR',
                'constraint' => '15',
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => '15',
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
            ],
            'nationality' => [
                'type' => 'VARCHAR',
                'constraint' => '30',
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
            ],
            'sss' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
            ],
            'date_of_coverage' => [
                'type' => 'DATE',
                'charset' => 'utf8mb4',
            ],
            'pagibig' => [
                'type' => 'VARCHAR',
                'constraint' => '12',
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
            ],
            'tin' => [
                'type' => 'VARCHAR',
                'constraint' => '12',
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
            ],
            'philhealth' => [
                'type' => 'VARCHAR',
                'constraint' => '12',
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
            ],
            'res_cert_no' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
            ],
            'res_issued_on' => [
                'type' => 'DATETIME',
                'charset' => 'utf8mb4',
            ],
            'res_issued_at' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
            ],
            'contact_person' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
            ],
            'contact_person_no' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
            ],
            'contact_person_relation' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
            ],
            'employment_date' => [
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
        $this->forge->createTable('users_info', true);

        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('users_info', true);
    }
}
