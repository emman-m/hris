<?php

namespace App\Services;

use App\Libraries\Policy\AuthPolicy;

class Service
{
    protected $auth;
    protected $notification;

    public function __construct()
    {
        $this->auth = new AuthPolicy();
        $this->notification = new NotificationService();
    }

    public static function parseData(array $context)
    {
        $session = service('session');
        $session->setFlashdata('_ci_old_input', [
            'post' => $context
        ]);

        return;
    }
}