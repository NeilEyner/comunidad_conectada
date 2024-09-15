<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('register', 'AuthController::register');
$routes->post('register', 'AuthController::do_register');
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::do_login');
$routes->get('logout', 'AuthController::logout');

$routes->get('dashboard/artesano', 'DashboardController::artesano');
$routes->get('dashboard/cliente', 'DashboardController::cliente');
$routes->get('dashboard/delivery', 'DashboardController::delivery');
$routes->get('dashboard/admin', 'DashboardController::admin');
$routes->get('dashboard/admin_usuarios', 'DashboardController::admin_user');
$routes->get('dashboard/admin_comunidades', 'DashboardController::admin_comunidad');

$routes->get('/nosotros', 'Home::nosotros');
$routes->get('/tienda', 'Home::tienda');
$routes->get('/contacto', 'Home::contacto');
$routes->get('/comunidades', 'Home::comunidades');

<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Inicio::index');

//login and register
$routes->get('register', 'AuthController::register');
$routes->post('register', 'AuthController::do_register');
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::do_login');
$routes->get('logout', 'AuthController::logout');


$routes->get('dashboard/artesano', 'AdministradorController::artesano');
$routes->get('dashboard/cliente', 'AdministradorController::cliente');
$routes->get('dashboard/delivery', 'AdministradorController::delivery');

//rutas administrador
$routes->get('dashboard/administrador/admin_dashboard', 'AdministradorController::admin');
$routes->get('dashboard/administrador/admin_usuarios', 'AdministradorController::admin_user');
$routes->get('dashboard/administrador/admin_comunidades', 'AdministradorController::admin_comunidad');
$routes->get('dashboard/administrador/admin_rol', 'AdministradorController::admin_rol');
$routes->get('dashboard/administrador/admin_contenidopagina', 'AdministradorController::admin_contenidopagina');
$routes->get('dashboard/administrador/admin_envio', 'AdministradorController::admin_envio');
$routes->get('dashboard/administrador/admin_pago', 'AdministradorController::admin_pago');
$routes->get('dashboard/administrador/admin_producto', 'AdministradorController::admin_producto');
$routes->get('dashboard/administrador/admin_compra', 'AdministradorController::admin_compra');