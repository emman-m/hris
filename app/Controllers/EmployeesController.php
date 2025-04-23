<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Enums\UserRole;
use App\Services\EmployeeService;
use App\Validations\EmployeeUserValidator;
use CodeIgniter\Exceptions\PageNotFoundException;
use Config\Database;
use Config\Services;
use Exception;

class EmployeesController extends BaseController
{
    protected $user;
    protected $employeeInfo;
    protected $education;
    protected $dependent;
    protected $employmentHistory;
    protected $affiliation;
    protected $licensure;
    protected $positionHistory;
    protected $employeeService;

    

    public function __construct()
    {
        $this->user = model('User');
        $this->employeeInfo = model('EmployeeInfo');
        $this->education = model('Education');
        $this->dependent = model('Dependent');
        $this->employmentHistory = model('EmploymentHistory');
        $this->affiliation = model('Affiliation');
        $this->licensure = model('Licensure');
        $this->positionHistory = model('PositionHistory');
        $this->employeeService = new EmployeeService();
    }

    public function index()
    {
        // Auth user
        if ($this->auth->isEmployee()) {
            throw new PageNotFoundException('Page Not Found', 404);
        }

        // Retrieve filters from the request
        $filters = [
            'role' => UserRole::EMPLOYEE->value,
            'department' => $this->request->getGet('department'),
            'status' => $this->request->getGet('status'),
            'search' => $this->request->getGet('search'),
        ];

        // Get the query builder from the model
        $queryBuilder = $this->user->getFilteredQuery($filters);

        // Apply pagination
        $data = $queryBuilder->paginate();
        $pager = $queryBuilder->pager;

        // Pagination meta
        $paginationInfo = [
            'totalItems' => $pager->getTotal(),
            'start' => ($pager->getCurrentPage() - 1) * $pager->getPerPage() + 1,
            'end' => min($pager->getCurrentPage() * $pager->getPerPage(), $pager->getTotal()),
        ];

        return view('Pages/Employees/Admin/index', [
            'data' => $data,
            'pager' => $pager,
            'paginationInfo' => $paginationInfo,
        ]);
    }

    public function download()
    {
        // Auth user
        if ($this->auth->isEmployee()) {
            // return $this->response->setStatusCode(404, 'Not Found')->setBody('Page not found');
            throw new PageNotFoundException('Page Not Found', 404);
        }

        // Retrieve filters from the request
        $filters = [
            'role' => UserRole::EMPLOYEE->value,
            'department' => $this->request->getGet('department'),
            'status' => $this->request->getGet('status'),
            'search' => $this->request->getGet('search'),
        ];

        // Get the query builder from the model
        $queryBuilder = $this->user->getFilteredQuery($filters);

        // Retrieve all results
        $results = $queryBuilder->get()->getResultArray();

        // Prepare headers and data for CSV
        $headers = ['No.', 'Name', 'Email', 'Department', 'Status'];
        // Count number
        $count = 0;
        $data = array_map(function ($row) use (&$count) {
            $count++;

            return [
                $count,
                $row['name'],
                $row['email'],
                $row['department'],
                $row['status'],
            ];
        }, $results);

        // Use the global CSV download helper
        return downloadCSV('Employees-' . date('Y-m-d H:i:s') . '.csv', $headers, $data);
    }

    public function print()
    {
        // Auth user
        if ($this->auth->isEmployee()) {
            // return $this->response->setStatusCode(404, 'Not Found')->setBody('Page not found');
            throw new PageNotFoundException('Page Not Found', 404);
        }

        // Retrieve filters from the request
        $filters = $this->request->getPost();
        // Override role
        $filters['role'] = UserRole::EMPLOYEE->value;
        // Get the query builder from the model
        $queryBuilder = $this->user->getFilteredQuery($filters);

        // Retrieve filtered data
        $data = $queryBuilder->get()->getResultArray();

        // Prepare headers for the table
        $headers = ['Name', 'Email', 'Department', 'Status'];

        // Prepare rows
        $rows = array_map(function ($item) {
            return [
                $item['name'],
                $item['email'],
                $item['department'],
                $item['status'],
            ];
        }, $data);

        // Get the name of the logged-in user
        $downloadedBy = session()->get('name') ?? 'Anonymous';

        // Render the print template and return as JSON
        $html = view('Templates/print', [
            'title' => 'Employees Report',
            'headers' => $headers,
            'rows' => $rows,
            'downloadedBy' => $downloadedBy,
        ]);

        // Return the printable content and updated CSRF token
        return $this->response->setJSON([
            'html' => $html,
            'csrfToken' => csrf_hash(),
        ]);
    }

    public function edit($userId)
    {
        // Auth user
        if ($this->auth->isEmployee()) {
            // return $this->response->setStatusCode(404, 'Not Found')->setBody('Page not found');
            throw new PageNotFoundException('Page Not Found', 404);
        }

        $user = $this->user->getUserByuserId($userId);

        // Return error if no param, or no user found, or role is not employee
        if (empty($userId) || (empty($user)) || ($user['role'] !== UserRole::EMPLOYEE->value)) {
            withToast('error', 'Employee not found.');

            return redirect()->back();
        }

        if (!session()->has('errors')) {
            $employeeInfo = $this->employeeInfo->findByUserId($userId)->idAs('ei_id')->first() ?? [];
            $educations = $this->education->findAllByUserId($userId) ?? [];
            $dependents = $this->dependent->findAllByUserId($userId) ?? [];
            $employmentHistory = $this->employmentHistory->findAllByUserId($userId) ?? [];
            $affiliationPro = $this->affiliation->findAllProByUserId($userId) ?? [];
            $affiliationSocio = $this->affiliation->findAllSocioByUserId($userId) ?? [];
            $licensure = $this->licensure->findByUserId($userId)->idAs('license_id')->first() ?? [];
            $pastPosition = $this->positionHistory->findAllPastByUserId($userId) ?? [];
            $currentPosition = $this->positionHistory->findAllCurrentByUserId($userId) ?? [];

            $context = $employeeInfo;
            $context = array_merge($context, $licensure);
            $context = array_merge($context, ['educations' => $educations]);
            $context = array_merge($context, ['dependents' => $dependents]);
            $context = array_merge($context, ['employmentHistory' => $employmentHistory]);
            $context = array_merge($context, ['affiliationPro' => $affiliationPro]);
            $context = array_merge($context, ['affiliationSocio' => $affiliationSocio]);
            $context = array_merge($context, ['pastPosition' => $pastPosition]);
            $context = array_merge($context, ['currentPosition' => $currentPosition]);

            // Render the edit template and store in flash data
            EmployeeService::parseEmployeesInfo($context);
        }

        return view('Pages/Employees/Admin/edit', ['user_id' => $userId]);

    }

    public function update()
    {
        // Auth user
        if ($this->auth->isEmployee()) {
            // return $this->response->setStatusCode(404, 'Not Found')->setBody('Page not found');
            throw new PageNotFoundException('Page Not Found', 404);
        }

        // Get the request object
        $request = Services::request();

        $post = $request->getPost();

        $validator = new EmployeeUserValidator();
        // Validate Request

        if (!$validator->runValidation($request)) {
            // Validation failed, return to the form with errors
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $validator->getErrors())
                ->with('form', $request->getPost());
        }

        // Start a database transaction
        $db = Database::connect();
        $db->transStart();

        try {
            // Insert to employees_info
            $this->employeeInfo->upsert([
                'id' => $post['ei_id'],
                'user_id' => $post['user_id'],
                'department' => $post['department'],
                'birth' => $post['ei_date_of_birth'],
                'birth_place' => $post['ei_birth_place'],
                'gender' => $post['ei_gender'],
                'status' => $post['ei_status'],
                'spouse' => $post['ei_spouse'],
                'permanent_address' => $post['ei_permanent_address'],
                'present_address' => $post['ei_present_address'],
                'fathers_name' => $post['ei_fathers_name'],
                'mothers_name' => $post['ei_mothers_name'],
                'mothers_maiden_name' => $post['ei_mothers_maiden_name'],
                'religion' => $post['ei_religion'],
                'tel' => $post['ei_tel'],
                'phone' => $post['ei_phone'],
                'nationality' => $post['ei_nationality'],
                'sss' => $post['ei_sss'],
                'date_of_coverage' => $post['ei_date_of_coverage'],
                'pagibig' => $post['ei_pagibig'],
                'tin' => $post['ei_tin'],
                'philhealth' => $post['ei_philhealth'],
                'res_cert_no' => $post['ei_res_cert_no'],
                'res_issued_on' => $post['ei_res_issued_on'],
                'res_issued_at' => $post['ei_res_issued_at'],
                'contact_person' => $post['ei_contact_person'],
                'contact_person_no' => $post['ei_contact_person_no'],
                'contact_person_relation' => $post['ei_contact_person_relation'],
                'employment_date' => $post['ei_employment_date']
            ]);

            // Education
            foreach ($post['e_level'] as $key => $value) {
                $this->education->upsert([
                    'id' => $post['e_id'][$key],
                    'user_id' => $post['user_id'],
                    'level' => $value,
                    'school_address' => $post['e_school_address'][$key],
                    'degree' => $post['e_degree'][$key] ?? null,
                    'major_minor' => $post['e_major_minor'][$key] ?? null,
                    'year_graduated' => $post['e_year_graduated'][$key] ?? null,
                ]);
            }

            // Dependents
            foreach ($post['d_name'] as $key => $value) {
                $this->dependent->upsert([
                    'id' => $post['d_id'][$key],
                    'user_id' => $post['user_id'],
                    'name' => $value,
                    'birth' => $post['d_birth'][$key] ?? null,
                    'relationship' => $post['d_relationship'][$key] ?? null,
                ]);
            }

            // Employment History
            foreach ($post['eh_name'] as $key => $value) {
                $this->employmentHistory->upsert([
                    'id' => $post['eh_id'][$key],
                    'user_id' => $post['user_id'],
                    'name' => $value,
                    'position' => $post['eh_position'][$key] ?? null,
                    'year_from' => $post['eh_year_from'][$key],
                    'year_to' => $post['eh_year_to'][$key]
                ]);
            }

            // Affiliation Pro
            foreach ($post['a_p_type'] as $key => $value) {
                if ($post['a_p_name'][$key] !== '' && $post['a_p_position'][$key] !== '') {
                    $this->affiliation->upsert([
                        'id' => $post['a_p_id'][$key],
                        'user_id' => $post['user_id'],
                        'type' => $value,
                        'name' => $post['a_p_name'][$key],
                        'position' => $post['a_p_position'][$key],
                    ]);
                }
            }

            // Affiliation Socio
            foreach ($post['a_s_type'] as $key => $value) {
                if ($post['a_s_name'][$key] !== '' && $post['a_s_position'][$key] !== '') {
                    $this->affiliation->upsert([
                        'id' => $post['a_s_id'][$key],
                        'user_id' => $post['user_id'],
                        'type' => $value,
                        'name' => $post['a_s_name'][$key],
                        'position' => $post['a_s_position'][$key],
                    ]);
                }
            }

            // Licensure
            $this->licensure->upsert([
                'id' => $post['l_id'],
                'user_id' => $post['user_id'],
                'license' => $post['l_license'],
                'year' => $post['l_year'],
                'rating' => $post['l_rating'],
                'license_no' => $post['l_license_no'],
            ]);

            // Position History
            foreach ($post['pp_is_current'] as $key => $value) {
                $this->positionHistory->upsert([
                    'id' => $post['pp_id'][$key],
                    'user_id' => $post['user_id'],
                    'is_current' => $value,
                    'position' => $post['pp_position'][$key],
                    'year_from' => $post['pp_year_from'][$key],
                    'year_to' => $post['pp_year_to'][$key],
                ]);
            }

            // Current position
            foreach ($post['cp_is_current'] as $key => $value) {
                $this->positionHistory->upsert([
                    'id' => $post['cp_id'][$key],
                    'user_id' => $post['user_id'],
                    'is_current' => $value,
                    'position' => $post['cp_position'][$key],
                    'year_from' => $post['cp_year_from'][$key],
                    'year_to' => $post['cp_year_to'][$key],
                ]);
            }

            $db->transComplete();

            // Check if the transaction was successful
            if ($db->transStatus() === false) {
                throw new Exception('Transaction failed');
            }

            // Send Notif
            $this->employeeService->sendUpdateNotif(['user_id' => $post['user_id']]);

            withToast('success', 'Employee has been updated');
        } catch (Exception $e) {
            // If any operation fails, rollback the transaction
            $db->transRollback();
            log_message('error', $e);

            withToast('error', 'Error! There was a problem saving changes.');
        }

        return redirect()->route('employees');
    }

    public function update_lock_state()
    {
        // Auth user
        if ($this->auth->isEmployee()) {
            // return $this->response->setStatusCode(404, 'Not Found')->setBody('Page not found');
            throw new PageNotFoundException('Page Not Found', 404);
        }

        $request = $this->request->getPost();

        // Validate input
        if (!isset($request['user_id']) || !isset($request['state'])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid input data.',
                'csrfToken' => csrf_hash(),
            ]);
        }

        // Determine the new status
        $state = $request['state'];

        try {
            // check if employee is existing
            $employee = $this->employeeInfo->findByUserId($request['user_id'])->first();

            if (!empty($employee)) {
                $this->employeeInfo->set('is_locked', $state)
                    ->where('user_id', $request['user_id'])
                    ->update();
            } else {
                $this->employeeInfo->insert([
                    'user_id' => $request['user_id'],
                    'is_locked' => $state,
                ]);
            }

            $stateMsg = $state ? 'Locked' : 'Unlocked';

            // Send notification
            // Fetch Employee Info
            $employeeInfo = $this->user->getUserByuserId($request['user_id']);

            $data = [
                'user_id' => $request['user_id'],
                'name' => "{$employeeInfo['first_name']} {$employeeInfo['last_name']}",
                'email' => $employeeInfo['email'],
                'action_status' => $stateMsg
            ];

            $this->employeeService->sendLockUnlockNotif($data);

            // Return the response with updated CSRF token
            return $this->response->setJSON([
                'success' => true,
                'message' => "Employee's information is now $stateMsg",
                'csrfToken' => csrf_hash(),
            ]);

        } catch (Exception $e) {
            // Log the error
            log_message('error', 'Failed to update Employee status: ' . $e->getMessage());

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to update Employee status.',
                'csrfToken' => csrf_hash(),
            ]);
        }
    }
}
