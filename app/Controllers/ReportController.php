<?php

namespace App\Controllers;

use App\Enums\EmployeeDepartment;
use App\Services\WidgetService;

class ReportController extends BaseController
{
    protected $widgetService;

    public function __construct()
    {
        $this->widgetService = new WidgetService();
    }

    public function turnoverRate()
    {
        $month = $this->request->getGet('month') ?? date('Y-m');
        $department = $this->request->getGet('department');
        $turnoverData = $this->widgetService->getTurnoverRateReport($month, $department);

        $data = [
            'title' => 'Turnover Rate Report',
            'month' => $month,
            'department' => $department,
            'turnover' => $turnoverData,
        ];

        return view('Pages/Reports/Turnover/index', $data);
    }

    public function tardinessRate()
    {
        $month = $this->request->getGet('month') ?? date('Y-m');
        $department = $this->request->getGet('department');

        $data = [
            'title' => 'Tardiness Rate Report',
            'month' => $month,
            'department' => $department,
            'tardiness' => $this->widgetService->getTardinessRateReport($month, $department),
            'departments' => EmployeeDepartment::list()
        ];

        return view('Pages/Reports/Tardiness/index', $data);
    }
} 