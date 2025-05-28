<?php

namespace App\Database\Seeds\Test;

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
            [
                'status' => 'active',
                'role' => UserRole::HR_ADMIN->value,
                'email' => 'hradmin@hris.com',
                'password' => password_hash('password', PASSWORD_BCRYPT),
                'created_at' => $faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'status' => 'active',
                'role' => UserRole::HR_STAFF->value,
                'email' => 'hrstaff@hris.com',
                'password' => password_hash('password', PASSWORD_BCRYPT),
                'created_at' => $faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'status' => 'active',
                'role' => UserRole::EMPLOYEE->value,
                'email' => 'employee@hris.com',
                'password' => password_hash('password', PASSWORD_BCRYPT),
                'created_at' => $faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        for ($i = 1; $i <= 138; $i++) {
            $data[] = [
                'status' => 'active',
                'role' => UserRole::EMPLOYEE->value,
                'email' => $faker->unique()->email(),
                'password' => password_hash('password', PASSWORD_BCRYPT),
                'created_at' => $faker->dateTimeBetween('-15 day', 'now')->format('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        $this->db->table('users')->insertBatch($data);
    }
}
