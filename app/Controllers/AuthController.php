<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AuthController extends BaseController
{
    protected $userModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
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

                $user = $this->userModel->getUserByEmail($email);

                if ($user && password_verify($password, $user['password'])) {
                    $session = session();
                    $session->set(
                        [
                            'id' => $user['id'],
                            'email' => $user['email'],
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

        // Page title
        $data['title'] = 'HRIS | Login';

        return view('Pages/Auth/login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
