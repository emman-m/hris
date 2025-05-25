<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDepartmentHeadColumn extends Migration
{
    public function up()
    {
        $this->forge->addColumn('employees_info', [
            'is_department_head' => [
                'type' => 'BOOLEAN',
                'default' => false,
                'after' => 'is_locked'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('employees_info', 'is_department_head');
    }
} 