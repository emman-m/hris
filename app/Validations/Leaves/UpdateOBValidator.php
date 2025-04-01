<?php

namespace App\Validations\Leaves;

use App\Enums\EmployeeDepartment;
use App\Validations\Validator;

class UpdateOBValidator extends Validator
{
    public function __construct()
    {
        $this->rules = [
            'department' => [
                'label' => 'Department',
                'rules' => 'required|in_list'. str_replace('"', '', json_encode(EmployeeDepartment::list())),
                'errors' => [
                    'required' => '{field} is required.',
                    'in_list' => 'Invalid {field} selected.'
                ]
            ],
            'institution' => [
                'label' => 'Institution',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} is required.'
                ]
            ],
            'reason' => [
                'label' => 'Reason',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} is required.'
                ]
            ],
            'venue' => [
                'label' => 'Venue',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} is required.'
                ]
            ],
            'start_date' => [
                'label' => 'Start Date',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} is required.'
                ]
            ],
            'time_in' => [
                'label' => 'Time In',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} is required.'
                ]
            ],
            'time_out' => [
                'label' => 'Time In',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} is required.'
                ]
            ],
            'approval_proof' => [
                'label' => 'Approval Proof',
                'rules' => 'permit_empty|uploaded[approval_proof]|max_size[approval_proof,15360]|ext_in[approval_proof,pdf,docx,jpg,jpeg,png]',
                'errors' => [
                    'required' => '{field} is required.',
                    'uploaded' => 'Please upload a valid file.',
                    'max_size' => 'The file size must not exceed 15MB.',
                    'ext_in' => 'Only PDF, DOCX, JPG, JPEG, and PNG files are allowed.',
                ]
            ],
        ];
    }
}
