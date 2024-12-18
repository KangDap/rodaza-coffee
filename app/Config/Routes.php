<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

 // Routes saat awal membuka website
$routes->get('/', 'Home::index');

// Routes untuk otentikasi (method POST berada di library Myth:Auth)
$routes->get('/login', 'AuthController::login');
$routes->get('/register', 'AuthController::reg');
$routes->get('/forgot', 'AuthController::forgotPassword');
$routes->get('/reset-password', 'AuthController::resetPassword');

// Routes setelah user berhasil login
$routes->get('/home', 'AuthController::loginSuccess', ['filter' => 'role:user, admin']);
$routes->get('/profile', 'UserController::profile', ['filter' => 'role:user, admin']);
$routes->get('/edit-profile', 'UserController::editProfile', ['filter' => 'role:user, admin']);
$routes->post('/edit-profile', 'UserController::sendNewProfile', ['filter' => 'role:user, admin']);
$routes->post('/payment', 'PaymentController::index', ['filter' => 'role:user, admin']);
$routes->post('/sendfeedback', 'UserController::sendFeedback', ['filter' => 'role:user']);

// Routes untuk role Admin
$routes->get('/admin', 'Admin::index', ['filter' => 'role:admin']);
$routes->get('/admin/process-order/(:any)', 'Admin::processOrder', ['filter' => 'role:admin']);
$routes->get('/admin/complete-order/(:any)', 'Admin::completeOrder', ['filter' => 'role:admin']);

// Routes untuk API
$routes->group('api', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('orders', 'APIController::allOrders', ['filter' => 'role:admin']);
    $routes->get('products', 'APIController::allProducts');
    $routes->get('categories', 'APIController::index');
    $routes->get('categories/(:num)', 'APIController::productsByCategory/$1');
    $routes->get('feedbacks', 'APIController::allFeedbacks', ['filter' => 'role:admin']);
    $routes->get('order-history', 'APIController::orderHistory');
    $routes->get('order-history/(:num)', 'APIController::orderHistory/$1');
});

// Routes untuk Payment
$routes->post('/payment', 'PaymentController::index', ['filter' => 'role:user']);
$routes->post('/payment/success', 'PaymentController::insertOrderData', ['filter' => 'role:user']);