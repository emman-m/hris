<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Inside app/Config/Routes.php
$routes->get('/logout', 'AuthController::logout');

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

    $routes->group('files', function ($routes) {
        $routes->get('(:any)', 'EmployeesFileController::index', ['as' => 'files']);
    });
});
