<?php

namespace App\Validations;

use App\Enums\EmployeeStatus;
use App\Enums\UserRole;
use App\Validations\Validator;

class EmployeeUserValidator extends Validator
{

    public function __construct()
    {
        $this->rules = [
            'ei_date_of_birth' => [
                'label' => 'Date of Birth',
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => '{field} is required.',
                    'valid_date' => '{field} must be a valid date format.',
                ]
            ],
            'ei_birth_place' => [
                'label' => 'Place of Birth',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} is required.',
                ]
            ],
            'ei_gender' => [
                'label' => 'Gender',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} is required.',
                ]
            ],
            'ei_status' => [
                'label' => 'Status',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} is required.',
                ]
            ],
            'ei_spouse' => [
                'label' => 'Spouse',
                'rules' => 'required_if[ei_status,' . EmployeeStatus::MARRIED->value . ']',
                'errors' => [
                    'required_if' => '{field} is required.',
                ]
            ],
            'ei_permanent_address' => [
                'label' => 'Permanent Address',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} is required.',
                ]
            ],
            'ei_present_address' => [
                'label' => 'Present Address',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} is required.',
                ]
            ],
            'ei_fathers_name' => [
                'label' => 'Fathers Name',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} is required.',
                ]
            ],
            'ei_mothers_name' => [
                'label' => 'Mothers Name',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} is required.',
                ]
            ],
            'ei_mothers_maiden_name' => [
                'label' => 'Mothers Maiden Name',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} is required.',
                ]
            ],
            'ei_phone' => [
                'label' => 'Phone No.',
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '{field} is required.',
                ]
            ],
            'ei_nationality' => [
                'label' => 'Nationality',
                'rules' => 'required|alpha',
                'errors' => [
                    'required' => '{field} is required.',
                ]
            ],
            'ei_sss' => [
                'label' => 'SSS',
                'rules' => 'required|regex_match[/^[0-9-]+$/]',
                'errors' => [
                    'required' => '{field} is required.',
                ]
            ],
            'ei_date_of_coverage' => [
                'label' => 'SSS',
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => '{field} is required.',
                ]
            ],
            'ei_pagibig' => [
                'label' => 'Pagibig No.',
                'rules' => 'required|regex_match[/^[0-9-]+$/]',
                'errors' => [
                    'required' => '{field} is required.',
                ]
            ],
            'ei_tin' => [
                'label' => 'TIN No.',
                'rules' => 'required|regex_match[/^[0-9-]+$/]',
                'errors' => [
                    'required' => '{field} is required.',
                ]
            ],
            'ei_philhealth' => [
                'label' => 'Phil Health',
                'rules' => 'required|regex_match[/^[0-9-]+$/]',
                'errors' => [
                    'required' => '{field} is required.',
                ]
            ],
            'ei_res_cert_no' => [
                'label' => 'Res. Cert. No.',
                'rules' => 'required|regex_match[/^[0-9-]+$/]',
                'errors' => [
                    'required' => '{field} is required.',
                ]
            ],
            'ei_res_issued_on' => [
                'label' => 'Res. Cert. Issued On',
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => '{field} is required.',
                ]
            ],
            'ei_res_issued_at' => [
                'label' => 'Res. Cert. Issued On',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} is required.',
                ]
            ],
            'ei_contact_person' => [
                'label' => 'Contact Person',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} is required.',
                ]
            ],
            'ei_contact_person_no' => [
                'label' => 'Contact Person',
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '{field} is required.',
                ]
            ],
            'ei_contact_person_relation' => [
                'label' => 'Relation',
                'rules' => 'required|alpha_space',
                'errors' => [
                    'required' => '{field} is required.',
                ]
            ],
            'ei_employment_date' => [
                'label' => 'Employment Date',
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => '{field} is required.',
                ]
            ],
        ];
    }
}