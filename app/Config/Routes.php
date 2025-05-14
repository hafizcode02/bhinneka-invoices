<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');

$routes->get('/login', 'LoginController::index');
$routes->post('/login', 'LoginController::auth');

$routes->group('', ['filter' => 'role:admin,superadmin'], function ($routes) {
    $routes->post('/logout', 'LoginController::logout');

    $routes->get('/dashboard', 'DashboardController::index');

    $routes->group('product', function ($routes) {
        $routes->get('/', 'ProductController::index');
    });
});
