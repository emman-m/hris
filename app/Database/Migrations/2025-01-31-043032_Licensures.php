<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Licensures extends Migration
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
            'license' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
            ],
            'year' => [
                'type' => 'VARCHAR',
                'constraint' => '4',
            ],
            'rating' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'license_no' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
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
        $this->forge->createTable('licensures', true);

        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('licensures', true);
    }
}
