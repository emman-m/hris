<?php

namespace App\Services;

use App\Enums\LeaveType;
use App\Enums\ApproveStatus;

class LeaveService extends Service
{

    protected $user;
    protected $leave;
    protected $employeeInfo;
    protected $notification;

    public function __construct()
    {
        $this->user = model('User');
        $this->leave = model('Leave');
        $this->employeeInfo = model('EmployeeInfo');
        $this->notification = new NotificationService();
    }

    public function sendCreateNotif($data)
    {
        // Get department head for the employee's department
        $employeeInfo = $this->user->getUserByuserId($data['user_id']);
        $departmentHead = $this->user->getDepartmentHead($employeeInfo['department']);
        
        // Get all admins
        $admins = $this->user->getAllAdmin();
        
        // Combine department head and admins for notification
        $users = array_column($admins, 'id');
        if ($departmentHead) {
            $users[] = $departmentHead['user_id'];
        }

        // Save Notification
        $this->notification->sendNotification($users, "{$employeeInfo['first_name']} {$employeeInfo['last_name']} Submitted an {$this->getLeaveType($data['type'])}.");
        
        // Prepare email data
        $emailData = [];
        
        // Add department head email
        if ($departmentHead) {
            // $deptHeadInfo = $this->user->getUserByuserId($departmentHead['user_id']);
            $emailData[] = [
                'email' => $departmentHead['email'],
                'subject' => "{$employeeInfo['first_name']} {$employeeInfo['last_name']} Submitted a Leave.",
                'context' => [
                    'name' => $departmentHead['name'],
                    'message' => "{$employeeInfo['first_name']} {$employeeInfo['last_name']} Submitted an {$this->getLeaveType($data['type'])}.",
                ]
            ];
        }
        
        // Add admin emails
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
        $employeeInfo = $this->user->getUserByuserId($leave['user_id']);
        
        // Determine who approved and what status
        $isDepartmentHead = isset($data['department_head_approval_status']);
        $approver = $isDepartmentHead ? $leave['dept_head_approve_by'] : $leave['admin_approve_by'];
        $status = $isDepartmentHead ? $data['department_head_approval_status'] : $data['admin_approval_status'];
        
        // Prepare notification message
        $message = "{$approver} has {$status} your leave application.";
        
        // Save Notification for employee
        $this->notification->sendNotification($leave['user_id'], $message);
        
        // If department head approved, notify admins
        if ($isDepartmentHead && $status === ApproveStatus::APPROVED->value) {
            $admins = $this->user->getAllAdmin();
            $adminIds = array_column($admins, 'id');
            
            $this->notification->sendNotification(
                $adminIds,
                "Department Head {$approver} has approved {$employeeInfo['first_name']} {$employeeInfo['last_name']}'s leave application."
            );
            
            // Send email to admins
            $emailData = [];
            foreach ($admins as $admin) {
                $emailData[] = [
                    'email' => $admin['email'],
                    'subject' => "Leave Application Approved by Department Head",
                    'context' => [
                        'name' => $admin['name'],
                        'message' => "Department Head {$approver} has approved {$employeeInfo['first_name']} {$employeeInfo['last_name']}'s leave application.",
                    ]
                ];
            }
            $this->notification->sendEmail($emailData);
        }
        
        // Send email to employee
        $emailData = [
            [
                'email' => $leave['email'],
                'subject' => "Leave Application {$status}",
                'context' => [
                    'name' => $leave['name'],
                    'message' => $message,
                ]
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