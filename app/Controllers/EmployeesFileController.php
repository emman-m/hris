<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Enums\UserRole;
use App\Libraries\Policy\AuthPolicy;
use App\Models\EmployeesFile;
use App\Models\User;
use App\Services\EmployeeFileService;
use App\Validations\Files\StoreValidation;
use App\Validations\Files\UpdateValidation;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Files\File;
use Config\Database;
use Config\Services;
use Exception;

class EmployeesFileController extends BaseController
{
    protected $employeeFile;
    protected $user;
    protected $employeeFileService;

    public function __construct()
    {
        $this->employeeFile = model('EmployeesFile');
        $this->user = model('User');
        $this->employeeFileService = new EmployeeFileService();
    }
    public function index($user_id = null)
    {
        // Throw 404 if user is not employee with null user_id
        if ($user_id === null && !$this->auth->isEmployee()) {
            throw new PageNotFoundException('Bad request');
        }

        if (!is_null($user_id) && $this->auth->isEmployee()) {
            throw new PageNotFoundException('Bad request');
        }

        $userId = $user_id === null
            ? session()->get('user_id')
            : $user_id;

        // User info
        $user = $this->user->getUserByuserId($userId);

        if (!$this->auth->isEmployee($user['role'])) {
            throw new PageNotFoundException('Bad request');
        }

        $pageTitle = !$user_id
            ? 'My Files'
            : $user['first_name'] . ' ' . $user['last_name'];

        // Retrieve filters from the request
        $filters = [
            'user_id' => $userId,
            'status' => $this->request->getGet('status'),
            'search' => $this->request->getGet('search'),
        ];

        // Get the query builder from the model
        $queryBuilder = $this->employeeFile->search($filters);

        // Apply pagination
        $data = $queryBuilder->paginate();
        $pager = $queryBuilder->pager;

        // Pagination meta
        $paginationInfo = [
            'totalItems' => $pager->getTotal(),
            'start' => ($pager->getCurrentPage() - 1) * $pager->getPerPage() + 1,
            'end' => min($pager->getCurrentPage() * $pager->getPerPage(), $pager->getTotal()),
        ];

        return view('Pages/Files/index', [
            'isEmployee' => $this->auth->isEmployee(),
            'user_id' => $this->auth->isEmployee() ? session()->get('user_id') : $user_id,
            'pageTitle' => $pageTitle,
            'data' => $data,
            'pager' => $pager,
            'paginationInfo' => $paginationInfo,
        ]);
    }

    public function download()
    {
        // Retrieve filters from the request
        $filters = [
            'user_id' => $this->request->getGet('user_id'),
            'search' => $this->request->getGet('search'),
        ];

        // Get the query builder from the model
        $queryBuilder = $this->employeeFile->search($filters);

        // Retrieve all results
        $results = $queryBuilder->get()->getResultArray();

        // Prepare headers and data for CSV
        $headers = ['No.', 'File name', 'Uploaded By', 'Date Upload'];
        // Count number
        $count = 0;
        $data = array_map(function ($row) use (&$count) {
            $count++;

            return [
                $count,
                $row['file_name'],
                $row['uploaded_by'],
                $row['created_at'],
            ];
        }, $results);

        // Use the global CSV download helper
        return downloadCSV('Files-' . date('Y-m-d H:i:s') . '.csv', $headers, $data);
    }

    public function print()
    {
        // Retrieve filters from the request
        $filters = $this->request->getPost();
        // Override role
        $filters['role'] = UserRole::EMPLOYEE->value;
        // Get the query builder from the model
        $queryBuilder = $this->employeeFile->search($filters);

        // Retrieve filtered data
        $data = $queryBuilder->get()->getResultArray();

        // Prepare headers for the table
        $headers = ['File name', 'Uploaded By', 'Date Upload'];

        // Prepare rows
        $rows = array_map(function ($item) {
            return [
                $item['file_name'],
                $item['uploaded_by'],
                $item['created_at'],
            ];
        }, $data);

        // Get the name of the logged-in user
        $downloadedBy = session()->get('name') ?? 'Anonymous';

        // Render the print template and return as JSON
        $html = view('Templates/print', [
            'title' => 'Employees Files Report',
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
        $user_id = $this->request->getGet('user_id');

        if (empty($user_id) && !$this->auth->isEmployee()) {
            withToast('error', 'Employee not found');

            return redirect()->back();
        }

        if (!is_null($user_id) && $this->auth->isEmployee()) {
            throw new PageNotFoundException('Bad request');
        }

        return view('Pages/Files/create', [
            'user_id' => $this->auth->isEmployee() ? session()->get('user_id') : $user_id,
        ]);
    }

    public function store()
    {
        // Get the request object
        $request = Services::request();

        $post = $request->getPost();

        $validator = new StoreValidation();
        // Validate Request

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

            // Check if the file was uploaded successfully
            if ($file->isValid() && !$file->hasMoved()) {
                // Prepare file details
                $fileName = $post['file_name'];

                // Move the uploaded file
                if (!$file->move(WRITEPATH . 'uploads')) {
                    // If moving the file fails, rollback the transaction
                    throw new Exception('Failed to move the uploaded file.');
                }

                $uploadedFileName = $file->getName();
            } else {
                // If no file uploaded, skip file move and insert
                $fileName = null;
                $uploadedFileName = null;
            }

            // Insert data
            $insertData = [
                'user_id' => $post['user_id'],
                'file_name' => $fileName,
                'file' => $uploadedFileName,
                'created_user' => session()->get('user_id')
            ];

            $this->employeeFile->insert($insertData);

            // Commit the transaction
            $db->transComplete();

            // Check if the transaction was successful
            if ($db->transStatus() === false) {
                throw new Exception('Transaction failed');
            }

            // Send notification
            $this->employeeFileService->sendCreateNotif($insertData);

            withToast('success', "Success! $fileName has been uploaded.");
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $db->transRollback();
            log_message('warning', $e->getMessage());

            withToast('error', 'Error! There was a problem uploading file.');

        }

        if ($this->auth->isEmployee()) {
            return redirect()->route('my-files');
        }

        return redirect()->route('files', [$post['user_id']]);

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

        // Start a database transaction
        $db = Database::connect();
        $db->transStart();

        try {
            $this->employeeFile->delete(['id' => $request['id']]);

            // Commit the transaction
            $db->transComplete();

            // Check if the transaction was successful
            if ($db->transStatus() === false) {
                throw new Exception('Transaction failed');
            }

            $fileInfo = $this->employeeFile->where('id', 6)->first();

            // Send notification
            $this->employeeFileService->sendDeleteNotif($request, $fileInfo);

            // Return the response with updated CSRF token
            return $this->response->setJSON([
                'success' => true,
                'message' => "File Deleted",
                'csrfToken' => csrf_hash(),
            ]);

        } catch (Exception $e) {
            $db->transRollback();
            // Log the error
            log_message('error', 'Failed to delete the file: ' . $e->getMessage());

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to delete the file.',
                'csrfToken' => csrf_hash(),
            ]);
        }
    }

    public function edit($file_id)
    {
        if (empty($file_id)) {
            throw new PageNotFoundException('Bad Request');
        }

        $fileData = $this->employeeFile->where(['id' => $file_id])->first();

        if ($this->auth->isEmployee() && $fileData['user_id'] !== session()->get('user_id')) {
            throw new PageNotFoundException('Bad Request');
        }

        return view('Pages/Files/edit', ['id' => $fileData['id'], 'file_name' => $fileData['file_name']]);
    }

    public function update()
    {
        // Get the request object
        $request = Services::request();

        $post = $request->getPost();

        // Validate Request
        $validator = new UpdateValidation($post['id']);

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

            $data = [
                'file_name' => $post['file_name'],
            ];
            // Check if the file was uploaded successfully
            if ($file->isValid() && !$file->hasMoved()) {

                // Move the uploaded file
                if (!$file->move(WRITEPATH . 'uploads')) {
                    // If moving the file fails, rollback the transaction
                    throw new Exception('Failed to move the uploaded file.');
                }

                $data['file'] = $file->getName();
            }

            $this->employeeFile->update($post['id'], $data);

            // Commit the transaction
            $db->transComplete();

            // Check if the transaction was successful
            if ($db->transStatus() === false) {
                throw new Exception('Transaction failed');
            }

            withToast('success', "Success! File has been updated.");
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $db->transRollback();
            log_message('warning', $e->getMessage());

            withToast('error', 'Error! There was a problem saving.');

        }

        return redirect()->route('files-edit', [$post['id']]);
    }

    public function fileDownload($id)
    {
        $fileInfo = $this->employeeFile->where('id', $id)->first();
        $filePath = WRITEPATH . 'uploads/' . $fileInfo['file'];

        // Check if file exists
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File not found.');
        }

        // Use the response helper to download the file
        return $this->response->download($filePath, null)->setFileName($fileInfo['file_name'] . '_' . $fileInfo['file']);
    }

    public function show($filename)
    {
        $path = WRITEPATH . 'uploads/' . $filename;

        if (!file_exists($path)) {
            throw new PageNotFoundException("File not found.");
        }

        $file = new File($path, true);
        $mimeType = $file->getMimeType();
        $fileContent = file_get_contents($path);

        // If the file is an image, serve it directly
        if (strpos($mimeType, 'image') !== false) {
            return $this->response
                ->setHeader('Content-Type', $mimeType)
                ->setStatusCode(200)
                ->setBody($fileContent);
        }

        // For other file types, serve normally
        return $this->response
            ->setHeader('Content-Type', $mimeType)
            ->setHeader('Content-Disposition', 'inline; filename="' . $file->getBasename() . '"')
            ->setStatusCode(200)
            ->setBody($fileContent);
    }
}
