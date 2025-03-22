<?php

namespace App\Validations\Announcement;

use App\Validations\Validator;

class CreateValidator extends Validator
{
    public function __construct()
    {
        $this->rules = [
            'target' => [
                'label' => 'Target User',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} is required.'
                ]
            ],
            'title' => [
                'label' => 'Title',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} is required.'
                ]
            ],
            'content' => [
                'label' => 'Content',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} is required.'
                ]
            ],
        ];
    }
}
