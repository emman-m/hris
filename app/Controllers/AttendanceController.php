<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Policy\AuthPolicy;
use App\Models\Attendance;
use App\Services\AttendanceService;
use App\Validations\Attendance\UploadValidation;
use CodeIgniter\Exceptions\PageNotFoundException;
use Config\Database;
use Config\Services;
use Exception;

class AttendanceController extends BaseController
{
    protected $attendance;
    protected $attendanceService;
    // Declare the AuthPolicy instance as a protected property
    protected $auth;

    public function __construct()
    {
        $this->attendance = new Attendance();
        $this->attendanceService = new AttendanceService();

        $this->pager = Services::pager();

        // Initialize the AuthPolicy instance
        $this->auth = new AuthPolicy();
    }

    public function index()
    {
        // Auth user
        if ($this->auth->isEmployee()) {
            throw new PageNotFoundException('Page Not Found', 404);
        }

        // Retrieve filters from the request
        $filters = [
            'from' => $this->request->getGet('from'),
            'to' => $this->request->getGet('to'),
            'search' => $this->request->getGet('search'),
        ];

        // Get the query builder from the model
        $queryBuilder = $this->attendance->search($filters);

        // Apply pagination
        $data = $queryBuilder->paginate();
        $pager = $queryBuilder->pager;

        // Pagination meta
        $paginationInfo = [
            'totalItems' => $pager->getTotal(),
            'start' => ($pager->getCurrentPage() - 1) * $pager->getPerPage() + 1,
            'end' => min($pager->getCurrentPage() * $pager->getPerPage(), $pager->getTotal()),
        ];

        return view('Pages/Attendance/index', [
            'data' => $data,
            'pager' => $pager,
            'paginationInfo' => $paginationInfo,
        ]);
    }

    public function download()
    {
        // Auth user
        if ($this->auth->isEmployee()) {
            throw new PageNotFoundException('Page Not Found', 404);
        }

        // Retrieve filters from the request
        $filters = [
            'from' => $this->request->getGet('from'),
            'to' => $this->request->getGet('to'),
            'search' => $this->request->getGet('search'),
        ];

        // Get the query builder from the model
        $queryBuilder = $this->attendance->search($filters);

        // Retrieve all results
        $results = $queryBuilder->get()->getResultArray();

        // Prepare headers and data for CSV
        $headers = ['No.', 'Employee', 'Employee ID', 'Date', 'Time In', 'Time Out', 'Remarks'];
        // Count number
        $count = 0;
        $data = array_map(function ($row) use (&$count) {
            $count++;

            return [
                $count,
                $row['name'],
                $row['employee_id'],
                $row['transaction_date'],
                $row['time_in'],
                $row['time_out'],
                $row['remark'],
            ];
        }, $results);

        // Use the global CSV download helper
        return downloadCSV('Attendance-' . date('Y-m-d H:i:s') . '.csv', $headers, $data);
    }

    public function print()
    {
        // Auth user
        if ($this->auth->isEmployee()) {
            throw new PageNotFoundException('Page Not Found', 404);
        }

        // Retrieve filters from the request
        $filters = $this->request->getPost();
        // Get the query builder from the model
        $queryBuilder = $this->attendance->search($filters);

        // Retrieve filtered data
        $data = $queryBuilder->get()->getResultArray();

        // Prepare headers for the table
        $headers = ['Employee', 'Employee ID', 'Date', 'Time In', 'Time Out', 'Remarks'];

        // Prepare rows
        $rows = array_map(fn($item) => [
            $item['name'],
            $item['employee_id'],
            $item['transaction_date'],
            $item['time_in'],
            $item['time_out'],
            $item['remark'],
        ], $data);

        // Get the name of the logged-in user
        $downloadedBy = session()->get('name') ?? 'Anonymous';

        // Render the print template and return as JSON
        $html = view('Templates/print', [
            'title' => 'Attendance Report',
            'headers' => $headers,
            'rows' => $rows,
            'downloadedBy' => $downloadedBy,
        ]);

        // Return the printable content and updated CSRF token
        return $this->response->setJSON([
            'html' => $html,
            'csrfToken' => csrf_hash(),
        ]);
    }

    public function create()
    {
        // Auth user
        if ($this->auth->isEmployee()) {
            throw new PageNotFoundException('Page Not Found', 404);
        }

        return view('Pages/Attendance/create');
    }

    public function store()
    {
        // Auth user
        if ($this->auth->isEmployee()) {
            throw new PageNotFoundException('Page Not Found', 404);
        }

        $request = Services::request();

        $validator = new UploadValidation();
        if (!$validator->runValidation($request)) {
            // Validation failed, return to the form with errors
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $validator->getErrors());
        }

        $csvData = $this->attendanceService
            ->getContent($request->getFile('file'));

        if (empty($csvData)) {
            withSwal('warning', 'Attendance file has an existing data.', 'No data saved');

            return redirect()->route('attendance');
        }

        // Start a database transaction
        $db = Database::connect();
        $db->transStart();

        try {
            // Insert the attendance data into the database
            $this->attendance->upsertBatch($csvData);

            // Commit the transaction
            $db->transComplete();

            // Check if the transaction was successful
            if ($db->transStatus() === false) {
                throw new Exception('Transaction failed');
            }

            withToast('success', 'Attendance data imported successfully.');
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $db->transRollback();
            log_message('warning', $e->getMessage());

            withToast('error', 'Error! There was a problem importing the attendance data.');
        }

        return redirect()->route('attendance');
    }
}
