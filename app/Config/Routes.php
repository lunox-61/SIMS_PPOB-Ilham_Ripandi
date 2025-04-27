<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->group('', ['filter' => 'auth'], function($routes) {
	/**
	 * Wilayah Home
	 */
    $routes->get('/', 'HomeController::index');

    /**
	 * Wilayah Profile
	 */
    $routes->get('/profile', 'ProfileController::index');
	$routes->post('/profile/update', 'ProfileController::update');
	$routes->post('/profile/image', 'ProfileController::image');
	$routes->get('/logout', 'Auth\LoginController::logout');

	/**
	 * Wilayah Top Up
	 */
	$routes->get('/topup', 'TopupController::index', ['filter' => 'auth']);
	$routes->post('/topup', 'TopupController::topup', ['filter' => 'auth']);

	/**
	 * Wilayah Transaksi
	 */
	$routes->get('/transaction/history', 'TransactionController::history');
	$routes->get('transaction/(:segment)', 'TransactionController::index/$1');
	$routes->post('transaction/(:segment)/pay', 'TransactionController::pay/$1');
});

/**
 * Wilayah API Documentation
 */
$routes->get('docs', function() {
    return redirect()->to(base_url('swagger-ui/index.html'));
});

// 1. Module Membership
$routes->post('registration', 'Auth\RegisterController::apiRegister');
$routes->post('api/login', 'Auth\LoginController::apiLogin');

$routes->group('api', ['filter' => 'authjwt'], function($routes) {
    $routes->get('profile', 'ProfileController::apiProfile');
    $routes->put('profile/update', 'ProfileController::apiUpdate');
    $routes->post('profile/image', 'ProfileController::apiUploadImage');

    // 2. Module Information (khusus ServicesController)
    $routes->get('services', 'ServiceController::index');

    // 3. Module Transaction
    $routes->get('balance', 'BalanceController::apiBalance');
    $routes->post('topup', 'TopupController::apiTopup');
    $routes->post('transaction', 'TransactionController::apiTransaction');
    $routes->get('transaction/history', 'TransactionController::apiTransactionHistory');  
});

// 2. Module Information
$routes->get('api/banner', 'BannerController::index');

/**
 * Wilayah Auth
 */

$routes->get('/login', 'Auth\LoginController::index');
$routes->post('/login', 'Auth\LoginController::login');

$routes->get('/register', 'Auth\RegisterController::index');
$routes->post('/register/store', 'Auth\RegisterController::store');
