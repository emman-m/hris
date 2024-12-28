<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class HomeController extends BaseController
{
    public function index()
    {
        return view('AuthLayout/header')
            . view('Dashboard/dashboard')
            . view('AuthLayout/footer');
    }
}