<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Inside app/Config/Routes.php
$routes->get('/logout', 'AuthController::logout');

// Un Auth User
$routes->group('', ['filter' => 'unauth'], function($routes) {
    $routes->get('/', 'AuthController::login');
    $routes->get('/login', 'AuthController::login');
    $routes->post('/login', 'AuthController::login');
});

// Auth User
$routes->group('hris', ['filter' => 'auth'], function($routes) {
    $routes->get('', 'HomeController::index', ['as' => 'dashboard']);
    $routes->get('users', 'UserController::index', ['as' => 'users']);
    $routes->get('users-download', 'UserController::download', ['as' => 'users-download']);
    $routes->post('users/print', 'UserController::print', ['as' => 'users-print']);

    // redirect()->to(route_to('create-user', 'admin'));
    $routes->get('create-user/(:any)', 'UserController::create/$1', ['as' => 'create-user']);

    $routes->post('create-user', 'UserController::store');
});
