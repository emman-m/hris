<?php

namespace App\Services;

use App\Models\EmployeeInfo;

class Announcement
{
    protected $employeeInfo;
    protected $notification;

    public function __construct()
    {
        $this->employeeInfo = new EmployeeInfo();
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

    public function sendNotif($post)
    {
        // Save Notification
        $response = $this->employeeInfo->getUserFromDept($post['target']);
        $users = array_column($response, 'id');

        $this->notification->sendNotification($users, '"' . $post['title'] . '" announcement has been Created');

        // Send email
        $data = [];
        foreach ($response as $row) {
            $data[] = [
                'email' => $row['email'],
                'subject' => "Announcement - {$post['title']}",
                'context' => [
                    'name' => "{$row['first_name']} {$row['last_name']}",
                    'message' => clean_content($post['content'])
                ]
            ];
        }

        $this->notification->sendEmail($data);
    }
}