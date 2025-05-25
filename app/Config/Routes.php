<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Inside app/Config/Routes.php
$routes->get('logout', 'AuthController::logout');

// Un Auth User
$routes->group('', ['filter' => 'unauth'], function ($routes) {
    $routes->get('/', 'AuthController::login');
    $routes->get('/login', 'AuthController::login');
    $routes->post('/login', 'AuthController::login');
    $routes->get('forgot-password', 'AuthController::forgot_password', ['as' => 'forgot-password']);
    $routes->post('forgot-password', 'AuthController::forgot_password_store', ['as' => 'forgot-password']);
    $routes->get('new-password', 'AuthController::new_password', ['as' => 'new-password']);
    $routes->post('new-password', 'AuthController::new_password_store', ['as' => 'new-password']);
});

// Auth User
$routes->group('hris', ['filter' => 'auth'], function ($routes) {
    $routes->get('', 'HomeController::index', ['as' => 'dashboard']);

    /**
     * Users Route
     */
    $routes->get('users', 'UserController::index', ['as' => 'users']);
    // Create User index
    $routes->get('create-user', 'UserController::create', ['as' => 'create-user']);
    // Save user
    $routes->post('create-user', 'UserController::store');
    // User CSV download
    $routes->get('users-download', 'UserController::download', ['as' => 'users-download']);
    // User Print
    $routes->post('users/print', 'UserController::print', ['as' => 'users-print']);
    // Edit User
    $routes->get('users/(:any)', 'UserController::edit/$1', ['as' => 'edit-users']);
    // Update User
    $routes->post('update-user', 'UserController::update', ['as' => 'update-user']);
    // Update user status
    $routes->post('user-update-status', 'UserController::update_status', ['as' => 'user-update-status']);

    // Bulk User Registration Routes
    $routes->get('users-bulk-create', 'BulkUserController::create', ['as' => 'users-bulk-create']);
    $routes->post('users-bulk-store', 'BulkUserController::store', ['as' => 'users-bulk-store']);
    $routes->get('users-download-template', 'BulkUserController::download_template', ['as' => 'users-download-template']);


    /**
     * ADMIN
     * Employees Route
     */
    $routes->get('employees', 'EmployeesController::index', ['as' => 'employees']);
    // Employees CSV download
    $routes->get('employees-download', 'EmployeesController::download', ['as' => 'employees-download']);
    // Employees Print
    $routes->post('employees/print', 'EmployeesController::print', ['as' => 'employees-print']);
    // Edit Employee
    $routes->get('employees/(:any)/edit', 'EmployeesController::edit/$1', ['as' => 'employees-edit']);
    // Update Employee
    $routes->post('employees-update', 'EmployeesController::update', ['as' => 'employees-update']);
    // Update Employee lock state
    $routes->post('employees-lock-info', 'EmployeesController::update_lock_state', ['as' => 'employees-lock-info']);
    // Employee show
    $routes->get('employees/(:any)/show', 'EmployeesController::print_form/$1', ['as' => 'employees-show']);

    /**
     * Files Route
     */
    // Admin - user files
    $routes->get('files/(:any)', 'EmployeesFileController::index/$1', ['as' => 'files']);
    // Employee - my files
    $routes->get('files', 'EmployeesFileController::index', ['as' => 'my-files']);
    // File list CSV download
    $routes->get('files-download', 'EmployeesFileController::download', ['as' => 'files-download']);
    // Files Print
    $routes->post('files/print', 'EmployeesFileController::print', ['as' => 'files-print']);
    // Files Save index
    $routes->get('files-upload', 'EmployeesFileController::create', ['as' => 'files-upload']);
    // Save new file
    $routes->post('files-save', 'EmployeesFileController::store', ['as' => 'files-save']);
    // Files edit index
    $routes->get('files-edit/(:any)', 'EmployeesFileController::edit/$1', ['as' => 'files-edit']);
    // Save new file
    $routes->post('files-update', 'EmployeesFileController::update', ['as' => 'files-update']);
    // Save new file
    $routes->post('files-delete', 'EmployeesFileController::delete', ['as' => 'files-delete']);
    // Save new file
    $routes->get('files-file-download/(:any)', 'EmployeesFileController::fileDownload/$1', ['as' => 'files-file-download']);
    // Show file
    $routes->get('files-show/(:any)', 'EmployeesFileController::show/$1', ['as' => 'files-show']);

    /**
     * EMPLOYEE
     * Employee informations route
     */
    // Employee informations index
    $routes->get('my-informations', 'EmployeesInfoController::index', ['as' => 'my-informations']);
    // Employee informations save
    $routes->post('my-informations-update', 'EmployeesInfoController::update', ['as' => 'my-informations-update']);

    /**
     * My Account Route
     */
    $routes->get('my-account', 'AccountController::index', ['as' => 'my-account']);
    $routes->post('my-account-save', 'AccountController::update', ['as' => 'my-account-save']);

    /**
     * Attendance Route
     */
    $routes->get('attendance', 'AttendanceController::index', ['as' => 'attendance']);
    // Attendance import page
    $routes->get('attendance-create', 'AttendanceController::create', ['as' => 'attendance-create']);
    // Attendance import
    $routes->post('attendance-store', 'AttendanceController::store', ['as' => 'attendance-store']);
    // Attendance CSV download
    $routes->get('attendance-download', 'AttendanceController::download', ['as' => 'attendance-download']);
    // Attendance Print
    $routes->post('attendance-print', 'AttendanceController::print', ['as' => 'attendance-print']);
    // Donwload template
    $routes->get('attendance-download-template', 'AttendanceController::download_template', ['as' => 'attendance-download-template']);

    /**
     * Announcement Route
     */
    $routes->get('announcements', 'AnnouncementController::index', ['as' => 'announcements']);
    // Announcement create page
    $routes->get('announcements-create', 'AnnouncementController::create', ['as' => 'announcements-create']);
    // Announcement save
    $routes->post('announcements-create', 'AnnouncementController::store', ['as' => 'announcements-create']);
    // Announcement edit page
    $routes->get('announcements/(:any)', 'AnnouncementController::edit/$1', ['as' => 'announcements-edit']);
    // Announcement update
    $routes->post('announcements-update', 'AnnouncementController::update', ['as' => 'announcements-update']);
    // Announcement delete
    $routes->post('announcements-delete', 'AnnouncementController::delete', ['as' => 'announcements-delete']);
    // Announcement CSV download
    $routes->get('announcements-download', 'AnnouncementController::download', ['as' => 'announcements-download']);
    // Announcement Print
    $routes->post('announcements-print', 'AnnouncementController::print', ['as' => 'announcements-print']);

    /**
     * Employee Leave Route
     */
    $routes->get('leaves', 'LeaveController::index', ['as' => 'leaves']);
    // CSV download
    $routes->get('leaves-download', 'LeaveController::download', ['as' => 'leaves-download']);
    // Print
    $routes->post('leaves-print', 'LeaveController::print', ['as' => 'leaves-print']);
    // Delete leaves
    $routes->post('leaves-delete', 'LeaveController::delete', ['as' => 'leaves-delete']);
    // Print leave details
    $routes->post('leaves-print-show', 'LeaveController::print_leave', ['as' => 'leaves-print-show']);
    // Approve leave
    $routes->get('leaves-approve/(:any)', 'LeaveController::approve_leave/$1', ['as' => 'leaves-approve']);
    // Reject leave
    $routes->get('leaves-reject/(:any)', 'LeaveController::reject_leave/$1', ['as' => 'leaves-reject']);

    // Leaves Create group
    $routes->group('leaves/create', function ($routes) {
        // Index page
        $routes->get('', 'LeaveController::create', ['as' => 'leaves-create']);
        // Vacation leave
        $routes->get('vacation-leave', 'LeaveController::create_vacation', ['as' => 'leaves-create-vacation-leave']);
        // Vacation leave save
        $routes->post('vacation-leave', 'LeaveController::store_vacation', ['as' => 'leaves-create-vacation-leave']);


        // Official business
        $routes->get('official-business', 'LeaveController::create_official_business', ['as' => 'leaves-create-official-business']);
        // Official business save
        $routes->post('official-business', 'LeaveController::store_official_business', ['as' => 'leaves-create-official-business']);

        // Personal business
        $routes->get('personal-business', 'LeaveController::create_personal_business', ['as' => 'leaves-create-personal-business']);
        // Personal business save
        $routes->post('personal-business', 'LeaveController::store_personal_business', ['as' => 'leaves-create-personal-business']);
    });

    $routes->group('leaves/edit', function ($routes) {
        // Vacation leave edit
        $routes->get('vacation-leave/(:any)', 'LeaveController::edit_vacation/$1', ['as' => 'leaves-vacation-leave-edit']);
        // Vacation leave update
        $routes->post('vacation-leave', 'LeaveController::update_vacation', ['as' => 'leaves-vacation-leave-update']);

        // Official business edit
        $routes->get('official-business/(:any)', 'LeaveController::edit_official_business/$1', ['as' => 'leaves-official-business-edit']);
        // Official business update
        $routes->post('official-business', 'LeaveController::update_official_business', ['as' => 'leaves-official-business-update']);

        // Personal business edit
        $routes->get('personal-business/(:any)', 'LeaveController::edit_personal_business/$1', ['as' => 'leaves-personal-business-edit']);
        // Personal business update
        $routes->post('personal-business', 'LeaveController::update_personal_business', ['as' => 'leaves-personal-business-update']);
    });

    // Show leave details
    $routes->get('leaves/(:any)', 'LeaveController::show/$1', ['as' => 'leaves-show']);

    // Notification Route
    $routes->post('get-notification', 'NotificationController::index', ['as' => 'get-notification']);
    // Show notification details
    $routes->get('notification/(:any)', 'NotificationController::show/$1', ['as' => 'notification-show']);

    // Memo routes
    $routes->group('memo', ['namespace' => 'App\Controllers'], function ($routes) {
        $routes->get('/', 'MemoController::index', ['as' => 'memos']);
        $routes->get('create', 'MemoController::create', ['as' => 'memos-create']);
        $routes->post('store', 'MemoController::store', ['as' => 'memos-store']);
        $routes->get('edit/(:num)', 'MemoController::edit/$1', ['as' => 'memos-edit']);
        $routes->post('edit/(:num)', 'MemoController::update/$1', ['as' => 'memos-update']);
        $routes->post('delete', 'MemoController::delete', ['as' => 'memos-delete']);
        $routes->get('download/(:num)', 'MemoController::download/$1', ['as' => 'memos-download']);
        $routes->get('preview/(:num)', 'MemoController::preview/$1', ['as' => 'memos-preview']);
        $routes->get('search-users', 'MemoController::searchUsers', ['as' => 'memos-search-users']);
    });

    // Department Heads routes
    $routes->group('department-heads', ['namespace' => 'App\Controllers'], function ($routes) {
        $routes->get('/', 'DepartmentHeadController::index', ['as' => 'department-heads']);
        $routes->post('assign', 'DepartmentHeadController::assign', ['as' => 'department-heads-assign']);
        $routes->post('remove', 'DepartmentHeadController::remove', ['as' => 'department-heads-remove']);
        $routes->get('search-employees', 'DepartmentHeadController::searchEmployees', ['as' => 'department-heads-search']);
    });

    // Reports routes
    $routes->group('reports', ['namespace' => 'App\Controllers'], function ($routes) {
        $routes->get('turnover-rate', 'ReportController::turnoverRate', ['as' => 'reports-turnover-rate']);
        $routes->get('tardiness-rate', 'ReportController::tardinessRate', ['as' => 'reports-tardiness-rate']);
    });
});
