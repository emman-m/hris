<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\User;
use App\Models\UserInfo;
use App\Validations\Users\CreateAdminValidation;
use Config\Database;
use Config\Services;
use Exception;


class UserController extends BaseController
{
    protected $user;
    protected $usersInfo;
    protected $pager;

    public function __construct()
    {
        $this->user = new User();
        $this->usersInfo = new UserInfo();

        $this->pager = Services::pager();
    }

    public function index()
    {
        // Get paginated results
        $response = $this->user
            ->displayList();
        
        return view('Pages/Users/index', $response);
    }

    public function create($role)
    {
        // Validate the role (optional)
        if (!in_array($role, array_column(UserRole::cases(), 'name'))) {
            return redirect()->back()->with('error', 'Invalid role selected.');
        }

        return view('Pages/Users/Create/' . strtolower($role));
    }

    public function store()
    {
        // Get the request object
        $request = Services::request();

        $allowedRoles = [
            UserRole::ADMIN->value,
            UserRole::HR_ADMIN->value,
            UserRole::HR_STAFF->value,
        ];

        // Insert admin user
        if (in_array($request->getPost('role'), $allowedRoles)) {
            return $this->createAdminUser($request);
        }

        // insert for Employees

    }

    // Save new Admin user
    private function createAdminUser($request)
    {
        $post = $request->getPost();

        // Set strict validation rules
        $validation = Services::validation();
        // Rules
        $createAdminValidation = new CreateAdminValidation();
        $validation->setRules($createAdminValidation->rules);

        // Validate the form data
        if (!$validation->withRequest($request)->run()) {
            // Validation failed, set the errors in the session
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Start a database transaction
        $db = Database::connect();
        $db->transStart();

        try {
            // Insert to users
            $userData = [
                'role' => $post['role'],
                'email' => $post['email'],
                'password' => password_hash($post['password'], PASSWORD_BCRYPT),
                'status' => UserStatus::ACTIVE->value
            ];
            $userId = $this->user->insert($userData);

            // Insert to users_info
            $usersInfoData = [
                'user_id' => $userId,
                'first_name' => $post['first_name'],
                'middle_name' => $post['middle_name'],
                'last_name' => $post['last_name']
            ];
            $this->usersInfo->insert($usersInfoData);

            // If both operations are successful, commit the transaction
            $db->transComplete();

            withToast('success', 'Success! New user has been added.');
        } catch (Exception $e) {
            // If any operation fails, rollback the transaction
            $db->transRollback();

            withToast('error', 'Error! There was a problem saving user.');
        }

        return redirect()->route('users');
    }
}