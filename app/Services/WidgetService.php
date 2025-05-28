<?php

namespace App\Services;

use App\Enums\ApproveStatus;
use App\Enums\UserRole;
use App\Libraries\Policy\AuthPolicy;
use App\Models\TurnoverReport;

class WidgetService extends Service
{
    protected $announcement;
    protected $user;
    protected $leave;
    protected $attendance;
    protected $auth;
    protected $turnoverReport;

    public function __construct()
    {
        $this->announcement = model('Announcement');
        $this->user = model('User');
        $this->leave = model('Leave');
        $this->attendance = model('Attendance');
        $this->auth = new AuthPolicy();
        $this->turnoverReport = model(TurnoverReport::class);
    }

    public function getAnnouncement(array $filters = [])
    {
        // Get the query builder from the model
        $queryBuilder = $this->announcement->search($filters);

        // Filter employee announcement
        if ($this->auth->isEmployee()) {
            $queryBuilder = $queryBuilder->validUser();
        }

        // Apply pagination
        $data = $queryBuilder->paginate(1);
        $pager = $queryBuilder->pager;

        // Pagination meta
        $paginationInfo = [
            'totalItems' => $pager->getTotal(),
            'start' => ($pager->getCurrentPage() - 1) * $pager->getPerPage() + 1,
            'end' => min($pager->getCurrentPage() * $pager->getPerPage(), $pager->getTotal()),
        ];

        return [
            'data' => $data,
            'pager' => $pager,
            'paginationInfo' => $paginationInfo,
        ];
    }

    public function getEmployeeData($dateData = null)
    {
        return [
            'total' => $this->getEmployeeCount(),
            'new' => $this->getNewEmployeeCount($dateData),
        ];
    }

    public function getNewEmployeeCount($dateData = null)
    {
        $date = $dateData === null ? date('Y-m') : $dateData;

        $builder = $this->user
            ->where('role', UserRole::EMPLOYEE->value)
            ->like('created_at', $date);

        return $builder->countAllResults();
    }

    public function getEmployeeCount()
    {
        $builder = $this->user
            ->where('role', UserRole::EMPLOYEE->value);

        return $builder->countAllResults();
    }

    public function getLeaveCount($dateData = null)
    {
        $date = $dateData === null ? date('Y-m') : $dateData;

        $pendingLeave = $this->leave
            ->where('admin_approval_status', ApproveStatus::PENDING->value)
            ->like('created_at', $date)
            ->countAllResults();

        $totalLeave = $this->leave
            ->like('created_at', $date)
            ->countAllResults();

        return [
            'total' => $totalLeave,
            'pending' => $pendingLeave,
        ];
    }

    public function getAnnouncementCount($dateData = null)
    {
        $date = $dateData === null ? date('Y-m') : $dateData;

        return $this->announcement
            ->like('created_at', $date)
            ->countAllResults();
    }

    public function getAttendanceLatestDate()
    {
        $response = $this->attendance
            ->select('transaction_date')
            ->orderBy('transaction_date', 'DESC')
            ->first();

        return $response['transaction_date'] ?? null;
    }

    public function getTardinessRate($endDate = null, $days = 15)
    {
        // latest date data
        $endDate = ($endDate === null)
            ? $this->getAttendanceLatestDate()
            : $endDate ?? date('Y-m-d');

        $startDate = date('Y-m-d', strtotime("-$days days", strtotime($endDate)));

        $rates = [];
        $tardyEmployees = [];
        $currentDate = $startDate;

        while ($currentDate <= $endDate) {
            // Get all attendance records for the date
            $attendances = $this->attendance
                ->where('transaction_date', $currentDate)
                ->orderBy('time_in', 'ASC')
                ->findAll();

            // Group by employee_id and get earliest time_in
            $employeeTimes = [];
            foreach ($attendances as $attendance) {
                $employeeId = $attendance['employee_id'];
                if (
                    !isset($employeeTimes[$employeeId]) ||
                    strtotime($attendance['time_in']) < strtotime($employeeTimes[$employeeId])
                ) {
                    $employeeTimes[$employeeId] = $attendance['time_in'];
                }
            }

            // Count tardy employees (time_in > 06:30:00)
            $tardyCount = 0;
            foreach ($employeeTimes as $employeeId => $timeIn) {
                if (strtotime($timeIn) > strtotime('07:00:00')) {
                    $tardyCount++;
                    // Track unique tardy employees
                    if (!in_array($employeeId, $tardyEmployees)) {
                        $tardyEmployees[] = $employeeId;
                    }
                }
            }

            $totalEmployees = count($employeeTimes);
            $rate = $totalEmployees > 0 ? ($tardyCount / $totalEmployees) * 100 : 0;

            $rates[$currentDate] = round($rate, 2);
            $currentDate = date('Y-m-d', strtotime('+1 day', strtotime($currentDate)));
        }

        return [
            'rates' => $rates,
            'total_tardy_employees' => count($tardyEmployees),
            'tardy_employee_ids' => $tardyEmployees
        ];
    }

    public function getTurnoverRate($endDate = null, $days = 15)
    {
        $endDate = ($endDate === null)
            ? date('Y-m-d')
            : $endDate ?? date('Y-m-d');

        $startDate = date('Y-m-d', strtotime("-$days days", strtotime($endDate)));

        $rates = [];
        $uniqueEmployees = [];

        $currentDate = $startDate;

        while ($currentDate <= $endDate) {
            // Query turnover reports for the current date
            $reports = $this->turnoverReport
                ->select('user_id')
                ->where('DATE(created_at)', $currentDate)
                ->findAll();

            $dailyEmployeeIds = array_unique(array_column($reports, 'user_id'));

            // Track unique employees across all days
            foreach ($dailyEmployeeIds as $userId) {
                if (!in_array($userId, $uniqueEmployees)) {
                    $uniqueEmployees[] = $userId;
                }
            }

            $rates[$currentDate] = count($dailyEmployeeIds);

            $currentDate = date('Y-m-d', strtotime('+1 day', strtotime($currentDate)));
        }

        return [
            'rates' => $rates,
            'total_employees' => count($uniqueEmployees),
            'employee_ids' => $uniqueEmployees,
        ];
    }

    public function getTardinessRateReport($month = null, $department = null)
    {
        $month = $month ?? date('Y-m');
        $startDate = date('Y-m-01', strtotime($month));
        $endDate = date('Y-m-t', strtotime($month));

        $rates = [];
        $tardyEmployees = [];
        $departmentRates = [];

        $currentDate = $startDate;

        while ($currentDate <= $endDate) {
            // Get all attendance records for the date with department info
            $query = $this->attendance
                ->select('attendances.employee_id, attendances.time_in, employees_info.department')
                ->join('employees_info', 'employees_info.employee_id = attendances.employee_id', 'left')
                ->where('attendances.transaction_date', $currentDate);

            // Add department filter if specified
            if ($department && $department !== 'all') {
                $query->where('employees_info.department', $department);
            }

            $query->orderBy('attendances.time_in', 'ASC');
            $attendances = $query->findAll();

            // Group by employee_id and get earliest time_in
            $employeeTimes = [];
            $employeeDepartments = [];
            foreach ($attendances as $attendance) {
                $employeeId = $attendance['employee_id'];
                if (
                    !isset($employeeTimes[$employeeId]) ||
                    strtotime($attendance['time_in']) < strtotime($employeeTimes[$employeeId])
                ) {
                    $employeeTimes[$employeeId] = $attendance['time_in'];
                    $employeeDepartments[$employeeId] = $attendance['department'] ?? 'No Department';
                }
            }

            // Count tardy employees by department
            $departmentData = [];
            foreach ($employeeTimes as $employeeId => $timeIn) {
                if (strtotime($timeIn) > strtotime('07:00:00')) {
                    $dept = $employeeDepartments[$employeeId];
                    if (!isset($departmentData[$dept])) {
                        $departmentData[$dept] = [];
                    }
                    $departmentData[$dept][] = $employeeId;

                    // Track unique tardy employees
                    if (!in_array($employeeId, $tardyEmployees)) {
                        $tardyEmployees[] = $employeeId;
                    }
                }
            }

            // Calculate rates for each department
            foreach ($departmentData as $dept => $employeeIds) {
                if (!isset($departmentRates[$dept])) {
                    $departmentRates[$dept] = [
                        'rates' => [],
                        'total_employees' => 0,
                        'employee_ids' => []
                    ];
                }

                $deptTotalEmployees = count(array_filter($employeeDepartments, function ($d) use ($dept) {
                    return $d === $dept;
                }));

                $rate = $deptTotalEmployees > 0 ? (count($employeeIds) / $deptTotalEmployees) * 100 : 0;
                $departmentRates[$dept]['rates'][$currentDate] = round($rate, 2);

                // Track unique employees for this department
                foreach ($employeeIds as $employeeId) {
                    if (!in_array($employeeId, $departmentRates[$dept]['employee_ids'])) {
                        $departmentRates[$dept]['employee_ids'][] = $employeeId;
                    }
                }
                $departmentRates[$dept]['total_employees'] = count($departmentRates[$dept]['employee_ids']);
            }

            // Calculate overall rate
            $totalEmployees = count($employeeTimes);
            $tardyCount = count(array_filter($employeeTimes, function ($timeIn) {
                return strtotime($timeIn) > strtotime('07:00:00');
            }));
            $rate = $totalEmployees > 0 ? ($tardyCount / $totalEmployees) * 100 : 0;
            $rates[$currentDate] = round($rate, 2);

            $currentDate = date('Y-m-d', strtotime('+1 day', strtotime($currentDate)));
        }

        return [
            'rates' => $rates,
            'total_tardy_employees' => count($tardyEmployees),
            'tardy_employee_ids' => $tardyEmployees,
            'department_rates' => $departmentRates
        ];
    }

    public function getTurnoverRateReport($month = null, $department = null)
    {
        $month = $month ?? date('Y-m');
        $startDate = date('Y-m-01', strtotime($month));
        $endDate = date('Y-m-t', strtotime($month));

        $rates = [];
        $uniqueEmployees = [];
        $departmentRates = [];

        $currentDate = $startDate;

        while ($currentDate <= $endDate) {
            // Build the query with left join
            $query = $this->turnoverReport
                ->select('turnover_reports.user_id, employees_info.department')
                ->join('employees_info', 'employees_info.user_id = turnover_reports.user_id', 'left')
                ->where('DATE(turnover_reports.created_at)', $currentDate);

            // Get the reports for the current date
            $reports = $query->findAll();

            // Group reports by department
            $departmentData = [];
            foreach ($reports as $report) {
                $dept = $report['department'] ?? 'No Department';
                if (!isset($departmentData[$dept])) {
                    $departmentData[$dept] = [];
                }
                $departmentData[$dept][] = $report['user_id'];
            }

            // If specific department is selected
            if ($department && $department !== 'all') {
                // dd($department);
                $deptReports = isset($departmentData[$department]) ? $departmentData[$department] : [];
                $dailyEmployeeIds = array_unique($deptReports);
                $rates[$currentDate] = count($dailyEmployeeIds);
            } else {
                // Store data for each department separately
                foreach ($departmentData as $dept => $employeeIds) {
                    if (!isset($departmentRates[$dept])) {
                        $departmentRates[$dept] = [
                            'rates' => [],
                            'total_employees' => 0,
                            'employee_ids' => []
                        ];
                    }
                    
                    $dailyEmployeeIds = array_unique($employeeIds);
                    $departmentRates[$dept]['rates'][$currentDate] = count($dailyEmployeeIds);
                    
                    // Track unique employees for this department
                    foreach ($dailyEmployeeIds as $userId) {
                        if (!in_array($userId, $departmentRates[$dept]['employee_ids'])) {
                            $departmentRates[$dept]['employee_ids'][] = $userId;
                        }
                    }
                    $departmentRates[$dept]['total_employees'] = count($departmentRates[$dept]['employee_ids']);
                }
                
                // For overall rates, combine all departments
                $allEmployeeIds = array_unique(array_column($reports, 'user_id'));
                $rates[$currentDate] = count($allEmployeeIds);
            }

            // Track unique employees across all days for overall total
            $allEmployeeIds = array_unique(array_column($reports, 'user_id'));
            foreach ($allEmployeeIds as $userId) {
                if (!in_array($userId, $uniqueEmployees)) {
                    $uniqueEmployees[] = $userId;
                }
            }

            $currentDate = date('Y-m-d', strtotime('+1 day', strtotime($currentDate)));
        }

        return [
            'rates' => $rates,
            'total_employees' => count($uniqueEmployees),
            'employee_ids' => $uniqueEmployees,
            'department_rates' => $departmentRates
        ];
    }
}