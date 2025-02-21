<?php

namespace App\Validations\Files;

use App\Validations\Validator;

class UpdateValidation extends Validator
{
    protected $id;

    public function __construct()
    {
        $this->rules = [
            'file_name' => [
                'label' => 'File Name',
                'rules' => 'required|edit_unique[employees_files.file_name.'.$this->id.']',
                'errors' => [
                    'required' => '{field} is required.',
                    'edit_unique' => '{field} already exists.',
                ]
            ],
            'file' => [
                'label' => 'File',
                'rules' => 'permit_empty|uploaded[file]|max_size[file,15360]|ext_in[file,pdf,docx,jpg,jpeg,png]',
                'errors' => [
                    'uploaded' => 'Please upload a valid file.',
                    'max_size' => 'The file size must not exceed 15MB.',
                    'ext_in' => 'Only PDF, DOCX, JPG, JPEG, and PNG files are allowed.',
                ]
            ],
        ];
    }

    public function setId($id)
    {
        log_message('debug', $id);
        $this->id = $id;
    }
}
