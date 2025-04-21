<?php

namespace App\Database\Seeds\Test;

use App\Database\Seeds\Constant\EmployeeConst;
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

        $employeeIds = EmployeeConst::employeeIds();

        // Use the chunk method to process users in batches
        chunk($builder, 100, function ($users) use ($faker, $employeeIds) {
            $data = [];
            foreach ($users as $user) {

                $data[] = [
                    'user_id' => $user['id'],
                    'is_locked' => false,
                    'employee_id' => $employeeIds[$user['id']],
                    'department' => $faker->randomElement(EmployeeDepartment::list()),
                    'birth' => $faker->date('Y-m-d', '-20 years'),
                    'birth_place' => $faker->city(),
                    'gender' => $faker->randomElement(['Male', 'Female']),
                    'status' => $faker->randomElement(EmployeeStatus::list()),
                    'spouse' => $faker->optional()->name(),
                    'permanent_address' => $faker->address(),
                    'present_address' => $faker->address(),
                    'fathers_name' => $faker->name('Male'),
                    'mothers_name' => $faker->name('Female'),
                    'mothers_maiden_name' => $faker->lastName(),
                    'religion' => $faker->randomElement(['Catholic', 'Christian', 'Muslim', 'Others']),
                    'tel' => $faker->phoneNumber(),
                    'phone' => $faker->e164PhoneNumber(),
                    'nationality' => 'Filipino',
                    'sss' => $faker->numerify('##-#######-#'),
                    'date_of_coverage' => $faker->date('Y-m-d', '-5 years'),
                    'pagibig' => $faker->numerify('####-####-####'),
                    'tin' => $faker->numerify('###-###-###'),
                    'philhealth' => $faker->numerify('##-#######-#'),
                    'res_cert_no' => $faker->numerify('#######'),
                    'res_issued_on' => $faker->date('Y-m-d'),
                    'res_issued_at' => $faker->city(),
                    'contact_person' => $faker->name(),
                    'contact_person_no' => $faker->e164PhoneNumber(),
                    'contact_person_relation' => $faker->randomElement(['Parent', 'Sibling', 'Spouse', 'Friend']),
                    'employment_date' => $faker->date('Y-m-d', '-5 years'),
                ];
            }

            // Insert the chunked data into the 'users_info' table
            $this->db->table('employees_info')->insertBatch($data);
        });
    }
}
