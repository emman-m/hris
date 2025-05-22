<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Enums\EmployeeDepartment;
use App\Enums\UserRole;
use CodeIgniter\Exceptions\PageNotFoundException;

class DepartmentHeadController extends BaseController
{
    protected $user;
    protected $employeeInfo;

    public function __construct()
    {
        $this->user = model('User');
        $this->employeeInfo = model('EmployeeInfo');
    }

    public function index()
    {
        // Only admin and HR admin can access this page
        if ($this->auth->isEmployee()) {
            throw new PageNotFoundException('Page Not Found', 404);
        }

        // Get all departments and their current heads
        $departments = [];
        foreach (EmployeeDepartment::list() as $department) {
            $departments[$department] = $this->getDepartmentHead($department);
        }

        return view('Pages/DepartmentHeads/index', [
            'departments' => $departments
        ]);
    }

    public function assign()
    {
        // Only admin and HR admin can access this page
        if ($this->auth->isEmployee()) {
            throw new PageNotFoundException('Page Not Found', 404);
        }
        $request = $this->request->getPost();

        $department = $this->request->getPost('department');
        $userId = $this->request->getPost('user_id');

        log_message('debug', 'Department: ' . json_encode($request));
        // Validate department
        if (!in_array($department, EmployeeDepartment::list())) {
            log_message('debug', 'Invalid department selected: ' . $department);
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid department selected.'
            ]);
        }

        // Get user and validate
        $user = $this->user->find($userId);
        if (!$user || $user['role'] !== UserRole::EMPLOYEE->value) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid user selected.'
            ]);
        }

        // Update employee info with department head role
        $this->employeeInfo->where('user_id', $userId)
            ->set(['is_department_head' => true])
            ->update();

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Department head assigned successfully.'
        ]);
    }

    public function remove()
    {
        // Only admin and HR admin can access this page
        if ($this->auth->isEmployee()) {
            throw new PageNotFoundException('Page Not Found', 404);
        }

        $userId = $this->request->getPost('user_id');

        // Update employee info to remove department head role
        $this->employeeInfo->where('user_id', $userId)
            ->set(['is_department_head' => false])
            ->update();

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Department head removed successfully.'
        ]);
    }

    public function searchEmployees()
    {
        // Only admin and HR admin can access this page
        if ($this->auth->isEmployee()) {
            throw new PageNotFoundException('Page Not Found', 404);
        }

        $search = $this->request->getGet('search');
        $department = $this->request->getGet('department');

        // Get employees from the specified department
        $employees = $this->user->getFilteredQuery([
            'role' => UserRole::EMPLOYEE->value,
            'department' => $department,
            'search' => $search
        ])->findAll();

        return $this->response->setJSON($employees);
    }

    private function getDepartmentHead($department)
    {
        return $this->user->getFilteredQuery([
            'role' => UserRole::EMPLOYEE->value,
            'department' => $department
        ])->where('employees_info.is_department_head', true)
          ->first();
    }
} 