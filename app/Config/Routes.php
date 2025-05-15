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

    $routes->group('invoice', function ($routes) {
        // Json API Endpoint
        $routes->post('getInvoices', 'InvoiceController::getInvoices');
        $routes->get('generateNumber', 'InvoiceController::generateNumber');
        $routes->get('getAllStaffs', 'InvoiceController::getAllStaffs');
        $routes->get('getAllProducts', 'InvoiceController::getAllProducts');

        // Web Endpoint
        $routes->get('/', 'InvoiceController::index');
        $routes->get('create', 'InvoiceController::create');
        $routes->post('store', 'InvoiceController::store');
        $routes->get('edit/(:num)', 'InvoiceController::edit/$1');
        $routes->put('update/(:num)', 'InvoiceController::update/$1');
        $routes->get('detail/(:num)', 'InvoiceController::detail/$1');
        $routes->get('print/(:num)', 'InvoiceController::print/$1');
        $routes->delete('destroy/(:num)', 'InvoiceController::destroy/$1');
    });

    $routes->group('profile', function ($routes) {
        $routes->get('/', 'UserController::getProfile');
        $routes->put('update', 'UserController::updateProfile');
    });
});
