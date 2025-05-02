<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Policy\AuthPolicy;
use App\Services\AccountService;
use App\Validations\Account\UpdateValidator;
use Config\Database;
use Config\Services;
use Exception;

class AccountController extends BaseController
{
    protected $user;
    protected $usersInfo;
    protected $employeeInfo;

    public function __construct()
    {
        $this->user = model('User');
        $this->usersInfo = model('UserInfo');
        $this->employeeInfo = model('EmployeeInfo');
    }
    public function index()
    {
        $userId = session()->get('user_id');
        // Employee Info
        $employeeInfo = $this->employeeInfo
            ->findByUserId($userId)
            ->first();

        //User info
        $userInfo = $this->user->getUserByuserId($userId);

        // Account Service
        $accountService = new AccountService();
        // Parse Account Info
        $accountService->parseData($userInfo);

        return view('Pages/Account/edit', ['is_locked' => $employeeInfo['is_locked'] ?? false]);
    }

    public function update()
    {

        // Get the request object
        $request = Services::request();
        $userId = session()->get('user_id');
        $post = $request->getPost();

        // Validation
        $validator = new UpdateValidator($userId);

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
                'email' => $post['email']
            ];

            // If password is provided, hash it
            if (!empty($post['password'])) {
                $userData['password'] = password_hash($post['password'], PASSWORD_BCRYPT);
            }

            // Restrict employee for saving
            if (!$this->auth->isEmployee()) {
                // Update the users table
                $this->user->update($userId, $userData);
            }

            // Prepare users_info data
            $usersInfoData = [
                'first_name' => $post['first_name'],
                'middle_name' => $post['middle_name'],
                'last_name' => $post['last_name']
            ];

            // Update the users_info table
            $this->usersInfo->update($userId, $usersInfoData);

            // Commit the transaction
            $db->transComplete();

            // Check if the transaction was successful
            if ($db->transStatus() === false) {
                throw new Exception('Transaction failed');
            }

            // Set new session data
            session()->set(
                [
                    'email' => $userData['email'],
                    'name' => $usersInfoData['first_name'] . ' ' . $usersInfoData['middle_name'] . ' ' . $usersInfoData['last_name'],
                    'initials' => $usersInfoData['first_name'][0] . $usersInfoData['last_name'][0]
                ]
            );

            withToast('success', 'Success! Your Account Information has been updated.');

        } catch (Exception $e) {
            // Rollback transaction in case of error
            $db->transRollback();
            log_message('warning', $e->getMessage());

            withToast('error', 'Error! There was a problem saving changes.');

        }

        return redirect()->back();
    }
}
