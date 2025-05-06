<?php

namespace App\Validations\Files;

use App\Validations\Validator;

class StoreValidation extends Validator
{
    public function __construct()
    {
        $this->rules = [
            'file_name' => [
                'label' => 'File Name',
                'rules' => 'required|is_unique[employees_files.file_name]',
                'errors' => [
                    'required' => '{field} is required.',
                    'is_unique' => '{field} already exists.',
                ]
            ],
            'file' => [
                'label' => 'File',
                'rules' => 'uploaded[file]|max_size[file,15360]|ext_in[file,pdf,jpg,jpeg,png]',
                'errors' => [
                    'required' => '{field} is required.',
                    'uploaded' => 'Please upload a valid file.',
                    'max_size' => 'The file size must not exceed 15MB.',
                    'ext_in' => 'Only PDF, JPG, JPEG, and PNG files are allowed.',
                ]
            ],
        ];
    }
}
