<?php

namespace App\Services;

class EmployeeService
{
    public static function parseEmployeesInfo(array $context)
    {
        // dd($context);
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
}