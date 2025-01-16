<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class HomeController extends BaseController
{
    public function index()
    {
        withToast('success', 'Success');
        return view('Pages/dashboard');
    }
}