<?php

namespace App\Validations\Account;

use App\Enums\UserRole;
use App\Validations\Validator;

class UpdateValidator extends Validator
{
    public function __construct($id)
    {
        $this->rules = [
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
                'rules' => 'required|valid_email|max_length[100]|edit_unique[users.email.' . $id . ']',
                'errors' => [
                    'required' => '{field} is required.',
                    'valid_email' => '{field} must be a valid email address.',
                    'max_length' => '{field} must not exceed to {param} characters long.',
                    'edit_unique' => '{field} already exists.'
                ]
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'min_length[8]|max_length[255]|permit_empty',
                'errors' => [
                    'min_length' => '{field} must be at least {param} characters long.',
                    'max_length' => '{field} must be at least {param} characters long.',
                ]
            ],
            'confirm_password' => [
                'label' => 'Confirm Password',
                'rules' => 'required_with[password]|matches[password]',
                'errors' => [
                    'required_with' => '{field} is required.',
                    'matches' => 'The {field} does not match the Password field.'
                ]
            ]
        ];
    }
}
