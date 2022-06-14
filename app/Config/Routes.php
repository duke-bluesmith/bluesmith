<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Pages::show/home');
$routes->get('about/(:segment)', 'Pages::show/$1');

// Forward legacy routes
$routes->get('jobs', 'account/jobs');
$routes->get('jobs/index', 'account/jobs');
$routes->get('jobs/add', 'jobs/new');

// Admin dashboard
$routes->get('manage', '\App\Controllers\Manage\Dashboard::index');

$routes->group('manage', ['namespace' => 'App\Controllers\Manage'], static function ($routes) {
    $routes->get('materials/method/(:any)', 'Materials::method/$1');
    $routes->presenter('materials');
});

$routes->addRedirect('methods', 'manage/methods');

// API
$routes->resource('api/materials', ['websafe' => 1, 'controller' => '\App\Controllers\Api\Materials']);
$routes->resource('api/methods', ['websafe' => 1, 'controller' => '\App\Controllers\Api\Methods']);
$routes->resource('api/manage/materials', ['websafe' => 1, 'controller' => '\App\Controllers\Api\Materials']);
$routes->resource('api/manage/methods', ['websafe' => 1, 'controller' => '\App\Controllers\Api\Methods']);

/**
 * Unsubscription
 *
 * @todo Needs to be implemented
 */
$routes->get('unsubscribe', 'Api\Email::unsubscribe', ['as' => 'unsubscribe']);

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    /**
     * @psalm-suppress MissingFile
     */
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
