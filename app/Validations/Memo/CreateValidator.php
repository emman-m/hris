<?php

namespace App\Validations\Memo;

use App\Validations\Validator;

class CreateValidator extends Validator
{
    public function __construct()
    {
        $this->rules = [
            'title' => [
                'label' => 'Title',
                'rules' => 'required|min_length[3]|max_length[255]',
                'errors' => [
                    'required' => '{field} is required.',
                    'min_length' => '{field} must be at least 3 characters long.',
                    'max_length' => '{field} cannot exceed 255 characters.'
                ]
            ],
            'file' => [
                'label' => 'File',
                'rules' => 'uploaded[file]|mime_in[file,application/pdf]|max_size[file,10240]',
                'errors' => [
                    'uploaded' => '{field} is required.',
                    'mime_in' => '{field} must be a PDF file.',
                    'max_size' => '{field} must not exceed 10MB.'
                ]
            ],
            'recipients' => [
                'label' => 'Recipients',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} is required.'
                ]
            ]
        ];
    }
} 