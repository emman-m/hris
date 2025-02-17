<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Enums\UserRole;
use App\Models\EmployeesFile;
use CodeIgniter\Exceptions\PageNotFoundException;

class EmployeesFileController extends BaseController
{
    protected $employeeFile;

    public function __construct()
    {
        $this->employeeFile = new EmployeesFile();
    }
    public function index($user_id = null)
    {
        // $role = session()->get('role');
        // if (!$user_id && $role !== UserRole::EMPLOYEE->value)  {
        //     throw new PageNotFoundException('Page Not Found', 404);
        // }

        return view('Pages/Files/index');
    }
}
