<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\Affiliation;
use App\Models\Dependent;
use App\Models\Education;
use App\Models\EmployeeInfo;
use App\Models\EmploymentHistory;
use App\Models\Licensure;
use App\Models\PositionHistory;
use App\Models\User;
use App\Models\UserInfo;
use App\Validations\EmployeeUserValidator;
use App\Validations\Users\UpdateValidator;
use App\Validations\Users\UserValidator;
use CodeIgniter\HTTP\Request;
use Config\Database;
use Config\Services;
use Exception;


class UserController extends BaseController
{
    protected $user;
    protected $usersInfo;
    protected $employeeInfo;
    protected $education;
    protected $dependent;
    protected $employmentHistory;
    protected $affiliation;
    protected $licensure;
    protected $positionHistory;
    protected $pager;

    public function __construct()
    {
        $this->user = new User();
        $this->usersInfo = new UserInfo();
        $this->employeeInfo = new EmployeeInfo;
        $this->education = new Education();
        $this->dependent = new Dependent();
        $this->employmentHistory = new EmploymentHistory();
        $this->affiliation = new Affiliation();
        $this->licensure = new Licensure();
        $this->positionHistory = new PositionHistory();

        $this->pager = Services::pager();
    }

    public function index()
    {
        // Retrieve filters from the request
        $filters = [
            'role' => $this->request->getGet('role'),
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

        return view('Pages/Users/index', [
            'data' => $data,
            'pager' => $pager,
            'paginationInfo' => $paginationInfo,
        ]);
    }

    public function download()
    {
        // Retrieve filters from the request
        $filters = [
            'role' => $this->request->getGet('role'),
            'status' => $this->request->getGet('status'),
            'search' => $this->request->getGet('search'),
        ];

        // Get the query builder from the model
        $queryBuilder = $this->user->getFilteredQuery($filters);

        // Retrieve all results
        $results = $queryBuilder->get()->getResultArray();

        // Prepare headers and data for CSV
        $headers = ['No.', 'Name', 'Email', 'Role', 'Status'];
        // Count number
        $count = 0;
        $data = array_map(function ($row) use (&$count) {
            $count++;

            return [
                $count,
                $row['name'],
                $row['email'],
                $row['role'],
                $row['status'],
            ];
        }, $results);

        // Use the global CSV download helper
        return downloadCSV('User-' . date('Y-m-d H:i:s') . '.csv', $headers, $data);
    }

    public function print()
    {
        // Retrieve filters from the request
        $filters = $this->request->getPost();
        // Get the query builder from the model
        $queryBuilder = $this->user->getFilteredQuery($filters);

        // Retrieve filtered data
        $data = $queryBuilder->get()->getResultArray();

        // Prepare headers for the table
        $headers = ['Name', 'Email', 'Role', 'Status'];

        // Prepare rows
        $rows = array_map(function ($item) {
            return [
                $item['name'],
                $item['email'],
                $item['role'],
                $item['status'],
            ];
        }, $data);

        // Get the name of the logged-in user
        $downloadedBy = session()->get('name') ?? 'Anonymous';

        // Render the print template and return as JSON
        $html = view('Templates/print', [
            'title' => 'Users List',
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

    public function create()
    {
        return view('Pages/Users/create');
    }

    public function store()
    {
        // Get the request object
        $request = Services::request();

        $validator = new UserValidator();
        if (!$validator->runValidation($request)) {
            // Validation failed, return to the form with errors
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $validator->getErrors());
        }

        $post = $request->getPost();

        // Start a database transaction
        $db = Database::connect();
        $db->transStart();

        try {
            // Insert to users
            $userData = [
                'role' => $post['role'],
                'email' => $post['email'],
                'password' => password_hash($post['password'], PASSWORD_BCRYPT),
                'status' => UserStatus::ACTIVE->value
            ];
            $userId = $this->user->insert($userData);

            // Insert to users_info
            $usersInfoData = [
                'user_id' => $userId,
                'first_name' => $post['first_name'],
                'middle_name' => $post['middle_name'],
                'last_name' => $post['last_name']
            ];
            $this->usersInfo->insert($usersInfoData);

            if ($post['role'] === UserRole::EMPLOYEE->value) {
                $this->employeeInfo->insert([
                    'user_id' => $userId,
                    'department' => $post['department']
                ]);
            }

            $db->transComplete();

            withToast('success', 'Success! New ' . $post['role'] . ' has been added.');
        } catch (Exception $e) {
            $db->transRollback();
            log_message('warning', $e);

            withToast('error', 'Error! There was a problem saving user.');
        }

        return redirect()->route('users');
    }

    // Save new Admin user
    private function createAdminUser($request)
    {
        // Validate Request
        $validator = new UserValidator();
        if (!$validator->runValidation($request)) {
            // Validation failed, return to the form with errors
            return redirect()->back()->withInput()->with('errors', $validator->getErrors());
        }

        $post = $request->getPost();

        // Start a database transaction
        $db = Database::connect();
        $db->transStart();

        try {
            // Insert to users
            $userData = [
                'role' => $post['role'],
                'email' => $post['email'],
                'password' => password_hash($post['password'], PASSWORD_BCRYPT),
                'status' => UserStatus::ACTIVE->value
            ];
            $userId = $this->user->insert($userData);

            // Insert to users_info
            $usersInfoData = [
                'user_id' => $userId,
                'first_name' => $post['first_name'],
                'middle_name' => $post['middle_name'],
                'last_name' => $post['last_name']
            ];
            $this->usersInfo->insert($usersInfoData);

            // If both operations are successful, commit the transaction
            $db->transComplete();

            withToast('success', 'Success! New user has been added.');
        } catch (Exception $e) {
            // If any operation fails, rollback the transaction
            $db->transRollback();

            withToast('error', 'Error! There was a problem saving user.');
        }

        return redirect()->route('users');
    }

    private function createEmployeeUser($request)
    {
        $post = $request->getPost();

        $validator = new EmployeeUserValidator();
        // Validate Request

        if (!$validator->runValidation($request)) {
            log_message('info', json_encode($validator->getErrors()));
            // Validation failed, return to the form with errors
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $validator->getErrors())
                ->with('formData', $request->getPost());
        }


        // Start a database transaction
        $db = Database::connect();
        $db->transStart();

        try {
            // Insert to users
            $userData = [
                'role' => $post['role'],
                'email' => $post['email'],
                'password' => password_hash($post['password'], PASSWORD_BCRYPT),
                'status' => UserStatus::ACTIVE->value
            ];
            $userId = $this->user->insert($userData);

            // Insert to users_info
            $usersInfoData = [
                'user_id' => $userId,
                'first_name' => $post['first_name'],
                'middle_name' => $post['middle_name'],
                'last_name' => $post['last_name']
            ];
            $this->usersInfo->insert($usersInfoData);

            // Insert to employees_info
            $this->employeeInfo->insert([
                'user_id' => $userId,
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
                $this->education->insert([
                    'user_id' => $userId,
                    'level' => $value,
                    'school_address' => $post['e_school_address'][$key],
                    'degree' => $post['e_degree'][$key] ?? null,
                    'major_minor' => $post['e_major_minor'][$key] ?? null,
                    'year_graduated' => $post['e_year_graduated'][$key] ?? null,
                ]);
            }

            // Dependents
            foreach ($post['d_name'] as $key => $value) {
                $this->dependent->insert([
                    'user_id' => $userId,
                    'name' => $value,
                    'birth' => $post['d_birth'][$key] ?? null,
                    'relationship' => $post['d_relationship'][$key] ?? null,
                ]);
            }

            // Employment History
            foreach ($post['eh_name'] as $key => $value) {
                $this->employmentHistory->insert([
                    'user_id' => $userId,
                    'name' => $value,
                    'position' => $post['eh_position'][$key],
                    'year_from' => $post['eh_year_from'][$key],
                    'year_to' => $post['eh_year_to'][$key]
                ]);
            }

            // Affiliation Pro
            foreach ($post['a_p_type'] as $key => $value) {
                if ($post['a_p_name'][$key] !== '' && $post['a_p_position'][$key] !== '') {
                    $this->affiliation->insert([
                        'user_id' => $userId,
                        'type' => $value,
                        'name' => $post['a_p_name'][$key],
                        'position' => $post['a_p_position'][$key],
                    ]);
                }
            }

            // Affiliation Socio
            foreach ($post['a_s_type'] as $key => $value) {
                if ($post['a_s_name'][$key] !== '' && $post['a_s_position'][$key] !== '') {
                    $this->affiliation->insert([
                        'user_id' => $userId,
                        'type' => $value,
                        'name' => $post['a_s_name'][$key],
                        'position' => $post['a_s_position'][$key],
                    ]);
                }
            }

            // Licensure
            $this->licensure->insert([
                'user_id' => $userId,
                'license' => $post['l_license'],
                'year' => $post['l_year'],
                'rating' => $post['l_rating'],
                'license_no' => $post['l_license_no'],
            ]);

            // Position History
            foreach ($post['pp_is_current'] as $key => $value) {
                $this->positionHistory->insert([
                    'user_id' => $userId,
                    'is_current' => $value,
                    'position' => $post['pp_position'][$key],
                    'year_from' => $post['pp_year_from'][$key],
                    'year_to' => $post['pp_year_to'][$key],
                ]);
            }

            // If both operations are successful, commit the transaction
            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new Exception('Transaction failed');
            }

            withToast('success', 'Success! New user has been added.');
        } catch (Exception $e) {
            // If any operation fails, rollback the transaction
            $db->transRollback();
            log_message('info', $e);

            withToast('error', 'Error! There was a problem saving user.');
        }

        return redirect()->route('users');
    }

    public function edit($userId)
    {
        $user = $this->user->getUserByuserId($userId);
        log_message('info', json_encode(['user' => $user]));
        if (!$user) {
            withToast('error', 'User not found.');

            return redirect()->back();
        }

        return view('Pages/Users/edit', $user);
    }

    public function update()
    {
        // Get the request object
        $request = Services::request();

        // Validation
        $validator = new UpdateValidator();
        if (!$validator->runValidation($request)) {
            log_message('debug', json_encode($validator->getErrors()));
            // Validation failed, return to the form with errors
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $validator->getErrors());
        }

        $post = $request->getPost();
        log_message('info', json_encode(['post' => $post]));

        // Start a database transaction
        $db = Database::connect();
        $db->transStart();

        try {
            // Prepare user data
            $userData = [
                'role' => $post['role'],
                'email' => $post['email']
            ];

            // If password is provided, hash it
            if (!empty($post['password'])) {
                $userData['password'] = password_hash($post['password'], PASSWORD_BCRYPT);
            }

            // Update the users table
            $this->user->update($post['user_id'], $userData);

            // Prepare users_info data
            $usersInfoData = [
                'first_name' => $post['first_name'],
                'middle_name' => $post['middle_name'],
                'last_name' => $post['last_name']
            ];

            // Update the users_info table
            $this->usersInfo->update($post['user_id'], $usersInfoData);

            // Commit the transaction
            $db->transComplete();

            // Check if the transaction was successful
            if ($db->transStatus() === false) {
                throw new Exception('Transaction failed');
            }

            withToast('success', 'Success! ' . $post['role'] . ' has been updated.');

            return redirect()->route('users');
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $db->transRollback();
            log_message('warning', $e->getMessage());

            withToast('error', 'Error! There was a problem saving the user.');

            return redirect()->route('users');
        }
    }

    public function update_status()
    {
        $request = $this->request->getPost();

        // Validate input
        if (!isset($request['user_id']) || !isset($request['status'])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid input data.',
            ]);
        }

        // Determine the new status
        $status = $request['status']
            ? UserStatus::ACTIVE->value
            : UserStatus::INACTIVE->value;

        try {
            $user = $this->user->getUserByuserId($request['user_id']);

            // Update the user status
            $this->user->update($request['user_id'], ['status' => $status]);

            // Return the response with updated CSRF token
            return $this->response->setJSON([
                'success' => true,
                'status' => $status,
                'message' => $user['first_name'] . ' ' . $user['last_name'] . ' is now ' . $status,
                'csrfToken' => csrf_hash(),
            ]);
        } catch (Exception $e) {
            // Log the error
            log_message('error', 'Failed to update user status: ' . $e->getMessage());

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to update user status.',
                'csrfToken' => csrf_hash(),
            ]);
        }
    }

}
