<?php

namespace App\Services;

class Announcement
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