<?php

namespace App\Database\Seeds;

use App\Database\Seeds\Test\EmployeeInfoSeeder;
use App\Database\Seeds\Test\UsersInfoSeeder;
use CodeIgniter\Database\Seeder;
use App\Database\Seeds\Master\UserSeeder;
use App\Database\Seeds\Test\UserSeeder as TestUserSeeder;

class MasterSeeder extends Seeder
{
    public function run()
    {        
        if (getenv('CI_ENVIRONMENT') === 'development') {
            $this->call(TestUserSeeder::class);
            $this->call(UsersInfoSeeder::class);
            $this->call(EmployeeInfoSeeder::class);
        } else {
            $this->call(UserSeeder::class);
            $this->call(UsersInfoSeeder::class);
        }
    }
}
