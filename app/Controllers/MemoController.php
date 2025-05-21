<?php

namespace App\Controllers;

use App\Enums\UserRole;
use App\Models\MemoModel;
use App\Models\UserModel;
use App\Validations\Memo\CreateValidator;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\Exceptions\PageNotFoundException;
use Config\Database;
use Config\Services;
use Exception;

class MemoController extends BaseController
{
    protected $memoModel;
    protected $userModel;
    protected $pager;

    public function __construct()
    {
        $this->memoModel = model('Memo');
        $this->userModel = model('User');
        $this->pager = Services::pager();
    }

    public function index()
    {
        // Auth user
        if ($this->auth->isEmployee()) {
            throw new PageNotFoundException('Page Not Found', 404);
        }

        // Retrieve filters from the request
        $filters = [
            'search' => $this->request->getGet('search'),
        ];

        // Get the query builder from the model
        $queryBuilder = $this->memoModel->search($filters);

        // Apply pagination
        $data = $queryBuilder->paginate();
        $pager = $queryBuilder->pager;

        // Pagination meta
        $paginationInfo = [
            'totalItems' => $pager->getTotal(),
            'start' => ($pager->getCurrentPage() - 1) * $pager->getPerPage() + 1,
            'end' => min($pager->getCurrentPage() * $pager->getPerPage(), $pager->getTotal()),
        ];

        // Get recipients for each memo
        foreach ($data as &$memo) {
            $recipients = $this->memoModel->db->table('memo_recipients')
                ->select('users_info.user_id, CONCAT(users_info.first_name, " ", users_info.middle_name, " ", users_info.last_name) as name')
                ->join('users_info', 'users_info.user_id = memo_recipients.user_id')
                ->where('memo_recipients.memo_id', $memo['id'])
                ->get()
                ->getResultArray();

            $memo['recipients'] = $recipients;
        }

        return view('Pages/Memo/index', [
            'title' => 'Memos',
            'memos' => $data,
            'pager' => $pager,
            'paginationInfo' => $paginationInfo,
        ]);
    }

    public function create()
    {
        // Auth user
        if ($this->auth->isEmployee()) {
            throw new PageNotFoundException('Page Not Found', 404);
        }

        return view('Pages/Memo/create', [
            'title' => 'Create Memo',
            'users' => $this->userModel->where('role !=', 'employee')->findAll()
        ]);
    }

    public function store()
    {
        // Auth user
        if ($this->auth->isEmployee()) {
            throw new PageNotFoundException('Page Not Found', 404);
        }

        // Get the request object
        $request = Services::request();

        $validator = new CreateValidator();
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
            $file = $this->request->getFile('file');
            $newName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads/memos', $newName);

            $memoData = [
                'title' => $this->request->getPost('title'),
                'file_path' => 'uploads/memos/' . $newName,
                'created_by' => session()->get('user_id')
            ];

            $memoId = $this->memoModel->insert($memoData);

            if ($memoId) {
                $this->memoModel->addRecipients($memoId, $this->request->getPost('recipients'));
            }

            // Commit the transaction
            $db->transComplete();

            // Check if the transaction was successful
            if ($db->transStatus() === false) {
                throw new Exception('Transaction failed');
            }

            withToast('success', 'Success! New Memo has been created.');
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $db->transRollback();
            log_message('warning', $e->getMessage());

            withToast('error', 'Error! There was a problem creating the memo.');
        }

        return redirect()->route('memos');
    }

    public function edit($id)
    {
        // Auth user
        if ($this->auth->isEmployee()) {
            throw new PageNotFoundException('Page Not Found', 404);
        }

        $memo = $this->memoModel->getMemosWithRecipients($id);

        if (empty($memo)) {
            withToast('error', 'Memo not found');
            return redirect()->route('memos');
        }

        return view('Pages/Memo/edit', [
            'title' => 'Edit Memo',
            'memo' => $memo[0],
            'users' => $this->userModel->where('role !=', UserRole::EMPLOYEE->value)->findAll()
        ]);
    }

    public function update($id)
    {
        // Auth user
        if ($this->auth->isEmployee()) {
            throw new PageNotFoundException('Page Not Found', 404);
        }

        // Get the request object
        $request = Services::request();

        // Get current memo data
        $memo = $this->memoModel->find($id);
        if (empty($memo)) {
            withToast('error', 'Memo not found');
            return redirect()->route('memos');
        }

        // Validation rules
        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'recipients' => 'required'
        ];

        // Add file validation only if a new file is uploaded
        if ($this->request->getFile('file')->isValid()) {
            $rules['file'] = 'uploaded[file]|mime_in[file,application/pdf]|max_size[file,10240]';
        }

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Start a database transaction
        $db = Database::connect();
        $db->transStart();

        try {
            $memoData = [
                'title' => $this->request->getPost('title')
            ];

            // Handle file upload if a new file is provided
            if ($this->request->getFile('file')->isValid()) {
                $file = $this->request->getFile('file');
                $newName = $file->getRandomName();
                $file->move(WRITEPATH . 'uploads/memos', $newName);
                $memoData['file_path'] = 'uploads/memos/' . $newName;

                // Delete old file
                $oldFile = WRITEPATH . $memo['file_path'];
                if (file_exists($oldFile)) {
                    unlink($oldFile);
                }
            }

            // Update memo
            if ($this->memoModel->update($id, $memoData)) {
                // Update recipients
                $this->memoModel->deleteRecipients($id);
                $this->memoModel->addRecipients($id, $this->request->getPost('recipients'));

                // Commit the transaction
                $db->transComplete();

                // Check if the transaction was successful
                if ($db->transStatus() === false) {
                    throw new Exception('Transaction failed');
                }

                withToast('success', 'Success! Memo has been updated.');
                return redirect()->route('memos');
            }

            throw new Exception('Failed to update memo');
        } catch (DatabaseException $e) {
            // Rollback transaction in case of error
            $db->transRollback();
            log_message('error', $e->getMessage());

            withToast('error', 'Error! There was a problem updating the memo.');
            return redirect()->back()->withInput();
        }
    }

    public function delete()
    {
        // Auth user
        if ($this->auth->isEmployee()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unauthorized access',
                'csrfToken' => csrf_hash()
            ])->setStatusCode(403);
        }

        $id = $this->request->getPost('id');
        if (!$id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Memo ID is required',
                'csrfToken' => csrf_hash()
            ])->setStatusCode(400);
        }

        $memo = $this->memoModel->find($id);
        if (empty($memo)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Memo not found',
                'csrfToken' => csrf_hash()
            ])->setStatusCode(404);
        }

        // Start transaction
        $db = Database::connect();
        $db->transStart();

        try {
            // Delete file
            $file = WRITEPATH . $memo['file_path'];
            if (file_exists($file)) {
                unlink($file);
            }

            // Delete memo (this will cascade delete recipients due to foreign key)
            if ($this->memoModel->delete($id)) {
                $db->transComplete();

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Memo deleted successfully',
                    'csrfToken' => csrf_hash()
                ]);
            }

            throw new Exception('Failed to delete memo');
        } catch (Exception $e) {
            $db->transRollback();
            log_message('error', $e->getMessage());

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to delete memo',
                'csrfToken' => csrf_hash()
            ])->setStatusCode(500);
        }
    }

    public function download($id)
    {
        $memo = $this->memoModel->find($id);
        if (empty($memo)) {
            withToast('error', 'Memo not found');
            return redirect()->route('memos');
        }

        // Check if user is authorized to access this memo
        if ($this->auth->isEmployee()) {
            // For employees, check if they are a recipient
            $isRecipient = $this->memoModel->db->table('memo_recipients')
                ->where('memo_id', $id)
                ->where('user_id', session()->get('user_id'))
                ->countAllResults() > 0;

            if (!$isRecipient) {
                throw new PageNotFoundException('Page Not Found', 404);
            }
        }

        $file = WRITEPATH . $memo['file_path'];
        if (!file_exists($file)) {
            withToast('error', 'File not found');
            return redirect()->route('memos');
        }

        // Set headers for PDF download
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $memo['title'] . '.pdf"');
        header('Content-Length: ' . filesize($file));
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: 0');

        // Output the file
        readfile($file);
        exit;
    }

    public function preview($id)
    {
        $memo = $this->memoModel->find($id);
        if (empty($memo)) {
            withToast('error', 'Memo not found');
            return redirect()->route('memos');
        }

        // Check if user is authorized to access this memo
        if ($this->auth->isEmployee()) {
            // For employees, check if they are a recipient
            $isRecipient = $this->memoModel->db->table('memo_recipients')
                ->where('memo_id', $id)
                ->where('user_id', session()->get('user_id'))
                ->countAllResults() > 0;

            if (!$isRecipient) {
                throw new PageNotFoundException('Page Not Found', 404);
            }
        }

        $file = WRITEPATH . $memo['file_path'];
        if (!file_exists($file)) {
            withToast('error', 'File not found');
            return redirect()->route('memos');
        }

        // Set headers for PDF preview
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . $memo['title'] . '.pdf"');
        header('Content-Length: ' . filesize($file));
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: 0');

        // Output the file
        readfile($file);
        exit;
    }

    public function searchUsers()
    {
        // Auth user
        if ($this->auth->isEmployee()) {
            throw new PageNotFoundException('Page Not Found', 404);
        }

        $search = $this->request->getGet('search');
        $page = $this->request->getGet('page') ?? 1;
        $perPage = 10;

        $query = $this->userModel->where('users.role', UserRole::EMPLOYEE->value)
            ->join('users_info', 'users_info.user_id = users.id')
            ->join('employees_info', 'employees_info.user_id = users.id', 'left');

        if (!empty($search)) {
            $query->groupStart()
                ->like('users_info.first_name', $search)
                ->orLike('users_info.middle_name', $search)
                ->orLike('users_info.last_name', $search)
                ->orLike('users.email', $search)
                ->orLike('employees_info.employee_id', $search)
                ->groupEnd();
        }

        $total = $query->countAllResults(false);
        $users = $query->select('users.id, CONCAT("[", employees_info.employee_id, "] " ,users_info.first_name, " ", users_info.middle_name, " ", users_info.last_name) as name')
            ->limit($perPage, ($page - 1) * $perPage)
            ->findAll();

        return $this->response->setJSON([
            'items' => $users,
            'pagination' => [
                'more' => ($page * $perPage) < $total
            ]
        ]);
    }
}