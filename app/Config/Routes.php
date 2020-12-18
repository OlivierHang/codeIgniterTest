<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->get('/', 'Home::index');

// Au lieu de "localhost:8080/my-app/codeIgniterTest/Shop/product/param1/param2"
// -> on raccourci l'url = "localhost:8080/my-app/codeIgniterTest/product/param1/param2"
$routes->add('product/(:any)/(:any)', 'Shop::product/$1/$2');
// localhost:8080/my-app/codeIgniterTest/blog
$routes->add('blog', function () {
	return '<h2>This is a blog</h2>';
});

// localhost:8080/my-app/codeIgniterTest/admin/$laMethodeDansDossierAdmin
$routes->group('admin', function ($routes) {
	// localhost:8080/my-app/codeIgniterTest/admin/user
	// -> appel la methode 'index()' de 'Admin/Users'
	$routes->add('user', 'Admin\Users::index');
	// localhost:8080/my-app/codeIgniterTest/admin/users
	// -> appel la methode 'getAllUsers()' de 'Admin/Users'
	$routes->add('users', 'Admin\Users::getAllUsers');
	// localhost:8080/my-app/codeIgniterTest/admin/product/param1/param2
	// -> appel la methode 'product($param, $param)' de 'Admin/Users'
	$routes->add('product/(:any)/(:any)', 'Admin\Shop::product/$1/$2');
});

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
