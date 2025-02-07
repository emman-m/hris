<?php

namespace App\Validations;

use App\Enums\EmployeeStatus;
use App\Enums\UserRole;
use App\Validations\Validator;

class EmployeeUserValidator extends Validator
{
    protected $userRules = [
        // Common fields for all roles
        'first_name' => [
            'label' => 'First Name',
            'rules' => 'required|max_length[50]',
            'errors' => [
                'required' => '{field} is required.',
                'max_length' => '{field} must not exceed {param} characters long.',
            ]
        ],
        'last_name' => [
            'label' => 'Last Name',
            'rules' => 'required|max_length[50]',
            'errors' => [
                'required' => '{field} is required.',
            ]
        ],
        'email' => [
            'label' => 'Email',
            'rules' => 'required|valid_email|max_length[100]|is_unique[users.email]',
            'errors' => [
                'required' => '{field} is required.',
                'valid_email' => '{field} must be a valid email address.',
                'max_length' => '{field} must not exceed {param} characters long.',
                'is_unique' => '{field} already exists.'
            ]
        ],
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
        ],
    ];

    // Additional rules for employees
    protected $employeeRules = [
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
            'rules' => 'required_if[ei_status,Married]', // EmployeeStatus::MARRIED
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
        'e_school_address.*' => [
            'label' => 'School Address',
            'rules' => 'required',
            'errors' => [
                'required' => '{field} is required.',
            ]
        ],
        'e_year_graduated.*' => [
            'label' => 'Year Graduated',
            'rules' => 'required|valid_date',
            'errors' => [
                'required' => '{field} is required.',
            ]
        ],
        'e_degree.*' => [
            'label' => 'Degree',
            'rules' => 'required',
            'errors' => [
                'required' => '{field} is required.',
            ]
        ],
        'e_major_minor.*' => [
            'label' => 'Major/Minor',
            'rules' => 'required',
            'errors' => [
                'required' => '{field} is required.',
            ]
        ],
    ];

    protected $rules = [];

    public function __construct()
    {
        $this->rules = session()->get('role') === UserRole::EMPLOYEE->value
            ? array_merge($this->userRules, $this->employeeRules)
            : $this->userRules;
    }
}