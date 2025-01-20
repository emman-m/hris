<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\User;
use App\Models\UserInfo;
use App\Validations\Users\CreateAdminValidation;
use Config\Database;
use Config\Services;
use Exception;


class UserController extends BaseController
{
    protected $user;
    protected $usersInfo;
    protected $pager;

    public function __construct()
    {
        $this->user = new User();
        $this->usersInfo = new UserInfo();

        $this->pager = Services::pager();
    }

    public function index()
    {
        // Retrieve filters from the request
        $filters = [
            'role' => $this->request->getGet('role'),
            'status' => $this->request->getGet('status'),
            'search' => $this->request->getGet('search'),
        ];

        // Get the query builder from the model
        $queryBuilder = $this->user->getFilteredQuery($filters);

        // Apply pagination
        $data = $queryBuilder->paginate();
        $pager = $queryBuilder->pager;

        // Pagination meta
        $paginationInfo = [
            'totalItems' => $pager->getTotal(),
            'start' => ($pager->getCurrentPage() - 1) * $pager->getPerPage() + 1,
            'end' => min($pager->getCurrentPage() * $pager->getPerPage(), $pager->getTotal()),
        ];

        return view('Pages/Users/index', [
            'data' => $data,
            'pager' => $pager,
            'paginationInfo' => $paginationInfo,
        ]);
    }

    public function download()
    {
        // Retrieve filters from the request
        $filters = [
            'role' => $this->request->getGet('role'),
            'status' => $this->request->getGet('status'),
            'search' => $this->request->getGet('search'),
        ];

        // Get the query builder from the model
        $queryBuilder = $this->user->getFilteredQuery($filters);

        // Retrieve all results
        $results = $queryBuilder->get()->getResultArray();

        // Prepare headers and data for CSV
        $headers = ['No.', 'Name', 'Email', 'Role', 'Status'];
        // Count number
        $count = 0;
        $data = array_map(function ($row) use (&$count) {
            $count++;

            return [
                $count,
                $row['name'],
                $row['email'],
                $row['role'],
                $row['status'],
            ];
        }, $results);

        // Use the global CSV download helper
        return downloadCSV('User-' . date('Y-m-d H:i:s') . '.csv', $headers, $data);
    }

    public function print()
    {
        // Retrieve filters from the request
        $filters = $this->request->getPost();
        // Get the query builder from the model
        $queryBuilder = $this->user->getFilteredQuery($filters);

        // Retrieve filtered data
        $data = $queryBuilder->get()->getResultArray();

        // Get the current date
        $currentDate = date('Y-m-d H:i:s');

        // Prepare the printable layout
        $html = '<html><head><title>Users</title>';
        $html .= '<style>
                table {
                    width: 100%;
                    border-collapse: collapse;
                }
                table, th, td {
                    border: 1px solid black;
                }
                th, td {
                    padding: 10px;
                    text-align: left;
                }
              </style>';
        $html .= '</head><body>';
        $html .= '<h1>Users</h1>';
        $html .= '<p><strong>Print Date:</strong> ' . $currentDate . '</p>';
        $html .= '<table>';
        $html .= '<thead>
                <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                </tr>
              </thead>';
        $html .= '<tbody>';

        // Add rows
        foreach ($data as $index => $item) {
            $html .= '<tr>
                    <td>' . ($index + 1) . '</td>
                    <td>' . $item['name'] . '</td>
                    <td>' . $item['email'] . '</td>
                    <td>' . $item['role'] . '</td>
                  </tr>';
        }

        if (empty($data)) {
            $html .= '<tr><td colspan="4" style="text-align:center">No data available</td></tr>';
        }

        $html .= '</tbody></table>';
        $html .= '</body></html>';

        // Return the printable content and updated CSRF token
        return $this->response->setJSON([
            'html' => $html,
            'csrfToken' => csrf_hash(),
        ]);
    }

    public function create($role)
    {
        // Validate the role (optional)
        if (!in_array($role, array_column(UserRole::cases(), 'name'))) {
            return redirect()->back()->with('error', 'Invalid role selected.');
        }

        return view('Pages/Users/Create/' . strtolower($role));
    }

    public function store()
    {
        // Get the request object
        $request = Services::request();

        $allowedRoles = [
            UserRole::ADMIN->value,
            UserRole::HR_ADMIN->value,
            UserRole::HR_STAFF->value,
        ];

        // Insert admin user
        if (in_array($request->getPost('role'), $allowedRoles)) {
            return $this->createAdminUser($request);
        }

        // insert for Employees

    }

    // Save new Admin user
    private function createAdminUser($request)
    {
        $post = $request->getPost();

        // Set strict validation rules
        $validation = Services::validation();
        // Rules
        $createAdminValidation = new CreateAdminValidation();
        $validation->setRules($createAdminValidation->rules);

        // Validate the form data
        if (!$validation->withRequest($request)->run()) {
            // Validation failed, set the errors in the session
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Start a database transaction
        $db = Database::connect();
        $db->transStart();

        try {
            // Insert to users
            $userData = [
                'role' => $post['role'],
                'email' => $post['email'],
                'password' => password_hash($post['password'], PASSWORD_BCRYPT),
                'status' => UserStatus::ACTIVE->value
            ];
            $userId = $this->user->insert($userData);

            // Insert to users_info
            $usersInfoData = [
                'user_id' => $userId,
                'first_name' => $post['first_name'],
                'middle_name' => $post['middle_name'],
                'last_name' => $post['last_name']
            ];
            $this->usersInfo->insert($usersInfoData);

            // If both operations are successful, commit the transaction
            $db->transComplete();

            withToast('success', 'Success! New user has been added.');
        } catch (Exception $e) {
            // If any operation fails, rollback the transaction
            $db->transRollback();

            withToast('error', 'Error! There was a problem saving user.');
        }

        return redirect()->route('users');
    }
}