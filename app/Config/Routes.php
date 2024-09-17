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
$routes->post('administrador/editar_usuario/(:num)', 'AdministradorController::admin_editar_usuario/$1');
$routes->post('administrador/eliminar_usuario/(:num)', 'AdministradorController::admin_eliminar_usuario/$1');
$routes->post('administrador/agregar_usuario', 'AdministradorController::admin_agregar_usuario');

$routes->post('administrador/editar_comunidad/(:num)', 'AdministradorController::admin_editar_comunidad/$1');
$routes->post('administrador/eliminar_comunidad/(:num)', 'AdministradorController::admin_eliminar_comunidad/$1');
$routes->post('administrador/agregar_comunidad', 'AdministradorController::admin_agregar_comunidad');

$routes->post('administrador/editar_rol/(:num)', 'AdministradorController::admin_editar_rol/$1');
$routes->post('administrador/eliminar_rol/(:num)', 'AdministradorController::admin_eliminar_rol/$1');
$routes->post('administrador/agregar_rol', 'AdministradorController::admin_agregar_rol');

$routes->post('administrador/editar_contenido_pagina/(:num)', 'AdministradorController::admin_editar_contenido_pagina/$1');
$routes->post('administrador/eliminar_contenido_pagina/(:num)', 'AdministradorController::admin_eliminar_contenido_pagina/$1');
$routes->post('administrador/agregar_contenido_pagina', 'AdministradorController::admin_agregar_contenido_pagina');



$routes->get('dashboard/administrador/admin_comunidades', 'AdministradorController::admin_comunidad');
$routes->get('dashboard/administrador/admin_rol', 'AdministradorController::admin_rol');
$routes->get('dashboard/administrador/admin_contenidopagina', 'AdministradorController::admin_contenidopagina');
$routes->get('dashboard/administrador/admin_envio', 'AdministradorController::admin_envio');
$routes->get('dashboard/administrador/admin_pago', 'AdministradorController::admin_pago');
$routes->get('dashboard/administrador/admin_producto', 'AdministradorController::admin_producto');
$routes->get('dashboard/administrador/admin_compra', 'AdministradorController::admin_compra');