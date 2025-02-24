<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use Config\Services;

class HomeController extends BaseController
{
    public function index()
    {
        return view('Pages/dashboard');
    }
}