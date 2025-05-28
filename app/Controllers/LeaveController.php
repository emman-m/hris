<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Enums\ApproveStatus;
use App\Enums\LeaveType;
use App\Services\LeaveService;
use App\Services\OfficialBusinessService;
use App\Services\VacationLeaveService;
use App\Validations\Leaves\CreateOBValidator;
use App\Validations\Leaves\CreateVLValidator;
use App\Validations\Leaves\UpdateOBValidator;
use App\Validations\Leaves\UpdateVLValidator;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\Exceptions\PageNotFoundException;
use Config\Database;
use Config\Services;
use Exception;

class LeaveController extends BaseController
{
    protected $leave;
    protected $employeeInfo;
    protected $leaveService;
    protected $user;

    public function __construct()
    {
        $this->leave = model('Leave');
        $this->employeeInfo = model('EmployeeInfo');
        $this->leaveService = new LeaveService();
        $this->user = model('User');
    }

    public function index()
    {
        // Retrieve filters from the request
        $filters = [
            'type' => $this->request->getGet('type'),
            'vl_type' => $this->request->getGet('vl_type'),
            'status' => $this->request->getGet('status'),
            'start_date' => $this->request->getGet('date'),
            'search' => $this->request->getGet('search'),
        ];

        // Get the query builder from the model
        $queryBuilder = $this->leave->search($filters);

        if ($this->auth->isAnyAdmin()) {

        } else {
            if ($this->request->getGet('tab') !== 'department') {
                $queryBuilder->employee();
            } else if ($this->request->getGet('tab') === 'department' && $this->auth->isDepartmentHead()) {
                // If department tab is selected, only show department leaves
                // Get the department head's department
                $departmentHead = $this->user->getUserByuserId(session()->get('user_id'));

                if ($departmentHead && $departmentHead['department']) {
                    // Get all employees in the department
                    $employees = $this->employeeInfo->where('department', $departmentHead['department'])->findAll();
                    $employeeIds = array_column($employees, 'user_id');

                    // Filter leaves for employees in the department
                    $queryBuilder->whereIn('leaves.user_id', $employeeIds);
                }
            }
        }

        // Apply pagination
        $data = $queryBuilder->paginate();
        $pager = $queryBuilder->pager;

        // Pagination meta
        $paginationInfo = [
            'totalItems' => $pager->getTotal(),
            'start' => ($pager->getCurrentPage() - 1) * $pager->getPerPage() + 1,
            'end' => min($pager->getCurrentPage() * $pager->getPerPage(), $pager->getTotal()),
        ];

        return view('Pages/Leaves/index', [
            'data' => $data,
            'pager' => $pager,
            'paginationInfo' => $paginationInfo,
            'isDeptTab' => $this->request->getGet('tab') === 'department',
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
            'type' => $this->request->getGet('type'),
            'vl_type' => $this->request->getGet('vl_type'),
            'status' => $this->request->getGet('status'),
            'start_date' => $this->request->getGet('date'),
            'search' => $this->request->getGet('search'),
        ];

        // Get the query builder from the model
        $queryBuilder = $this->leave
            ->search($filters)
            ->where('leaves.deleted_at IS NULL');

        if ($this->auth->isEmployee()) {
            $queryBuilder->employee();
        }

        // Retrieve all results
        $results = $queryBuilder
            ->get()
            ->getResultArray();


        // Prepare headers and data for CSV
        $headers = [
            'No.',
            'Employee Name',
            'Type',
            'VL Type',
            'Reason',
            'Number of day',
            'Start Date',
            'End Date',
            'Department',
            'Institution',
            'Venue',
            'Status',
            'Time In',
            'Time Out',
            'Approved By',
            'Approved At',
            'Date Created'
        ];

        $data = array_map(function ($row) use (&$count) {
            $count++;

            return [
                $count,
                $row['name'],
                $row['type'],
                $row['vl_type'],
                $row['reason'],
                $row['days'],
                $row['start_date'],
                $row['end_date'],
                $row['department'],
                $row['institution'],
                $row['venue'],
                $row['status'],
                $row['time_in'],
                $row['time_out'],
                $row['approve_by'],
                $row['approve_date'],
                $row['created_at']
            ];
        }, $results);

        // Use the global CSV download helper
        return downloadCSV('Employees Leaves-' . date('Y-m-d H:i:s') . '.csv', $headers, $data);
    }

    public function print()
    {
        // Retrieve filters from the request
        $filters = $this->request->getPost();
        // Get the query builder from the model
        $queryBuilder = $this->leave
            ->search($filters)
            ->where('leaves.deleted_at IS NULL');

        // Retrieve filtered data
        $data = $queryBuilder->get()->getResultArray();

        // Prepare headers for the table
        $headers = [
            'Employee Name',
            'Type',
            'VL Type',
            'Reason',
            'Number of day',
            'Start Date',
            'End Date',
            'Department',
            'Institution',
            'Venue',
            'Status',
            'Time In',
            'Time Out',
            'Approved By',
            'Approved At',
            'Date Created'
        ];

        // Prepare rows
        $rows = array_map(fn($row) => [
            $row['name'],
            $row['type'],
            $row['vl_type'],
            $row['reason'],
            $row['days'],
            $row['start_date'],
            $row['end_date'],
            $row['department'],
            $row['institution'],
            $row['venue'],
            $row['status'],
            $row['time_in'],
            $row['time_out'],
            $row['approve_by'],
            $row['approve_date'],
            $row['created_at']
        ], $data);

        // Get the name of the logged-in user
        $downloadedBy = session()->get('name') ?? 'Anonymous';

        // Render the print template and return as JSON
        $html = view('Templates/print', [
            'title' => 'Employee Leaves',
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
        return view('Pages/Leaves/create');
    }

    public function create_vacation()
    {
        return view('Pages/Leaves/create_vacation');
    }

    public function store_vacation()
    {
        // Get the request object
        $request = Services::request();

        $validator = new CreateVLValidator();
        if (!$validator->runValidation($request)) {
            // Validation failed, return to the form with errors
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $validator->getErrors());
        }

        $post = $request->getPost();

        // Start a database transaction
        $db = Database::connect();
        $db->transStart();

        try {
            $file = $this->request->getFile('approval_proof');

            // Check if the file was uploaded successfully
            if ($file->isValid() && !$file->hasMoved()) {
                // Move the uploaded file
                if (!$file->move(FCPATH . 'uploads')) {
                    // If moving the file fails, rollback the transaction
                    throw new Exception('Failed to move the uploaded file.');
                }

                $post['approval_proof'] = $file->getName();
            }

            // Admin submitted the form
            if (!$this->auth->isEmployee()) {
                $user = $this->employeeInfo->getEmployeeInfoByEmployeeId($post['employee_id']);
                $post['user_id'] = $user['user_id'];
            } else {
                $post['user_id'] = session()->get('user_id');
            }

            $post['created_user_id'] = session()->get('user_id');
            $post['type'] = LeaveType::VACATION_LEAVE->value;
            $post['status'] = ApproveStatus::PENDING->value;

            $this->leave->save($post);

            // Commit the transaction
            $db->transComplete();

            // Check if the transaction was successful
            if ($db->transStatus() === false) {
                throw new Exception('Transaction failed');
            }

            // Send notification
            $this->leaveService->sendCreateNotif($post);

            withToast('success', 'Success! Application for leave created.');
        } catch (DatabaseException $e) {
            // Rollback transaction in case of error
            $db->transRollback();
            log_message('warning', $e->getMessage());

            withToast('error', 'Error! Failed to create application for leave.');
        }

        return redirect()->route('leaves');
    }

    public function edit_vacation($id)
    {
        $data = $this->leave->find($id);

        if (!$data || $data['status'] !== ApproveStatus::PENDING->value) {
            throw new PageNotFoundException('Page Not Found');
        }

        VacationLeaveService::parseData($data);

        return view('Pages/Leaves/edit_vacation');
    }

    public function update_vacation()
    {
        // Auth user
        if (!$this->auth->isEmployee()) {
            throw new PageNotFoundException('Page Not Found', 404);
        }

        // Get the request object
        $request = Services::request();

        $validator = new UpdateVLValidator();
        if (!$validator->runValidation($request)) {
            // Validation failed, return to the form with errors
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $validator->getErrors());
        }

        // Start a database transaction
        $db = Database::connect();
        $db->transStart();

        try {
            $post = $this->request->getPost();

            $file = $this->request->getFile('approval_proof');

            // Check if the file was uploaded successfully
            if ($file->isValid() && !$file->hasMoved()) {
                // Move the uploaded file
                if (!$file->move(FCPATH . 'uploads')) {
                    // If moving the file fails, rollback the transaction
                    throw new Exception('Failed to move the uploaded file.');
                }

                $post['approval_proof'] = $file->getName();
            }

            $this->leave->update($post['id'], $post);

            // Commit the transaction
            $db->transComplete();

            // Check if the transaction was successful
            if ($db->transStatus() === false) {
                throw new Exception('Transaction failed');
            }

            withToast('success', 'Success! Application for leave updated.');

            return redirect()->route('leaves');
        } catch (\Throwable $e) {
            // Rollback transaction in case of error
            $db->transRollback();
            log_message('warning', $e->getMessage());

            withToast('error', 'Error! Failed to update application for leave.');

            return redirect()->route('leaves-vacation-leave-edit', [$this->request->getPost('id')]);
        }
    }

    public function create_official_business()
    {
        return view('Pages/Leaves/create_official_business');
    }

    public function store_official_business()
    {
        // Get the request object
        $request = Services::request();

        $validator = new CreateOBValidator();
        if (!$validator->runValidation($request)) {
            // Validation failed, return to the form with errors
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $validator->getErrors());
        }

        $post = $request->getPost();

        // Start a database transaction
        $db = Database::connect();
        $db->transStart();

        try {
            $file = $this->request->getFile('approval_proof');

            // Check if the file was uploaded successfully
            if ($file->isValid() && !$file->hasMoved()) {
                // Move the uploaded file
                if (!$file->move(FCPATH . 'uploads')) {
                    // If moving the file fails, rollback the transaction
                    throw new Exception('Failed to move the uploaded file.');
                }

                $post['approval_proof'] = $file->getName();
            }
            // Admin submitted the form
            if (!$this->auth->isEmployee()) {
                $user = $this->employeeInfo->getEmployeeInfoByEmployeeId($post['employee_id']);
                $post['user_id'] = $user['user_id'];
            } else {
                $post['user_id'] = session()->get('user_id');
            }

            $post['created_user_id'] = session()->get('user_id');
            $post['type'] = LeaveType::OFFICIAL_BUSINESS->value;
            $post['status'] = ApproveStatus::PENDING->value;
            // $post['start_date'] .= ' 00:00:00';

            $this->leave->save($post);

            // Commit the transaction
            $db->transComplete();

            // Check if the transaction was successful
            if ($db->transStatus() === false) {
                throw new Exception('Transaction failed');
            }

            // Send notification
            $this->leaveService->sendCreateNotif($post);

            withToast('success', 'Success! Application for leave created.');
        } catch (\Throwable $e) {
            // Rollback transaction in case of error
            $db->transRollback();
            log_message('warning', $e->getMessage());

            withToast('error', 'Error! Failed to create application for leave.');
        }

        return redirect()->route('leaves');
    }

    public function edit_official_business($id)
    {
        $data = $this->leave->find($id);

        if (!$data || $data['status'] !== ApproveStatus::PENDING->value) {
            throw new PageNotFoundException('Page Not Found');
        }

        OfficialBusinessService::parseData($data);

        return view('Pages/Leaves/edit_official_business');
    }

    public function update_official_business()
    {
        // Auth user
        if (!$this->auth->isEmployee()) {
            throw new PageNotFoundException('Page Not Found', 404);
        }

        // Get the request object
        $request = Services::request();

        $validator = new UpdateOBValidator();
        if (!$validator->runValidation($request)) {
            // Validation failed, return to the form with errors
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $validator->getErrors());
        }

        // Start a database transaction
        $db = Database::connect();
        $db->transStart();

        try {
            $post = $this->request->getPost();

            $file = $this->request->getFile('approval_proof');

            // Check if the file was uploaded successfully
            if ($file->isValid() && !$file->hasMoved()) {
                // Move the uploaded file
                if (!$file->move(FCPATH . 'uploads')) {
                    // If moving the file fails, rollback the transaction
                    throw new Exception('Failed to move the uploaded file.');
                }

                $post['approval_proof'] = $file->getName();
            }

            $this->leave->update($post['id'], $post);

            // Commit the transaction
            $db->transComplete();

            // Check if the transaction was successful
            if ($db->transStatus() === false) {
                throw new Exception('Transaction failed');
            }

            withToast('success', 'Success! Application for leave updated.');

            return redirect()->route('leaves');
        } catch (\Throwable $e) {
            // Rollback transaction in case of error
            $db->transRollback();
            log_message('warning', $e->getMessage());

            withToast('error', 'Error! Failed to update application for leave.');

            return redirect()->route('leaves-vacation-leave-edit', [$this->request->getPost('id')]);
        }
    }

    public function create_personal_business()
    {
        return view('Pages/Leaves/create_personal_business');
    }

    public function store_personal_business()
    {
        // Get the request object
        $request = Services::request();

        $validator = new CreateOBValidator();
        if (!$validator->runValidation($request)) {
            // Validation failed, return to the form with errors
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $validator->getErrors());
        }

        $post = $request->getPost();

        // Start a database transaction
        $db = Database::connect();
        $db->transStart();

        try {
            $file = $this->request->getFile('approval_proof');

            // Check if the file was uploaded successfully
            if ($file->isValid() && !$file->hasMoved()) {
                // Move the uploaded file
                if (!$file->move(FCPATH . 'uploads')) {
                    // If moving the file fails, rollback the transaction
                    throw new Exception('Failed to move the uploaded file.');
                }

                $post['approval_proof'] = $file->getName();
            }

            // Admin submitted the form
            if (!$this->auth->isEmployee()) {
                $user = $this->employeeInfo->getEmployeeInfoByEmployeeId($post['employee_id']);
                $post['user_id'] = $user['user_id'];
            } else {
                $post['user_id'] = session()->get('user_id');
            }

            $post['created_user_id'] = session()->get('user_id');
            $post['type'] = LeaveType::PERSONAL_BUSINESS->value;
            $post['status'] = ApproveStatus::PENDING->value;
            // $post['start_date'] .= ' 00:00:00';

            $this->leave->save($post);

            // Commit the transaction
            $db->transComplete();

            // Check if the transaction was successful
            if ($db->transStatus() === false) {
                throw new Exception('Transaction failed');
            }

            // Send notification
            $this->leaveService->sendCreateNotif($post);

            withToast('success', 'Success! Application for leave created.');
        } catch (\Throwable $e) {
            // Rollback transaction in case of error
            $db->transRollback();
            log_message('warning', $e->getMessage());

            withToast('error', 'Error! Failed to create application for leave.');
        }

        return redirect()->route('leaves');
    }

    public function edit_personal_business($id)
    {

        $data = $this->leave->find($id);

        if (!$data || $data['status'] !== ApproveStatus::PENDING->value) {
            throw new PageNotFoundException('Page Not Found');
        }

        OfficialBusinessService::parseData($data);

        return view('Pages/Leaves/edit_personal_business');
    }

    public function update_personal_business()
    {
        // Auth user
        if (!$this->auth->isEmployee()) {
            throw new PageNotFoundException('Page Not Found', 404);
        }

        // Get the request object
        $request = Services::request();

        $validator = new UpdateOBValidator();
        if (!$validator->runValidation($request)) {
            // Validation failed, return to the form with errors
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $validator->getErrors());
        }

        // Start a database transaction
        $db = Database::connect();
        $db->transStart();

        try {
            $post = $this->request->getPost();

            $file = $this->request->getFile('approval_proof');

            // Check if the file was uploaded successfully
            if ($file->isValid() && !$file->hasMoved()) {
                // Move the uploaded file
                if (!$file->move(FCPATH . 'uploads')) {
                    // If moving the file fails, rollback the transaction
                    throw new Exception('Failed to move the uploaded file.');
                }

                $post['approval_proof'] = $file->getName();
            }

            $this->leave->update($post['id'], $post);

            // Commit the transaction
            $db->transComplete();

            // Check if the transaction was successful
            if ($db->transStatus() === false) {
                throw new Exception('Transaction failed');
            }

            withToast('success', 'Success! Application for leave updated.');

            return redirect()->route('leaves');
        } catch (\Throwable $e) {
            // Rollback transaction in case of error
            $db->transRollback();
            log_message('warning', $e->getMessage());

            withToast('error', 'Error! Failed to update application for leave.');

            return redirect()->route('leaves-vacation-leave-edit', [$this->request->getPost('id')]);
        }
    }

    public function delete()
    {
        $request = $this->request->getPost();

        // Validate input
        if (!isset($request['id'])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid input data.',
                'csrfToken' => csrf_hash(),
            ]);
        }

        try {
            $this->leave->delete($this->request->getPost('id'));

            // Return the response with updated CSRF token
            return $this->response->setJSON([
                'success' => true,
                'message' => "Leave Deleted",
                'csrfToken' => csrf_hash(),
            ]);

        } catch (Exception $e) {
            // Log the error
            log_message('error', 'Failed to delete the leave: ' . $e->getMessage());

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to delete the leave.' . $e->getMessage(),
                'csrfToken' => csrf_hash(),
            ]);
        }
    }

    public function show($id)
    {
        $leave = $this->leave->findById($id);

        if (!$leave) {
            throw new PageNotFoundException('Page Not Found');
        }
        // Parse the leave data
        if ($leave['type'] == LeaveType::VACATION_LEAVE->value) {
            VacationLeaveService::parseData($leave);
        } elseif ($leave['type'] == LeaveType::OFFICIAL_BUSINESS->value) {
            OfficialBusinessService::parseData($leave);
        }
        // Return the view with the leave data
        return view('Pages/Leaves/show', [
            'leave' => $leave,
            'isAnyAdmin' => $this->auth->isAnyAdmin(),
        ]);
    }

    public function approve_leave($id)
    {
        $leave = $this->leave->findById($id);

        if (!$leave) {
            throw new PageNotFoundException('Page Not Found');
        }

        // Check if user is department head
        if ($this->auth->isDepartmentHead()) {
            $data = [
                'id' => $id,
                'department_head_approval_status' => ApproveStatus::APPROVED->value,
                'department_head_approval_user' => session()->get('user_id'),
                'department_head_approval_date' => date('Y-m-d H:i:s'),
            ];
        } else {
            // Only admin can approve if department head has approved
            if ($leave['department_head_approval_status'] !== ApproveStatus::APPROVED->value) {
                withToast('error', 'Error! Department head must approve first.');
                return redirect()->back();
            }

            $data = [
                'id' => $id,
                'admin_approval_status' => ApproveStatus::APPROVED->value,
                'admin_approval_user' => session()->get('user_id'),
                'admin_approval_date' => date('Y-m-d H:i:s'),
            ];
        }

        return $this->update_status($data);
    }

    public function reject_leave($id)
    {
        $leave = $this->leave->findById($id);

        if (!$leave) {
            throw new PageNotFoundException('Page Not Found');
        }

        // Check if user is department head
        if ($this->auth->isDepartmentHead()) {
            $data = [
                'id' => $id,
                'department_head_approval_status' => ApproveStatus::DENIED->value,
                'department_head_approval_user' => session()->get('user_id'),
                'department_head_approval_date' => date('Y-m-d H:i:s'),
            ];
        } else {
            // Only admin can reject if department head has approved
            if ($leave['department_head_approval_status'] !== ApproveStatus::APPROVED->value) {
                withToast('error', 'Error! Department head must approve first.');
                return redirect()->back();
            }

            $data = [
                'id' => $id,
                'admin_approval_status' => ApproveStatus::DENIED->value,
                'admin_approval_user' => session()->get('user_id'),
                'admin_approval_date' => date('Y-m-d H:i:s'),
            ];
        }

        return $this->update_status($data);
    }

    public function update_status($data)
    {
        // Start a database transaction
        $db = Database::connect();
        $db->transStart();

        try {
            $this->leave->update($data['id'], $data);

            // Commit the transaction
            $db->transComplete();

            // Check if the transaction was successful
            if ($db->transStatus() === false) {
                throw new Exception('Transaction failed');
            }

            // Send notification
            $this->leaveService->sendApproveNotif($data);

            withToast('success', 'Success! Leave updated.');

        } catch (\Throwable $e) {
            // Rollback transaction in case of error
            $db->transRollback();
            log_message('warning', $e->getMessage());

            withToast('error', 'Error! Failed to update leave.');
        }

        return redirect()->back();
    }

    public function print_leave()
    {
        // Retrieve filters from the request
        $filters = $this->request->getPost();

        // Retrieve filtered data
        $data = $this->leave
            ->findById($filters['id']);

        // Get the name of the logged-in user
        $downloadedBy = session()->get('name') ?? 'Anonymous';

        $view = $data['type'] === LeaveType::VACATION_LEAVE->value
            ? 'Templates/leave/vacation_leave_details'
            : 'Templates/leave/official_personal_leave_details';

        // Render the print template and return as JSON
        $html = view($view, [
            'title' => 'Application for Leave',
            'leave' => $data,
            'downloadedBy' => $downloadedBy,
        ]);

        // Return the printable content and updated CSRF token
        return $this->response->setJSON([
            'html' => $html,
            'csrfToken' => csrf_hash(),
        ]);
    }
}
