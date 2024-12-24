<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'status' => 'active',
                'role' => 'admin',
                'email' => 'admin',
                'password' => password_hash('password', PASSWORD_BCRYPT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'status' => 'active',
                'role' => 'hr_admin',
                'email' => 'hradmin',
                'password' => password_hash('password', PASSWORD_BCRYPT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        
        $this->db->table('users')->insertBatch($data);
    }
}
