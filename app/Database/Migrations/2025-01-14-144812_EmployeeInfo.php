<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class EmployeeInfo extends Migration
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
            'department' => [
                'type' => 'ENUM',
                'constraint' => [
                    'Lower School',
                    'Middle High School',
                    'Junior High School',
                    'Senior High School',
                    'College',
                    'Non Teaching Personnel'
                ],
            ],
            'birth' => [
                'type' => 'DATE',
                'null' => true
            ],
            'birth_place' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
                'null' => false
            ],
            'gender' => [
                'type' => 'ENUM',
                'constraint' => ['Male', 'Female'],
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['Single', 'Married', 'Widow/Widower'],
            ],
            'spouse' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
            ],
            'permanent_address' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
            ],
            'present_address' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
            ],
            'fathers_name' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
            ],
            'mothers_name' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
            ],
            'mothers_maiden_name' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
            ],
            'religion' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
            ],
            'tel' => [
                'type' => 'VARCHAR',
                'constraint' => '15',
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => '15',
            ],
            'nationality' => [
                'type' => 'VARCHAR',
                'constraint' => '30',
            ],
            'sss' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
            ],
            'date_of_coverage' => [
                'type' => 'DATE',
                'null' => true
            ],
            'pagibig' => [
                'type' => 'VARCHAR',
                'constraint' => '12',
            ],
            'tin' => [
                'type' => 'VARCHAR',
                'constraint' => '12',
            ],
            'philhealth' => [
                'type' => 'VARCHAR',
                'constraint' => '12',
            ],
            'res_cert_no' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],
            'res_issued_on' => [
                'type' => 'DATE',
                'null' => true
            ],
            'res_issued_at' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],
            'contact_person' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'contact_person_no' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],
            'contact_person_relation' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],
            'employment_date' => [
                'type' => 'DATE',
                'null' => true
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('employees_info', true);

        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('employees_info', true);
    }
}
