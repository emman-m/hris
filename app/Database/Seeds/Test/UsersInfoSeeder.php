<?php

namespace App\Database\Seeds\Test;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class UsersInfoSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();

        // Use the chunk method to process users in batches
        chunk('users', 100, function ($users) use ($faker) {
            $data = [];
            foreach ($users as $user) {
                $data[] = [
                    'user_id' => $user['id'],
                    'first_name' => $faker->firstName(),
                    'middle_name' => $faker->randomElement([$faker->firstName(), '']),
                    'last_name' => $faker->lastName(),
                    'created_at' => $faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'deleted_at' => null,
                ];
            }

            // Insert the chunked data into the 'users_info' table
            $this->db->table('users_info')->insertBatch($data);
        });
    }
}
