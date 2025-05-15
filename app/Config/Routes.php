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
        // Json API Endpoint
        $routes->post('getProducts', 'ProductController::getProducts');
        $routes->get('generateCode', 'ProductController::generateCode');

        // Web Endpoint
        $routes->get('/', 'ProductController::index');
        $routes->post('store', 'ProductController::store');
        $routes->put('update/(:num)', 'ProductController::update/$1');
        $routes->delete('destroy/(:num)', 'ProductController::destroy/$1');
    });

    $routes->group('staff', function ($routes) {
        // Json API Endpoint
        $routes->post('getStaffList', 'StaffController::getStaffList');

        // Web Endpoint
        $routes->get('/', 'StaffController::index');
        $routes->post('store', 'StaffController::store');
        $routes->put('update/(:num)', 'StaffController::update/$1');
        $routes->delete('destroy/(:num)', 'StaffController::destroy/$1');
    });
});
