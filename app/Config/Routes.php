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

    // Testing page for view user
    $routes->get('users/(:any)', 'UserController::show/$1', ['as' => 'users-show']);


    /**
     * Employees Route
     */
    $routes->get('employees', 'EmployeesController::index', ['as' => 'employees']);
    // Employees CSV download
    $routes->get('employees-download', 'EmployeesController::download', ['as' => 'employees-download']);
    // Employees Print
    $routes->post('employees/print', 'EmployeesController::print', ['as' => 'employees-print']);
});
