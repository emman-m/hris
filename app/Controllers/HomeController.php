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

    public function __construct()
    {
        $this->announcement = new Announcement();
        $this->auth = new AuthPolicy();
    }

    public function index()
    {
        // Get announcement
        $data['announcement'] = WidgetService::getAnnouncement($this->announcement, $this->auth);

        return view('Pages/Dashboard/dashboard', $data);
    }
}