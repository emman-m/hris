<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Policy\AuthPolicy;
use App\Services\BulkUserService;
use App\Validations\BulkUser\UploadValidation;
use App\Enums\UserRole;
use CodeIgniter\Exceptions\PageNotFoundException;
use Config\Database;
use Config\Services;
use Exception;

class BulkUserController extends BaseController
{
    protected $user;
    protected $bulkUserService;

    public function __construct()
    {
        $this->user = model('User');
        $this->bulkUserService = new BulkUserService();
    }

    public function create()
    {
        // Auth user - only admin and HR can access
        if ($this->auth->isEmployee()) {
            throw new PageNotFoundException('Page Not Found', 404);
        }

        return view('Pages/Users/bulk_create', [
            'roles' => UserRole::cases()
        ]);
    }

    public function download_template()
    {
        $filePath = FCPATH . 'Users/template.csv';

        // Check if file exists
        if (!file_exists($filePath)) {
            withToast('error', 'Error! Template file not found.');
            return redirect()->back();
        }

        // Use the response helper to download the file
        return $this->response->download($filePath, null)->setFileName('Users-Template.csv');
    }

    public function store()
    {
        // Auth user - only admin and HR can access
        if ($this->auth->isEmployee()) {
            throw new PageNotFoundException('Page Not Found', 404);
        }

        $request = Services::request();

        $validator = new UploadValidation();
        if (!$validator->runValidation($request)) {
            // Validation failed, return to the form with errors
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $validator->getErrors());
        }

        $csvData = $this->bulkUserService->getContent($request->getFile('file'));

        if (empty($csvData)) {
            withSwal('warning', 'User file has no valid data.', 'No data saved');
            return redirect()->route('users');
        }

        // Start a database transaction
        $db = Database::connect();
        $db->transStart();

        try {
            // Insert the user data into the database
            foreach ($csvData as $userData) {
                // Insert into users table
                $userId = $this->user->insert([
                    'role' => $userData['role'],
                    'email' => $userData['email'],
                    'password' => password_hash('password', PASSWORD_DEFAULT),
                    'status' => 'active'
                ]);

                // Insert into users_info table
                $this->user->db->table('users_info')->insert([
                    'user_id' => $userId,
                    'first_name' => $userData['first_name'],
                    'middle_name' => $userData['middle_name'],
                    'last_name' => $userData['last_name']
                ]);

                // Insert into employees_info table if role is employee
                if ($userData['role'] === UserRole::EMPLOYEE->value) {
                    $this->user->db->table('employees_info')->insert([
                        'user_id' => $userId,
                        'employee_id' => $userData['employee_id']
                    ]);
                }
            }

            // Commit the transaction
            $db->transComplete();

            // Check if the transaction was successful
            if ($db->transStatus() === false) {
                throw new Exception('Transaction failed');
            }

            withToast('success', 'Users imported successfully.');
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $db->transRollback();
            log_message('warning', $e->getMessage());

            withToast('error', 'Error! There was a problem importing the users.');
        }

        return redirect()->route('users');
    }
} 