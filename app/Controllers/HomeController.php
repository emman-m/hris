<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Announcement;
use App\Services\WidgetService;

class HomeController extends BaseController
{
    protected $announcement;

    public function __construct()
    {
        $this->announcement = new Announcement();
    }

    public function index()
    {
        // Get announcement
        $data['announcement'] = WidgetService::getAnnouncement($this->announcement);

        return view('Pages/Dashboard/dashboard', $data);
    }
}