<?php

namespace App\Services;

class OfficialBusinessService
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