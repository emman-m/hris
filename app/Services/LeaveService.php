<?php

namespace App\Services;

use App\Enums\LeaveType;

class LeaveService extends Service
{

    protected $user;
    protected $leave;
    protected $notification;

    public function __construct()
    {
        $this->user = model('User');
        $this->leave = model('Leave');
        $this->notification = new NotificationService();
    }

    public function sendCreateNotif($data)
    {
        $admins = $this->user->getAllAdmin();
        $employeeInfo = $this->user->getUserByuserId($data['user_id']);

        $users = array_column($admins, 'id');

        // Save Notification
        $this->notification->sendNotification($users, "{$employeeInfo['first_name']} {$employeeInfo['last_name']} Submitted an {$this->getLeaveType($data['type'])}.");
        $emailData = [];
        foreach ($admins as $admin) {
            $emailData[] = [
                'email' => $admin['email'],
                'subject' => "{$employeeInfo['first_name']} {$employeeInfo['last_name']} Submitted a Leave.",
                'context' => [
                    'name' => $admin['name'],
                    'message' => "{$employeeInfo['first_name']} {$employeeInfo['last_name']} Submitted an {$this->getLeaveType($data['type'])}.",
                ]
            ];
        }

        // Send email
        $this->notification->sendEmail($emailData);
    }

    public function sendApproveNotif($data)
    {
        $leave = $this->leave->findById($data['id']);

        // Save Notification
        $this->notification->sendNotification($leave['user_id'], "{$leave['approve_by']} has {$data['status']} your leave application.");

        // Send email
        $emailData[] = [
            'email' => $leave['email'],
            'subject' => "Leave Application",
            'context' => [
                'name' => $leave['name'],
                'message' => "{$leave['approve_by']} has {$data['status']} your leave application.",
            ]
        ];

        $this->notification->sendEmail($emailData);
    }

    protected function getLeaveType($type)
    {
        return $type === LeaveType::VACATION_LEAVE->value
            ? 'Application for Leave'
            : "$type Leave";
    }
}