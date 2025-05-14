<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\WidgetService;

class HomeController extends BaseController
{
    protected $widgetService;
    protected $memo;

    public function __construct()
    {
        $this->widgetService = new WidgetService();
        $this->memo = model('Memo');
    }

    public function index()
    {
        // Get announcement
        $data['announcement'] = $this->widgetService->getAnnouncement();

        // New Employee This month
        $data['employeeCount'] = $this->widgetService->getEmployeeData();

        // Leave Count this month
        $data['leaveCount'] = $this->widgetService->getLeaveCount();

        // Announcement Count this month
        $data['announcementCount'] = $this->widgetService->getAnnouncementCount();

        // Latest Attendance data
        $data['latestAttendance'] = $this->widgetService->getAttendanceLatestDate();

        $data['tardinessRate'] = $this->widgetService->getTardinessRate();
        $data['turnOverRate'] = $this->widgetService->getTurnoverRate();

        // Get recent memos where current user is a recipient
        $data['memos'] = $this->memo->getDashboardMemos(session()->get('user_id'));

        return view('Pages/Dashboard/dashboard', $data);
    }
}