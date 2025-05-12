<?php

namespace App\Validations\BulkUser;

use App\Validations\Validator;

class UploadValidation extends Validator
{
    public function __construct()
    {
        $this->rules = [
            'file' => [
                'label' => 'File',
                'rules' => 'uploaded[file]|max_size[file,102400]|ext_in[file,csv]',
                'errors' => [
                    'uploaded' => '{field} is required.',
                    'max_size' => '{field} must not exceed 50MB.',
                    'ext_in' => '{field} must be a CSV file.',
                ]
            ],
        ];
    }
} 