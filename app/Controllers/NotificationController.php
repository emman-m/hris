<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Notification;
use CodeIgniter\Exceptions\PageNotFoundException;

class NotificationController extends BaseController
{
    protected $notification;

    public function __construct()
    {
        $this->notification = new Notification();
    }

    public function index()
    {
        try {
            $data = $this->notification->getAll(session()->get('user_id'));

            // Return the response with updated CSRF token
            return $this->response->setJSON([
                'success' => true,
                'count' => count($data),
                'has_new' => !empty(array_filter($data, function ($item) {
                    return $item['is_read'] == 0;
                })),
                'html' => view('Templates/notification/notif', ['data' => $data]),
                'csrfToken' => csrf_hash(),
            ]);

        } catch (\Exception $e) {
            // Log the error
            log_message('error', 'Failed to fetch notifications: ' . $e->getMessage());

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to fetch notifications: ' . $e->getMessage(),
                'csrfToken' => csrf_hash(),
            ]);
        }
    }

    public function show($id)
    {
        $notification = $this->notification->find($id);

        if (!$notification) {
            throw new PageNotFoundException('Page Not Found');
        }

        $this->notification->update($id, ['is_read' => 1]);

        return view('Pages/notification/show', $notification);
    }
}
