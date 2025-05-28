<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\User;
use App\Models\UserInfo;
use App\Services\AuthService;
use App\Validations\Auth\ForgotPasswordValidator;
use App\Validations\Auth\NewPasswordValidator;
use CodeIgniter\Exceptions\PageNotFoundException;
use Config\Database;
use Config\Services;
use Exception;

class AuthController extends BaseController
{
    protected $user;
    protected $userInfo;
    protected $employeeInfo;
    protected $authService;

    public function __construct()
    {
        $this->user = model('User');
        $this->userInfo = model('UserInfo');
        $this->employeeInfo = model('EmployeeInfo');
        $this->authService = new AuthService();
    }

    public function login()
    {
        if ($this->request->getMethod() == 'POST') {
            // Validate form
            $rules = [
                'email' => 'required',
                'password' => 'required'
            ];

            if (!$this->validate($rules)) {
                // If validation fails, show errors
                session()->setFlashdata('error', $this->validator->listErrors());
            } else {
                $email = $this->request->getPost('email');
                $password = $this->request->getPost('password');

                // Get user by email
                $user = $this->user->getUserByEmail($email);

                if ($user && ($user['status'] === UserStatus::ACTIVE->value) && ($user['deleted_at'] === null)) {
                    // Get user info if user exists
                    $userinfo = $this->userInfo->where('user_id', $user['id'])->first();

                    if ($userinfo && password_verify($password, $user['password'])) {
                        // If user is found and password is correct
                        $session = session();
                        $session->set([
                            'id' => $user['id'],
                            'user_id' => $user['user_id'],
                            'email' => $user['email'],
                            'name' => $userinfo['first_name'] . ' ' . $userinfo['middle_name'] . ' ' . $userinfo['last_name'],
                            'role' => $user['role'],
                            'isLoggedIn' => true,
                            'initials' => $userinfo['first_name'][0] . $userinfo['last_name'][0]
                        ]);

                        if ($user['role'] === UserRole::EMPLOYEE->value) {
                            $employeeInfo = $this->employeeInfo->where('user_id', $user['user_id'])->first();

                            $session->set([
                                'employee_id' => $employeeInfo['employee_id'],
                                'isDepartmentHead' => $employeeInfo['is_department_head'],
                            ]);
                        }

                        // Redirect to dashboard
                        return redirect()->route('dashboard');
                    } else {
                        // Incorrect password
                        session()->setFlashdata('error', 'Invalid login credentials');
                    }
                } else if ($user && ($user['status'] === UserStatus::INACTIVE->value)) {
                    session()->setFlashdata('error', 'Account disabled. If you believe this is an error, please contact support.');
                } else {
                    // User not found with that email
                    session()->setFlashdata('error', 'Invalid login credentials');
                }
            }
        }

        // Return the login view if not POST or after validation failure
        return view('Pages/Auth/login');
    }

    public function forgot_password()
    {
        return view('Pages/Auth/forgot-password');
    }

    public function forgot_password_store()
    {
        // Get the request object
        $request = Services::request();

        $validator = new ForgotPasswordValidator();
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
            $user = $this->user->getUserByEmail($post['email']);
            $code = $this->generateCode();

            $this->user->update($user['id'], [
                'code' => $code['code']
            ]);

            $user['code'] = $code['hashed_code'];

            // Commit the transaction
            $db->transComplete();

            // Check if the transaction was successful
            if ($db->transStatus() === false) {
                throw new Exception('Transaction failed');
            }

            // Send Notif
            $this->authService->sendCodeToEmail($user);

            withSwal('info', 'Please check your email for the next step.', 'Verification Sent!');
        } catch (\Throwable $e) {
            // Rollback transaction in case of error
            $db->transRollback();
            log_message('warning', $e->getMessage());

            withToast('error', 'Error! There was a problem with your request.');
        }

        return redirect()->route('login');
    }

    public function new_password()
    {
        $email = $this->request->getGet('email');
        $code = $this->request->getGet('code');

        // throw 404 if email or code is empty
        if (empty($email) || empty($code)) {
            throw new PageNotFoundException('Page Not Found', 404);
        }

        // Check if the email and code are valid
        $user = $this->user->getUserByEmail($email);
        if (!empty($user)) {
            if (!password_verify($user['code'], $code)) {
                throw new PageNotFoundException('Page Not Found', 404);
            }
        } else {
            throw new PageNotFoundException('Page Not Found', 404);
        }

        $data = [
            'email' => $email,
            'code' => $code
        ];

        return view('Pages/Auth/new-password', $data);
    }

    public function new_password_store()
    {
        // Get the request object
        $request = Services::request();
        $post = $request->getPost();

        $validator = new NewPasswordValidator();
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
            $user = $this->user->getUserByEmail($post['email']);
            $this->user->update($user['id'], [
                'password' => password_hash($post['password'], PASSWORD_BCRYPT),
                'code' => null
            ]);

            // Commit the transaction
            $db->transComplete();

            // Check if the transaction was successful
            if ($db->transStatus() === false) {
                throw new Exception('Transaction failed');
            }

            // Send Notif
            $this->authService->sendSuccessChangePasswordNotif($user);

            withToast('success', 'Success! Password has been changed.');
        } catch (\Throwable $e) {
            // Rollback transaction in case of error
            $db->transRollback();
            log_message('warning', $e->getMessage());

            withToast('error', 'Error! There was a problem changing your password.');
        }

        return redirect()->route('login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('login');
    }

    protected function generateCode()
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 6; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return [
            'code' => $randomString,
            'hashed_code' => password_hash($randomString, PASSWORD_BCRYPT)
        ];
    }
}