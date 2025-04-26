<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/login', 'Auth\LoginController::index');
$routes->get('/register', 'Auth\RegisterController::index');
$routes->post('/register/store', 'Auth\RegisterController::store');
