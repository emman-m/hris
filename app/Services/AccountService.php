<?php

namespace App\Services;

class AccountService
{
    public static function parseAccountInfo(array $context)
    {
        $session = service('session');
        $session->setFlashdata('_ci_old_input', [
            'post' => [
                'first_name' => $context['first_name'] ?? '',
                'middle_name' => $context['middle_name'] ?? '',
                'last_name' => $context['last_name'] ?? '',
                'email' => $context['email'] ?? '',
            ],
        ]);

        return;
    }
}