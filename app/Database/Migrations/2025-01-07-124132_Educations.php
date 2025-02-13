<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Educations extends Migration
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
            'level' => [
                'type' => 'ENUM',
                'constraint' => ['Elementary', 'High School', 'Under Graduate', 'Graduate', 'Post Graduate'],
                'null' => true,
            ],
            'school_address' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'null' => true,
            ],
            'degree' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
                'null' => true,
            ],
            'major_minor' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
                'null' => true,
            ],
            'year_graduated' => [
                'type' => 'YEAR',
                'null' => true,
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
        $this->forge->createTable('educations', true);

        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('educations', true);
    }
}
