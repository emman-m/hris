<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Services\UserService;
use App\Validations\Users\UpdateValidator;
use App\Validations\Users\UserValidator;
use CodeIgniter\Exceptions\PageNotFoundException;
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
    protected $turnOverReport;
    protected $pager;
    protected $userService;

    public function __construct()
    {
        $this->user = model('User');
        $this->usersInfo = model('UserInfo');
        $this->employeeInfo = model('EmployeeInfo');
        $this->education = model('Education');
        $this->dependent = model('Dependent');
        $this->employmentHistory = model('EmploymentHistory');
        $this->affiliation = model('Affiliation');
        $this->licensure = model('Licensure');
        $this->positionHistory = model('PositionHistory');
        $this->turnOverReport = model('TurnoverReport');
        $this->pager = Services::pager();
        $this->userService = new UserService();
    }

    public function index()
    {
        // Auth user
        if ($this->auth->isEmployee()) {
            throw new PageNotFoundException('Page Not Found', 404);
        }

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
        // Auth user
        if ($this->auth->isEmployee()) {
            throw new PageNotFoundException('Page Not Found', 404);
        }

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
        // Auth user
        if ($this->auth->isEmployee()) {
            throw new PageNotFoundException('Page Not Found', 404);
        }

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
        // Auth user
        if ($this->auth->isEmployee()) {
            throw new PageNotFoundException('Page Not Found', 404);
        }

        return view('Pages/Users/create');
    }

    public function store()
    {
        // Auth user
        if ($this->auth->isEmployee()) {
            throw new PageNotFoundException('Page Not Found', 404);
        }

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
                    'employee_id' => $post['employee_id']
                ]);
            }

            $db->transComplete();
            // Check if the transaction was successful
            if ($db->transStatus() === false) {
                throw new Exception('Transaction failed');
            }

            // Send Notif
            $data = [
                'user_id' => $userId,
                'email' => $post['email'],
                'first_name' => $post['first_name'],
                'last_name' => $post['last_name']
            ];

            $this->userService->sendStoreNotif($data);

            withToast('success', 'Success! New ' . $post['role'] . ' has been added.');
        } catch (Exception $e) {
            $db->transRollback();
            log_message('warning', $e);

            withToast('error', 'Error! There was a problem saving user.');
        }

        return redirect()->route('users');
    }

    public function edit($userId)
    {
        // Auth user
        if ($this->auth->isEmployee()) {
            throw new PageNotFoundException('Page Not Found', 404);
        }

        $user = $this->user->getUserByuserId($userId);

        if (!$user) {
            withToast('error', 'User not found.');

            return redirect()->back();
        }

        return view('Pages/Users/edit', $user);
    }

    public function update()
    {
        // Auth user
        if ($this->auth->isEmployee()) {
            throw new PageNotFoundException('Page Not Found', 404);
        }

        // Get the request object
        $request = Services::request();

        $post = $request->getPost();

        // Validation
        $validator = new UpdateValidator($post['user_id']);

        if (!$validator->runValidation($request)) {
            // Validation failed, return to the form with errors
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $validator->getErrors());
        }

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

            if ($post['role'] === UserRole::EMPLOYEE->value) {
                $employee = $this->employeeInfo->where('user_id', $post['user_id'])->first();

                if (!empty($employee)) { // Update employee_id if exists
                    $updateData = [
                        'employee_id' => $post['employee_id']
                    ];
                    $this->employeeInfo
                        ->set($updateData)
                        ->where('user_id', $post['user_id'])
                        ->update();
                } else { // Insert employee_id if not exists
                    $this->employeeInfo->insert([
                        'user_id' => $post['user_id'],
                        'employee_id' => $post['employee_id']
                    ]);
                }
            }

            // Commit the transaction
            $db->transComplete();

            // Check if the transaction was successful
            if ($db->transStatus() === false) {
                throw new Exception('Transaction failed');
            }

            // Send Notif
            $data = [
                'user_id' => $post['user_id'],
                'email' => $post['email'],
                'first_name' => $post['first_name'],
                'last_name' => $post['last_name']
            ];

            $this->userService->sendUpdateNotif($data);

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
        // Auth user
        if ($this->auth->isEmployee()) {
            throw new PageNotFoundException('Page Not Found', 404);
        }

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

            if ($status === UserStatus::ACTIVE->value) {
                $this->turnOverReport
                    ->where('user_id', $request['user_id'])
                    ->like('created_at', date('Y-m-d'))
                    ->delete();
            } else {
                $this->turnOverReport->insert([
                    'user_id' => $request['user_id'],
                ]);
            }

            // Update the user status
            $this->user->update($request['user_id'], ['status' => $status]);

            // Send Notif
            $data = [
                'user_id' => $request['user_id'],
                'email' => $user['email'],
                'first_name' => $user['first_name'],
                'last_name' => $user['last_name'],
                'status' => $status
            ];

            $this->userService->sendUpdateStatusNotif($data);

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
