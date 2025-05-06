<?php

namespace App\Services;

class UserService extends Service
{
    protected $notification;

    public function __construct()
    {
        $this->notification = new NotificationService();
    }

    public function sendStoreNotif($data)
    {
        // Save Notification
        $this->notification->sendNotification($data['user_id'], 'Welcome to LCC Tanauan HRMS Portal.');

        // Send email
        $emailData[] = [
            'email' => $data['email'],
            'subject' => "Welcome to LCC Tanauan HRMS Portal",
            'template' => 'welcome',
            'context' => [
                'name' => "{$data['first_name']} {$data['last_name']}"
            ]
        ];

        return $this->notification->sendEmail($emailData);
    }

    public function sendUpdateNotif($data)
    {
        // Save Notification
        $this->notification->sendNotification($data['user_id'], 'Admin Has Updated Your Account info.');

        // Send email
        $emailData[] = [
            'email' => $data['email'],
            'subject' => "Admin Has Updated Your Account info.",
            'context' => [
                'name' => "{$data['first_name']} {$data['last_name']}",
                'message' => 'Admin has updated your account info.',
            ]
        ];

        return $this->notification->sendEmail($emailData);
    }

    public function sendUpdateStatusNotif($data)
    {
        // Save Notification
        $this->notification->sendNotification($data['user_id'], "Admin Has Updated Your Account status into {$data['status']}.");

        // Send email
        $emailData[] = [
            'email' => $data['email'],
            'subject' => "Admin Has Updated Your Account info.",
            'context' => [
                'name' => "{$data['first_name']} {$data['last_name']}",
                'message' => "Admin has updated your account status into {$data['status']}.",
            ]
        ];

        $this->notification->sendEmail($emailData);
    }
}