<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Affiliation extends Migration
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
            'type' => [
                'type' => 'ENUM',
                'constraint' => ['Professional Organizations', 'Socio-Civic Organizations'],
                'null' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
                'null' => true,
            ],
            'position' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
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
        $this->forge->createTable('affiliations', true);

        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('affiliations', true);
    }
}
