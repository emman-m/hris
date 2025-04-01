<?php

namespace App\Services;

class VacationLeaveService
{
    public static function parseData(array $context)
    {
        $session = service('session');
        $session->setFlashdata('_ci_old_input', [
            'post' => $context
        ]);

        return;
    }
}