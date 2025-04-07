<?php

namespace App\Services;

use App\Models\Notification;

class NotificationService
{
    protected $notification;
    protected $sendMail;

    public function __construct()
    {
        $this->notification = new Notification();
        $this->sendMail = new SendMail();
    }

    public function sendNotification($userId, $context)
    {
        // Convert userId to an array if it's not already
        $userIds = normalizeArray($userId);

        $data = [];

        foreach ($userIds as $userId) {
            $data[] = [
                'user_id' => $userId,
                'context' => $context,
                'is_read' => false,
            ];
        }

        // Save the notification to the database
        $this->notification->insertBatch($data);
    }

    public function sendEmail(array $info)
    {
        foreach ($info as $data) {
            $this->sendMail->setTo($data['email'])
                ->setSubject($data['subject'])
                ->setMessage($data['template'] ?? 'notification', $data['context'])
                ->send();
        }

    }
}