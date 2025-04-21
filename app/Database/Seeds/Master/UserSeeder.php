<?php

namespace App\Database\Seeds\Master;

use App\Enums\UserRole;
use CodeIgniter\Database\Seeder;
use Faker\Factory;

class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();

        // default user
        $data = [
            [
                'status' => 'active',
                'role' => UserRole::ADMIN->value,
                'email' => 'admin@hris.com',
                'password' => password_hash('password', PASSWORD_BCRYPT),
                'created_at' => $faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
