<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Enums\UserRole;
use App\Models\UserModel;


class UserController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // Get the current page number
        $page = $this->request->getVar('page') ?? 1;

        // Define the number of items per page
        $perPage = 10;
        
        // Get paginated results
        $data['results'] = $this->userModel->paginate();
        
        // Set up the pager
        $data['pager'] = $this->userModel->pager;

        return view('Pages/Users/index', $data);
    }
}