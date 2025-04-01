<?php

namespace App\Database\Migrations;

use App\Enums\ApproveStatus;
use App\Enums\EmployeeDepartment;
use App\Enums\LeaveType;
use App\Enums\VLeaveType;
use CodeIgniter\Database\Migration;

class Leaves extends Migration
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
                'constraint' => LeaveType::list(),
            ],
            'vl_type' => [
                'type' => 'ENUM',
                'constraint' => VLeaveType::list(),
                'null' => true,
                'comment' => 'Applicable only if type is VACATION_LEAVE',
            ],
            'reason' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'comment' => 'Reason/Purpose of leave',
            ],
            'days' => [
                'type' => 'INT',
                'constraint' => 2,
            ],
            'start_date' => [
                'type' => 'DATETIME',
            ],
            'end_date' => [
                'type' => 'DATETIME',
            ],
            'department' => [
                'type' => 'ENUM',
                'constraint' => EmployeeDepartment::list(),
                'null' => true,
            ],
            'institution' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'venue' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'time_in' => [
                'type' => 'TIME',
                'null' => true,
            ],
            'time_out' => [
                'type' => 'TIME',
                'null' => true,
            ],
            'approve_user' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'approve_date' => [
                'type' => 'DATETIME',
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ApproveStatus::list(),
            ],
            'approval_proof' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
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
        $this->forge->createTable('leaves', true);

        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('leaves', true);
    }
}
