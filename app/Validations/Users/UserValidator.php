<?php

namespace App\Validations\Users;

use App\Enums\EmployeeDepartment;
use App\Enums\UserRole;
use App\Validations\Validator;

class UserValidator extends Validator
{
    public function __construct()
    {
        $this->rules = [
            'role' => [
                'label' => 'Role',
                'rules' => 'required|in_list[' . implode(',', UserRole::list()) . ']',
                'errors' => [
                    'required' => '{field} is required.',
                    'max_length' => '{field} must not exceed to {param} characters long.',
                ]
            ],
            'employee_id' => [
                'label' => 'Employee ID',
                'rules' => 'required_if[role,'.UserRole::EMPLOYEE->value.']',
                'errors' => [
                    'required_if' => '{field} is required.',
                ]
            ],
            'first_name' => [
                'label' => 'First Name',
                'rules' => 'required|max_length[50]',
                'errors' => [
                    'required' => '{field} is required.',
                    'max_length' => '{field} must not exceed to {param} characters long.',
                ]
            ],
            'last_name' => [
                'label' => 'Last Name',
                'rules' => 'required|max_length[50]',
                'errors' => [
                    'required' => '{field} is required.',
                    'max_length' => '{field} must not exceed to {param} characters long.',
                ]
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email|max_length[100]|is_unique[users.email]',
                'errors' => [
                    'required' => '{field} is required.',
                    'valid_email' => '{field} must be a valid email address.',
                    'max_length' => '{field} must not exceed to {param} characters long.',
                    'is_unique' => '{field} already exists.'
                ]
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required|min_length[8]|max_length[255]',
                'errors' => [
                    'required' => '{field} is required.',
                    'min_length' => '{field} must be at least {param} characters long.',
                    'max_length' => '{field} must be at least {param} characters long.',
                ]
            ],
            'confirm_password' => [
                'label' => 'Confirm Password',
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => '{field} is required.',
                    'matches' => 'The {field} does not match the Password field.'
                ]
            ]
        ];
    }
}
