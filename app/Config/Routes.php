<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// DATA USER
// $routes->resource('user', ['controller' => 'RegisterController']);
// app/Config/Routes.php
$routes->group('user', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('(:segment)', 'RegisterController::index/$1');
    $routes->get('', 'RegisterController::index');
});
$routes->match(['get', 'options'], 'datauser', 'RegisterController::insert');
$routes->match(['post', 'options'], 'create/user', 'RegisterController::create');
$routes->match(['put', 'options'], 'update/user/(:segment)', 'RegisterController::update/$1');
$routes->match(['delete', 'options'], 'delete/user/(:segment)', 'RegisterController::delete/$1');



//LOGIN
$routes->match(['post', 'options'], 'user/login', 'LoginController::user');
$routes->match(['post', 'options'], 'admin/login', 'LoginController::admin');



// // DATA PRODUCT
// $routes->resource('product', ['controller' => 'ProductController']);
// $routes->match(['post', 'options'], 'create/product', 'ProductController::create');
$routes->group('product', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('/', 'ProductController::index');
    $routes->get('byId/(:num)', 'ProductController::byId/$1');
});
$routes->match(['post', 'options'], 'create/product', 'ProductController::create');


// TESTIMONI
$routes->resource('testimoni', ['controller' => 'TestimoniController']);
$routes->match(['post', 'options'], 'create/testimoni', 'TestimoniController::create');


//REVIEWS
$routes->resource('reviews', ['controller' => 'ReviewController']);
$routes->match(['post', 'options'], 'create/reviews', 'ReviewController::create');


//SEWA
$routes->resource('sewa', ['controller' => 'SewaController']);
$routes->match(['post', 'options'], 'create/sewa', 'SewaController::create');