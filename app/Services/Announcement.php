<?php

namespace App\Services;

class Announcement extends Service
{
    protected $employeeInfo;
    protected $notification;

    public function __construct()
    {
        $this->employeeInfo = model('EmployeeInfo');
        $this->notification = new NotificationService();
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