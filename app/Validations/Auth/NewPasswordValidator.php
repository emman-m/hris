<?php

namespace App\Validations\Auth;

use App\Validations\Validator;

class NewPasswordValidator extends Validator
{
    public function __construct()
    {
        $this->rules = [
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
