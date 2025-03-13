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
    $routes->get('employees/(:any)', 'EmployeesController::edit/$1', ['as' => 'employees-edit']);
    // Update Employee
    $routes->post('employees-update', 'EmployeesController::update', ['as' => 'employees-update']);
    // Update Employee lock state
    $routes->post('employees-lock-info', 'EmployeesController::update_lock_state', ['as' => 'employees-lock-info']);

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
});
