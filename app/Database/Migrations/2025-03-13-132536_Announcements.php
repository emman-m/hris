<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Announcements extends Migration
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
            'target' => [
                'type' => 'JSON',
                'null' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'content' => [
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
        $this->forge->createTable('announcements', true);

        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('announcements', true);
    }
}
