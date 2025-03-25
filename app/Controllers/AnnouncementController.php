<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Policy\AuthPolicy;
use App\Models\Announcement;
use App\Services\Announcement as AnnouncementService;
use App\Validations\Announcement\CreateValidator;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Database;
use Config\Services;
use Exception;

class AnnouncementController extends BaseController
{
    protected $announcement;
    protected $auth;
    protected $pager;

    public function __construct()
    {
        $this->announcement = new Announcement();
        $this->auth = new AuthPolicy();
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
            'search' => $this->request->getGet('search')
        ];

        // Get the query builder from the model
        $queryBuilder = $this->announcement->search($filters)->withDeleted(false);

        // Apply pagination
        $data = $queryBuilder->paginate();
        $pager = $queryBuilder->pager;

        // Pagination meta
        $paginationInfo = [
            'totalItems' => $pager->getTotal(),
            'start' => ($pager->getCurrentPage() - 1) * $pager->getPerPage() + 1,
            'end' => min($pager->getCurrentPage() * $pager->getPerPage(), $pager->getTotal()),
        ];

        return view('Pages/Announcement/index', [
            'data' => $data,
            'pager' => $pager,
            'paginationInfo' => $paginationInfo,
        ]);
    }

    public function create()
    {
        return view('Pages/Announcement/create');
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

        $post = $request->getPost();

        // Start a database transaction
        $db = Database::connect();
        $db->transStart();

        try {
            $post['created_id'] = session()->get('user_id');
            $post['content'] = esc($post['content']);
            $this->announcement->save($post);

            // Commit the transaction
            $db->transComplete();

            // Check if the transaction was successful
            if ($db->transStatus() === false) {
                throw new Exception('Transaction failed');
            }

            withToast('success', 'Success! New Announcement has been created.');
        } catch (\Throwable $e) {
            // Rollback transaction in case of error
            $db->transRollback();
            log_message('warning', $e->getMessage());

            withToast('error', 'Error! There was a problem creating the announcement.');
        }

        return redirect()->route('announcements');
    }

    public function edit($id)
    {
        $data = $this->announcement->find($id);
        // Render the edit template and store in flash data
        AnnouncementService::parseData($data);

        return view('Pages/Announcement/edit');
    }

    public function update()
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
            $post = $this->request->getPost();
            $this->announcement->update($this->request->getPost('id'), $post);

            // Commit the transaction
            $db->transComplete();

            // Check if the transaction was successful
            if ($db->transStatus() === false) {
                throw new Exception('Transaction failed');
            }

            withToast('success', 'Success! Announcement has been updated.');

            return redirect()->route('announcements');
        } catch (\Throwable $e) {
            // Rollback transaction in case of error
            $db->transRollback();
            log_message('warning', $e->getMessage());

            withToast('error', 'Error! There was a problem updating the announcement.');

            return redirect()->route('announcements-edit', [$this->request->getPost('id')]);
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
            $this->announcement->delete($this->request->getPost('id'));

            // Return the response with updated CSRF token
            return $this->response->setJSON([
                'success' => true,
                'message' => "Announcement Deleted",
                'csrfToken' => csrf_hash(),
            ]);

        } catch (Exception $e) {
            // Log the error
            log_message('error', 'Failed to delete the announcement: ' . $e->getMessage());

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to delete the announcement.',
                'csrfToken' => csrf_hash(),
            ]);
        }
    }

    public function download()
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
        $queryBuilder = $this->announcement->search($filters)->withDeleted(false);

        // Retrieve all results
        $results = $queryBuilder->get()->getResultArray();

        // Prepare headers and data for CSV
        $headers = ['No.', 'Title', 'Content', 'Audience', 'Date'];

        $data = array_map(function ($row) use (&$count) {
            $count++;

            return [
                $count,
                $row['title'],
                clean_content($row['content']),
                implode(', ', json_decode($row['target'])),
                $row['created_at'],
            ];
        }, $results);

        // Use the global CSV download helper
        return downloadCSV('Announcements-' . date('Y-m-d H:i:s') . '.csv', $headers, $data);
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
        $queryBuilder = $this->announcement->search($filters)->withDeleted(false);

        // Retrieve filtered data
        $data = $queryBuilder->get()->getResultArray();

        // Prepare headers for the table
        $headers = ['Title', 'Content', 'Audience', 'Date'];

        // Prepare rows
        $rows = array_map(fn($row) => [
            $row['title'],
            clean_content($row['content']),
            implode(', ', json_decode($row['target'])),
            $row['created_at'],
        ], $data);

        // Get the name of the logged-in user
        $downloadedBy = session()->get('name') ?? 'Anonymous';

        // Render the print template and return as JSON
        $html = view('Templates/print', [
            'title' => 'Announcements',
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
}
