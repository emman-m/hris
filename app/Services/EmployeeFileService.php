<?php

namespace App\Services;

use App\Enums\UserRole;

class EmployeeFileService extends Service
{
    protected $user;
    protected $file;
    protected $notification;

    public function __construct()
    {
        $this->user = model('User');
        $this->file = model('EmployeesFile');
        $this->notification = new NotificationService();
    }

    public function sendCreateNotif($post)
    {
        // Save Notification
        $admins = $this->user->getAllAdmin();
        $users = array_column($admins, 'id');

        $employeeInfo = $this->user->getUserByuserId($post['user_id']);
        $employeeName = "{$employeeInfo['first_name']} {$employeeInfo['last_name']}";

        $adminInfo = $this->user->getUserByuserId(session()->get('user_id'));
        $adminName = "{$adminInfo['first_name']} {$adminInfo['last_name']}";

        // Submitted by admin
        if (session()->get('role') !== UserRole::EMPLOYEE->value) {
            array_push($users, $post['user_id']);
            $message = "{$adminName} has uploaded a file for {$employeeName} [{$post['file_name']}].";
        } else if (session()->get('role') === UserRole::EMPLOYEE->value) { // Submitted by Employee
            $message = "{$employeeName} has uploaded a file [{$post['file_name']}].";
        }

        $this->notification->sendNotification($users, $message);

        // Send email
        $emailData = [];

        // Submitted by admin
        if (session()->get('role') !== UserRole::EMPLOYEE->value) {
            $emailData[] = [
                'email' => $employeeInfo['email'],
                'subject' => "File Upload",
                'context' => [
                    'name' => $employeeName,
                    'message' => "{$adminName} has uploaded a file for you [{$post['file_name']}].",
                ]
            ];
            $message = "{$adminName} has uploaded a file for {$employeeName} [{$post['file_name']}].";
        } else if (session()->get('role') === UserRole::EMPLOYEE->value) { // Submitted by
            $message = "{$employeeName} has uploaded a file [{$post['file_name']}].";
        }

        foreach ($admins as $admin) {
            $emailData[] = [
                'email' => $admin['email'],
                'subject' => "{$employeeInfo['first_name']} {$employeeInfo['last_name']} Submitted a Leave.",
                'context' => [
                    'name' => $adminName,
                    'message' => $message,
                ]
            ];
        }

        $this->notification->sendEmail($emailData);
    }

    public function sendDeleteNotif($data, $fileInfo)
    {
        $admins = $this->user->getAllAdmin();
        $users = array_column($admins, 'id');

        $employeeInfo = $this->user->getUserByuserId($fileInfo['user_id']);
        $employeeName = "{$employeeInfo['first_name']} {$employeeInfo['last_name']}";

        $adminInfo = $this->user->getUserByuserId(session()->get('user_id'));
        $adminName = "{$adminInfo['first_name']} {$adminInfo['last_name']}";

        // Submitted by admin
        if (session()->get('role') !== UserRole::EMPLOYEE->value) {
            array_push($users, $fileInfo['user_id']);
            $message = "{$adminName} deleted a file of {$employeeName} [{$fileInfo['file_name']}].";
        } else if (session()->get('role') === UserRole::EMPLOYEE->value) { // Submitted by Employee
            $message = "{$employeeName} deleted a file [{$fileInfo['file_name']}].";
        }

        $this->notification->sendNotification($users, $message);

        // Send email
        $emailData = [];

        // Submitted by admin
        if (session()->get('role') !== UserRole::EMPLOYEE->value) {
            $emailData[] = [
                'email' => $employeeInfo['email'],
                'subject' => "File Upload",
                'context' => [
                    'name' => $employeeName,
                    'message' => "{$adminName} deleted a file for you [{$fileInfo['file_name']}].",
                ]
            ];
            $message = "{$adminName} deleted a file for {$employeeName} [{$fileInfo['file_name']}].";
        } else if (session()->get('role') === UserRole::EMPLOYEE->value) { // Submitted by
            $message = "{$employeeName} deleted a file [{$fileInfo['file_name']}].";
        }

        foreach ($admins as $admin) {
            $emailData[] = [
                'email' => $admin['email'],
                'subject' => "{$employeeInfo['first_name']} {$employeeInfo['last_name']} Submitted a Leave.",
                'context' => [
                    'name' => $adminName,
                    'message' => $message,
                ]
            ];
        }

        $this->notification->sendEmail($emailData);

    }
}