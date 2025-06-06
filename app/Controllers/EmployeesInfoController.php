<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Enums\UserRole;
use App\Services\EmployeeService;
use App\Validations\EmployeeUserValidator;
use CodeIgniter\Exceptions\PageNotFoundException;
use Config\Database;
use Config\Services;
use Exception;

class EmployeesInfoController extends BaseController
{
    protected $user;
    protected $employeeInfo;
    protected $education;
    protected $dependent;
    protected $employmentHistory;
    protected $affiliation;
    protected $licensure;
    protected $positionHistory;
    protected $employeeService;

    public function __construct()
    {
        $this->user = model('User');
        $this->employeeInfo = model('EmployeeInfo');
        $this->education = model('Education');
        $this->dependent = model('Dependent');
        $this->employmentHistory = model('EmploymentHistory');
        $this->affiliation = model('Affiliation');
        $this->licensure = model('Licensure');
        $this->positionHistory = model('PositionHistory');
        $this->employeeService = new EmployeeService();
    }

    public function index()
    {
        // Auth user
        if (!$this->auth->isEmployee()) {
            throw new PageNotFoundException('Page Not Found', 404);
        }

        $userId = session()->get('user_id');

        $user = $this->user->getUserByuserId($userId);

        // Return error if no param, or no user found, or role is not employee
        if (empty($userId) || (empty($user)) || ($user['role'] !== UserRole::EMPLOYEE->value)) {
            withToast('error', 'Employee not found.');

            return redirect()->back();
        }

        if (!session()->has('errors')) {
            $employeeInfo = $this->employeeInfo->findByUserId($userId)->idAs('ei_id')->first() ?? [];
            $educations = $this->education->findAllByUserId($userId) ?? [];
            $dependents = $this->dependent->findAllByUserId($userId) ?? [];
            $employmentHistory = $this->employmentHistory->findAllByUserId($userId) ?? [];
            $affiliationPro = $this->affiliation->findAllProByUserId($userId) ?? [];
            $affiliationSocio = $this->affiliation->findAllSocioByUserId($userId) ?? [];
            $licensure = $this->licensure->findByUserId($userId)->idAs('license_id')->first() ?? [];
            $pastPosition = $this->positionHistory->findAllPastByUserId($userId) ?? [];
            $currentPosition = $this->positionHistory->findAllCurrentByUserId($userId) ?? [];

            $context = $employeeInfo;
            $context = array_merge($context, $licensure);
            $context = array_merge($context, ['educations' => $educations]);
            $context = array_merge($context, ['dependents' => $dependents]);
            $context = array_merge($context, ['employmentHistory' => $employmentHistory]);
            $context = array_merge($context, ['affiliationPro' => $affiliationPro]);
            $context = array_merge($context, ['affiliationSocio' => $affiliationSocio]);
            $context = array_merge($context, ['pastPosition' => $pastPosition]);
            $context = array_merge($context, ['currentPosition' => $currentPosition]);

            // Render the edit template and store in flash data
            EmployeeService::parseEmployeesInfo($context);
        }
        $isLocked = $employeeInfo['is_locked'] ?? false;

        return view('Pages/Employees/Employee/edit_details', ['is_locked' => $isLocked]);
    }

    public function update()
    {
        // Auth user
        if (!$this->auth->isEmployee()) {
            throw new PageNotFoundException('Page Not Found', 404);
        }
        
        $userId = session()->get('user_id');

        // Fetch employee info
        $employeeInfo = $this->employeeInfo->findByUserId($userId)->first() ?? [];

        if (!empty($employeeInfo) && $employeeInfo['is_locked']) {
            throw new PageNotFoundException('Page Not Found', 404);
        }

        // Get the request object
        $request = Services::request();

        $post = $request->getPost();

        $validator = new EmployeeUserValidator();
        // Validate Request

        if (!$validator->runValidation($request)) {
            // Validation failed, return to the form with errors
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $validator->getErrors())
                ->with('form', $request->getPost());
        }

        // Start a database transaction
        $db = Database::connect();
        $db->transStart();

        try {
            // Insert to employees_info
            $this->employeeInfo->upsert([
                'id' => $post['ei_id'],
                'user_id' => $userId,
                'department' => $post['department'],
                'birth' => $post['ei_date_of_birth'],
                'birth_place' => $post['ei_birth_place'],
                'gender' => $post['ei_gender'],
                'status' => $post['ei_status'],
                'spouse' => $post['ei_spouse'],
                'permanent_address' => $post['ei_permanent_address'],
                'present_address' => $post['ei_present_address'],
                'fathers_name' => $post['ei_fathers_name'],
                'mothers_name' => $post['ei_mothers_name'],
                'mothers_maiden_name' => $post['ei_mothers_maiden_name'],
                'religion' => $post['ei_religion'],
                'tel' => $post['ei_tel'],
                'phone' => $post['ei_phone'],
                'nationality' => $post['ei_nationality'],
                'sss' => $post['ei_sss'],
                'date_of_coverage' => $post['ei_date_of_coverage'],
                'pagibig' => $post['ei_pagibig'],
                'tin' => $post['ei_tin'],
                'philhealth' => $post['ei_philhealth'],
                'res_cert_no' => $post['ei_res_cert_no'],
                'res_issued_on' => $post['ei_res_issued_on'],
                'res_issued_at' => $post['ei_res_issued_at'],
                'contact_person' => $post['ei_contact_person'],
                'contact_person_no' => $post['ei_contact_person_no'],
                'contact_person_relation' => $post['ei_contact_person_relation'],
                'employment_date' => $post['ei_employment_date']
            ]);

            // Education
            foreach ($post['e_level'] as $key => $value) {
                $this->education->upsert([
                    'id' => $post['e_id'][$key],
                    'user_id' => $userId,
                    'level' => $value,
                    'school_address' => $post['e_school_address'][$key],
                    'degree' => $post['e_degree'][$key] ?? null,
                    'major_minor' => $post['e_major_minor'][$key] ?? null,
                    'year_graduated' => $post['e_year_graduated'][$key] ?? null,
                ]);
            }

            // Dependents
            foreach ($post['d_name'] as $key => $value) {
                $this->dependent->upsert([
                    'id' => $post['d_id'][$key],
                    'user_id' => $userId,
                    'name' => $value,
                    'birth' => $post['d_birth'][$key] ?? null,
                    'relationship' => $post['d_relationship'][$key] ?? null,
                ]);
            }

            // Employment History
            foreach ($post['eh_name'] as $key => $value) {
                $this->employmentHistory->upsert([
                    'id' => $post['eh_id'][$key],
                    'user_id' => $userId,
                    'name' => $value,
                    'position' => $post['eh_position'][$key] ?? null,
                    'year_from' => $post['eh_year_from'][$key],
                    'year_to' => $post['eh_year_to'][$key]
                ]);
            }

            // Affiliation Pro
            foreach ($post['a_p_type'] as $key => $value) {
                if ($post['a_p_name'][$key] !== '' && $post['a_p_position'][$key] !== '') {
                    $this->affiliation->upsert([
                        'id' => $post['a_p_id'][$key],
                        'user_id' => $userId,
                        'type' => $value,
                        'name' => $post['a_p_name'][$key],
                        'position' => $post['a_p_position'][$key],
                    ]);
                }
            }

            // Affiliation Socio
            foreach ($post['a_s_type'] as $key => $value) {
                if ($post['a_s_name'][$key] !== '' && $post['a_s_position'][$key] !== '') {
                    $this->affiliation->upsert([
                        'id' => $post['a_s_id'][$key],
                        'user_id' => $userId,
                        'type' => $value,
                        'name' => $post['a_s_name'][$key],
                        'position' => $post['a_s_position'][$key],
                    ]);
                }
            }

            // Licensure
            $this->licensure->upsert([
                'id' => $post['l_id'],
                'user_id' => $userId,
                'license' => $post['l_license'],
                'year' => $post['l_year'],
                'rating' => $post['l_rating'],
                'license_no' => $post['l_license_no'],
            ]);

            // Position History
            foreach ($post['pp_is_current'] as $key => $value) {
                $this->positionHistory->upsert([
                    'id' => $post['pp_id'][$key],
                    'user_id' => $userId,
                    'is_current' => $value,
                    'position' => $post['pp_position'][$key],
                    'year_from' => $post['pp_year_from'][$key],
                    'year_to' => $post['pp_year_to'][$key],
                ]);
            }

            // Current position
            foreach ($post['cp_is_current'] as $key => $value) {
                $this->positionHistory->upsert([
                    'id' => $post['cp_id'][$key],
                    'user_id' => $userId,
                    'is_current' => $value,
                    'position' => $post['cp_position'][$key],
                    'year_from' => $post['cp_year_from'][$key],
                    'year_to' => $post['cp_year_to'][$key],
                ]);
            }

            $db->transComplete();

            // Check if the transaction was successful
            if ($db->transStatus() === false) {
                throw new Exception('Transaction failed');
            }

            // Send Notif
            $this->employeeService->sendUpdateNotif(['user_id' => $userId]);

            withToast('success', 'Informations has been saved');
        } catch (Exception $e) {
            // If any operation fails, rollback the transaction
            $db->transRollback();
            log_message('error', $e);

            withToast('error', 'Error! There was a problem saving changes.');
        }

        return redirect()->route('my-informations');
    }
}
