<?php

namespace App\Validations\Auth;

use App\Validations\Validator;

class ForgotPasswordValidator extends Validator
{
    public function __construct()
    {
        $this->rules = [
            'email' => [
                'label' => 'Email',
                'rules' => 'required|is_existing[users.email]',
                'errors' => [
                    'required' => '{field} is required.',
                    'is_existing' => '{field} is existed.'
                ]
            ],
        ];
    }
}
