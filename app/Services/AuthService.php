<?php

namespace App\Services;

class AuthService extends Service
{
    protected $notification;

    public function __construct()
    {
        $this->notification = new NotificationService();
    }

    public function sendCodeToEmail($data)
    {
        $emailData[] = [
            'email' => $data['email'],
            'subject' => "Forgot Password Verification Code",
            'template' => 'forgot_password',
            'context' => [
                'name' => "{$data['first_name']} {$data['last_name']}",
                'link' => base_url('new-password?email=' . $data['email'] . '&code=' . $data['code']),
            ]
        ];

        $this->notification->sendEmail($emailData);
    }

    public function sendSuccessChangePasswordNotif($data)
    {
        $emailData[] = [
            'email' => $data['email'],
            'subject' => "Password Changed Successfully",
            'template' => 'changed_password',
            'context' => []
        ];

        $this->notification->sendEmail($emailData);
    }
}