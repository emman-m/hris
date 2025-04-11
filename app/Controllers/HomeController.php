<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Policy\AuthPolicy;
use App\Models\Announcement;
use App\Services\WidgetService;

class HomeController extends BaseController
{
    protected $announcement;
    protected $auth;
    protected $widgetService;

    public function __construct()
    {
        $this->announcement = new Announcement();
        $this->auth = new AuthPolicy();
        $this->widgetService = new WidgetService();
    }

    public function index()
    {
        // Get announcement
        $data['announcement'] = $this->widgetService->getAnnouncement();

        // New Employee This month
        $data['newEmployeeCount'] = $this->widgetService->getNewEmployeeCount();

        // Leave Count this month
        $data['leaveCount'] = $this->widgetService->getLeaveCount();

        // Announcement Count this month
        $data['announcementCount'] = $this->widgetService->getAnnouncementCount();

        // Latest Attendance data
        $data['latestAttendance'] = $this->widgetService->getAttendanceLatestDate();

        $data['tardinessRate'] = $this->widgetService->getTardinessRate('2025-01-30');

        return view('Pages/Dashboard/dashboard', $data);
    }
}