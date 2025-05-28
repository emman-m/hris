<?php

namespace App\Validations\Leaves;

use App\Enums\UserRole;
use App\Validations\Validator;

class CreateVLValidator extends Validator
{
    public function __construct()
    {
        $this->rules = [
            'vl_type' => [
                'label' => 'Leave Type',
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
            'days' => [
                'label' => 'Number of day(s)',
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
            'end_date' => [
                'label' => 'End Date',
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

        if (session()->get('role') !== UserRole::EMPLOYEE->value) {
            $this->rules = array_merge($this->rules, [
                'employee_id' => [
                    'label' => 'Employee ID',
                    'rules' => 'required|is_existing[employees_info.employee_id]',
                    'errors' => [
                        'required' => '{field} is required.',
                        'is_existing' => '{field} does not exist or not yet registered.',
                    ]
                ],
            ]);
        }
    }
}
