<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Attendances extends Migration
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
            'employee_id' => [
                'type' => 'VARCHAR',
                'constraint' => 11,
            ],
            'remark' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'machine' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'transaction_date' => [
                'type' => 'DATE',
            ],
            'time_in' => [
                'type' => 'TIME',
            ],
            'time_out' => [
                'type' => 'TIME',
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
        $this->forge->createTable('attendances', true);

        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('attendances', true);
    }
}
