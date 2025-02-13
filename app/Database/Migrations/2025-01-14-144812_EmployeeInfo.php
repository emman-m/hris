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
                'null' => true,
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
                'null' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['Single', 'Married', 'Widow/Widower'],
                'null' => true,
            ],
            'spouse' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'null' => true,
            ],
            'permanent_address' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'null' => true,
            ],
            'present_address' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'null' => true,
            ],
            'fathers_name' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'null' => true,
            ],
            'mothers_name' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'null' => true,
            ],
            'mothers_maiden_name' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'null' => true,
            ],
            'religion' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'null' => true,
            ],
            'tel' => [
                'type' => 'VARCHAR',
                'constraint' => '15',
                'null' => true,
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => '15',
                'null' => true,
            ],
            'nationality' => [
                'type' => 'VARCHAR',
                'constraint' => '30',
                'null' => true,
            ],
            'sss' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
                'null' => true,
            ],
            'date_of_coverage' => [
                'type' => 'DATE',
                'null' => true
            ],
            'pagibig' => [
                'type' => 'VARCHAR',
                'constraint' => '12',
                'null' => true,
            ],
            'tin' => [
                'type' => 'VARCHAR',
                'constraint' => '12',
                'null' => true,
            ],
            'philhealth' => [
                'type' => 'VARCHAR',
                'constraint' => '12',
                'null' => true,
            ],
            'res_cert_no' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
            ],
            'res_issued_on' => [
                'type' => 'DATE',
                'null' => true
            ],
            'res_issued_at' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
            ],
            'contact_person' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
            'contact_person_no' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
            ],
            'contact_person_relation' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
            ],
            'employment_date' => [
                'type' => 'DATE',
                'null' => true
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
        $this->forge->createTable('employees_info', true);

        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('employees_info', true);
    }
}
