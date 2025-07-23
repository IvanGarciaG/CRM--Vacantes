<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

/**
 * ------------Auth Routes------------
 */
$routes->get('/', 'AuthController::login');
$routes->post('/login', 'AuthController::doLogin');
$routes->get('/register', 'AuthController::register');
$routes->post('/register', 'AuthController::doRegister');
$routes->get('/logout', 'AuthController::logout');


/**
 * ------------Dashboard Routes------------
 */
$routes->get('/dashboard', 'DashboardController::index');
/**
 * ------------User Management Routes------------
 */
$routes->group('users', function ($routes) {
    $routes->get('/', 'UserController::index');                        
    $routes->get('show/(:num)', 'UserController::show/$1');          
    $routes->get('edit/(:num)', 'UserController::edit/$1');           
    $routes->post('update/(:num)', 'UserController::update/$1');      
    $routes->post('role/(:num)', 'UserController::updateRole/$1');   
    $routes->post('status/(:num)', 'UserController::updateStatus/$1'); 
    $routes->get('delete/(:num)', 'UserController::destroy/$1');
    $routes->get('create', 'UserController::create');
    $routes->post('store', 'UserController::store');
});


/**
 * ------------Report Routes------------
 */
$routes->get('/report/users', 'ReportController::usuarios');
$routes->get('/report/users/export', 'ReportController::exportUsuarios');

/**
 * ------------Settings Routes------------
 */
$routes->get('/settings', 'SettingsController::settings');
$routes->post('/settings/update', 'SettingsController::updateSettings');
