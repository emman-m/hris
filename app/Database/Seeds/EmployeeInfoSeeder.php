<?php

namespace App\Database\Seeds;

use App\Enums\EmployeeDepartment;
use App\Enums\EmployeeStatus;
use App\Enums\UserRole;
use CodeIgniter\Database\Seeder;
use Config\Database;
use Faker\Factory;

class EmployeeInfoSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();

        $db = Database::connect();

        $builder = $db->table('users')->where('role', UserRole::EMPLOYEE->value);

        // Use the chunk method to process users in batches
        chunk($builder, 100, function ($users) use ($faker) {
            $data = [];
            foreach ($users as $user) {
                $data[] = [
                    'user_id' => $user['id'],
                    'is_locked' => false,
                    'employee_id' => $faker->numerify('E##-#####'),
                    'department' => $faker->randomElement(EmployeeDepartment::list()),
                    'birth' => $faker->date('Y-m-d', '-20 years'),
                    'birth_place' => $faker->city,
                    'gender' => $faker->randomElement(['Male', 'Female']), // Random gender
                    'status' => $faker->randomElement(EmployeeStatus::list()), // Random marital status
                    'spouse' => $faker->optional()->name, // Optional spouse name (for married status)
                    'permanent_address' => $faker->address, // Random address
                    'present_address' => $faker->address, // Random address
                    'fathers_name' => $faker->name('Male'), // Random father's name
                    'mothers_name' => $faker->name('Female'), // Random mother's name
                    'mothers_maiden_name' => $faker->lastName, // Random last name for maiden name
                    'religion' => $faker->randomElement(['Catholic', 'Christian', 'Muslim', 'Others']), // Random religion
                    'tel' => $faker->phoneNumber, // Random telephone number
                    'phone' => $faker->e164PhoneNumber, // Random mobile phone number
                    'nationality' => 'Filipino',
                    'sss' => $faker->numerify('##-#######-#'), // Random SSS number
                    'date_of_coverage' => $faker->date('Y-m-d', '-5 years'), // Random date within the last 5 years
                    'pagibig' => $faker->numerify('####-####-####'), // Random Pag-IBIG number
                    'tin' => $faker->numerify('###-###-###'), // Random TIN number
                    'philhealth' => $faker->numerify('##-#######-#'), // Random PhilHealth number
                    'res_cert_no' => $faker->numerify('#######'), // Random Residency Certificate number
                    'res_issued_on' => $faker->date('Y-m-d'), // Random issue date
                    'res_issued_at' => $faker->city, // Random issuing city
                    'contact_person' => $faker->name, // Random contact person's name
                    'contact_person_no' => $faker->e164PhoneNumber, // Random contact person's phone number
                    'contact_person_relation' => $faker->randomElement(['Parent', 'Sibling', 'Spouse', 'Friend']), // Random relation
                    'employment_date' => $faker->date('Y-m-d', '-5 years'), // Random employment start date within the last 5 years
                ];
            }

            // Insert the chunked data into the 'users_info' table
            $this->db->table('employees_info')->insertBatch($data);
        });
    }
}
