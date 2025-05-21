<?php

namespace App\Services;

use App\Libraries\Policy\AuthPolicy;

class EmployeeService extends Service
{
    protected $user;
    protected $notification;
    protected $auth;
    protected $employeesInfo;
    protected $education;
    protected $dependent;
    protected $employmentHistory;
    protected $affiliation;
    protected $licensure;
    protected $positionHistory;

    public function __construct()
    {
        $this->user = model('User');
        $this->notification = new NotificationService();
        $this->auth = new AuthPolicy();
        $this->employeesInfo = model('EmployeeInfo');
        $this->education = model('Education');
        $this->dependent = model('Dependent');
        $this->employmentHistory = model('EmploymentHistory');
        $this->affiliation = model('Affiliation');
        $this->licensure = model('Licensure');
        $this->positionHistory = model('PositionHistory');
    }

    public static function parseEmployeesInfo(array $context)
    {
        $session = service('session');
        $session->setFlashdata('_ci_old_input', [
            'post' => [
                'ei_id' => $context['ei_id'] ?? '',
                'department' => $context['department'] ?? '',
                'ei_date_of_birth' => $context['birth'] ?? '',
                'ei_birth_place' => $context['birth_place'] ?? '',
                'ei_gender' => $context['gender'] ?? '',
                'ei_status' => $context['status'] ?? '',
                'ei_spouse' => $context['spouse'] ?? '',
                'ei_permanent_address' => $context['permanent_address'] ?? '',
                'ei_present_address' => $context['present_address'] ?? '',
                'ei_fathers_name' => $context['fathers_name'] ?? '',
                'ei_mothers_name' => $context['mothers_name'] ?? '',
                'ei_mothers_maiden_name' => $context['mothers_maiden_name'] ?? '',
                'ei_religion' => $context['religion'] ?? '',
                'ei_tel' => $context['tel'] ?? '',
                'ei_phone' => $context['phone'] ?? '',
                'ei_nationality' => $context['nationality'] ?? '',
                'ei_sss' => $context['sss'] ?? '',
                'ei_date_of_coverage' => $context['date_of_coverage'] ?? '',
                'ei_pagibig' => $context['pagibig'] ?? '',
                'ei_tin' => $context['tin'] ?? '',
                'ei_philhealth' => $context['philhealth'] ?? '',
                'ei_res_cert_no' => $context['res_cert_no'] ?? '',
                'ei_res_issued_on' => $context['res_issued_on'] ?? '',
                'ei_res_issued_at' => $context['res_issued_at'] ?? '',
                'ei_contact_person' => $context['contact_person'] ?? '',
                'ei_contact_person_no' => $context['contact_person_no'] ?? '',
                'ei_contact_person_relation' => $context['contact_person_relation'] ?? '',
                'ei_employment_date' => $context['employment_date'] ?? '',
                'l_id' => $context['license_id'] ?? '',
                'l_license' => $context['license'] ?? '',
                'l_year' => $context['year'] ?? '',
                'l_rating' => $context['rating'] ?? '',
                'l_license_no' => $context['license_no'] ?? '',
            ],
        ]);

        $form = [];
        // educations
        foreach ($context['educations'] as $education) {
            $form['e_id'][] = $education['id'] ?? '';
            $form['e_level'][] = $education['level'] ?? '';
            $form['e_school_address'][] = $education['school_address'] ?? '';
            $form['e_year_graduated'][] = $education['year_graduated'] ?? '';
            $form['e_degree'][] = $education['degree'] ?? '';
            $form['e_major_minor'][] = $education['major_minor'] ?? '';
        }

        // dependents
        foreach ($context['dependents'] as $dependent) {
            $form['d_id'][] = $dependent['id'] ?? '';
            $form['d_name'][] = $dependent['name'] ?? '';
            $form['d_birth'][] = $dependent['birth'] ?? '';
            $form['d_relationship'][] = $dependent['relationship'] ?? '';
        }

        // Previous Employments
        foreach ($context['employmentHistory'] as $employment) {
            $form['eh_id'][] = $employment['id'] ?? '';
            $form['eh_name'][] = $employment['name'] ?? '';
            $form['eh_position'][] = $employment['position'] ?? '';
            $form['eh_year_from'][] = $employment['year_from'] ?? '';
            $form['eh_year_to'][] = $employment['year_to'] ?? '';
        }

        // Affiliation pro
        foreach ($context['affiliationPro'] as $pro) {
            $form['a_p_id'][] = $pro['id'] ?? '';
            $form['a_p_type'][] = $pro['type'] ?? '';
            $form['a_p_name'][] = $pro['name'] ?? '';
            $form['a_p_position'][] = $pro['position'] ?? '';
        }

        // Affiliation socio
        foreach ($context['affiliationSocio'] as $socio) {
            $form['a_s_id'][] = $socio['id'] ?? '';
            $form['a_s_type'][] = $socio['type'] ?? '';
            $form['a_s_name'][] = $socio['name'] ?? '';
            $form['a_s_position'][] = $socio['position'] ?? '';
        }

        // Past position
        foreach ($context['pastPosition'] as $pastPosition) {
            $form['pp_id'][] = $pastPosition['id'] ?? '';
            $form['pp_is_current'][] = $pastPosition['is_current'] ?? '';
            $form['pp_position'][] = $pastPosition['position'] ?? '';
            $form['pp_year_from'][] = $pastPosition['year_from'] ?? '';
            $form['pp_year_to'][] = $pastPosition['year_to'] ?? '';
        }

        // Past position
        foreach ($context['currentPosition'] as $currentPosition) {
            $form['cp_id'][] = $currentPosition['id'] ?? '';
            $form['cp_is_current'][] = $currentPosition['is_current'] ?? '';
            $form['cp_position'][] = $currentPosition['position'] ?? '';
            $form['cp_year_from'][] = $currentPosition['year_from'] ?? '';
            $form['cp_year_to'][] = $currentPosition['year_to'] ?? '';
        }

        $session->setFlashdata('form', $form);

        return;
    }

    public function sendUpdateNotif($data)
    {
        $emailData = [];
        $employeeInfo = $this->user->getUserByuserId($data['user_id']);

        // if employee updated, notif all the admin
        if ($this->auth->isEmployee()) {

            $admins = $this->user->getAllAdmin();
            $users = array_column($admins, 'id');
            $data['message'] = "{$employeeInfo['first_name']} {$employeeInfo['last_name']} has updated their information";

            // for email
            foreach ($admins as $row) {
                $emailData[] = [
                    'email' => $row['email'],
                    'subject' => 'Personal Information Updated',
                    'context' => [
                        'name' => $row['name'],
                        'message' => "{$employeeInfo['first_name']} {$employeeInfo['last_name']} has updated their information",
                    ]
                ];
            }
            // if the admin has updated, notif the employee
        } else {
            $emailData[] = [
                'email' => $employeeInfo['email'],
                'subject' => 'Personal Information Updated',
                'context' => [
                    'name' => "{$employeeInfo['first_name']} {$employeeInfo['last_name']}",
                    'message' => "Admin has updated your personal information."
                ]
            ];
            $users = $data['user_id'];

            $data['message'] = "Admin has Updated your Personal information.";

        }
        log_message('debug', json_encode(['notif_log' => $emailData]));
        // Save Notification
        $this->notification->sendNotification($users, $data['message']);

        // Send email
        $this->notification->sendEmail($emailData);
    }

    public function sendLockUnlockNotif($data)
    {
        // Save Notification
        $this->notification->sendNotification($data['user_id'], "Admin has {$data['action_status']} your Personal information.");

        // Send email
        $emailData[] = [
            'email' => $data['email'],
            'subject' => "Admin has {$data['action_status']} your Personal information.",
            'context' => [
                'name' => $data['name'],
                'message' => "Admin has {$data['action_status']} your Personal information. You cannot update or modify anything to your personal information."
            ]
        ];

        $this->notification->sendEmail($emailData);
    }

    public function getEmployeesData($userId)
    {
        $user = $this->user->getUserByuserId($userId);
        $employeeInfo = $this->employeesInfo->findByUserId($userId)->first();

        // Guard clause
        if (!$employeeInfo) {
            return null;
        }

        $employeeInfo['educations'] = $this->education->findAllByUserId($userId);
        $employeeInfo['dependents'] = $this->dependent->findAllByUserId($userId);
        $employeeInfo['employmentHistory'] = $this->employmentHistory->findAllByUserId($userId);
        $employeeInfo['affiliationPro'] = $this->affiliation->findAllProByUserId($userId);
        $employeeInfo['affiliationSocio'] = $this->affiliation->findAllSocioByUserId($userId);
        $employeeInfo['licensure'] = $this->licensure->findByUserId($userId)->first();
        $employeeInfo['pastPosition'] = $this->positionHistory->findAllPastByUserId($userId);
        $employeeInfo['currentPosition'] = $this->positionHistory->findAllCurrentByUserId($userId);

        return [
            'user' => $user,
            'employeeInfo' => $employeeInfo,
        ];
    }
}