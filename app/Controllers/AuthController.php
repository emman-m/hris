<?php

namespace App\Controllers;

use App\Controllers\BaseController;
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
                session()->setFlashdata('error', $this->validator->listErrors());
            } else {
                $email = $this->request->getPost('email');
                $password = $this->request->getPost('password');

                $user = $this->user->getUserByEmail($email);
                $userinfo = $this->userInfo->where('user_id', $user['id'])->first();

                if ($user && password_verify($password, $user['password'])) {
                    $session = session();
                    $session->set(
                        [
                            'id' => $user['id'],
                            'email' => $user['email'],
                            'name' => $userinfo['first_name'] . ' ' . $userinfo['middle_name'] . ' ' . $userinfo['last_name'],
                            'role' => $user['role'],
                            'isLoggedIn' => true,
                        ]
                    );

                    // return redirect()->to('/hris/dashboard');
                    return redirect()->route('dashboard');

                } else {
                    session()->setFlashdata('error', 'Invalid login credentials');
                }
            }
        }

        return view('Pages/Auth/login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
