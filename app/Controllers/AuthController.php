<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Enums\UserStatus;
use App\Models\User;
use App\Models\UserInfo;

class AuthController extends BaseController
{
    protected $user;
    protected $userInfo;
    public function __construct()
    {
        $this->user = new User();
        $this->userInfo = new UserInfo();
    }
    public function login()
    {
        if ($this->request->getMethod() == 'POST') {
            // Validate form
            $rules = [
                'email' => 'required|valid_email',
                'password' => 'required|min_length[8]'
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
                        $session->set(
                            [
                                'id' => $user['id'],
                                'user_id' => $user['user_id'],
                                'email' => $user['email'],
                                'name' => $userinfo['first_name'] . ' ' . $userinfo['middle_name'] . ' ' . $userinfo['last_name'],
                                'role' => $user['role'],
                                'isLoggedIn' => true,
                                'initials' => $userinfo['first_name'][0] . $userinfo['last_name'][0]
                            ]
                        );

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

    public function logout()
    {
        session()->destroy();
        return redirect()->to('login');
    }
}
