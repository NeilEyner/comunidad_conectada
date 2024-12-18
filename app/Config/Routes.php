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
$routes->get('perfil/(:num)', 'AuthController::perfil/$1');
$routes->post('update_perfil/(:num)', 'AuthController::do_update/$1');
$routes->get('api/comunidades', 'AuthController::getComunidades');


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
$routes->get('/carrito', 'Home::carrito');
$routes->get('/producto/(:num)/(:num)', 'Home::producto/$1/$2');
$routes->Post('/anadirprod/(:num)/(:num)/(:num)/(:num)', 'Home::anadirProd/$1/$2/$3/$4');
$routes->Post('/carritoedit/(:num)/(:num)/(:num)/(:num)/(:any)', 'CarritoController::editarCarrito/$1/$2/$3/$4/$5');
$routes->Post('/carreliminarprod', 'CarritoController::eliminarProd');
$routes->Post('/calificar/(:num)/(:num)/(:num)', 'Home::calificar/$1/$2/$3');

//rutas artesano
$routes->get('dashboard/artesano/arte_dashboard', 'ArtesanoController::artesano');
$routes->get('dashboard/artesano/arte_producto', 'ArtesanoController::artesano_producto');
$routes->post('artesano/editar_productos/(:num)/(:any)', 'ArtesanoController::artesano_editar_producto/$1/$2');
$routes->post('artesano/agregar_producto', 'ArtesanoController::artesano_agregar_producto');
$routes->post('artesano/eliminar_producto/(:num)/(:any)', 'ArtesanoController::artesano_eliminar_producto/$1/$2');

$routes->get('dashboard/artesano/pedido_producto', 'ArtesanoController::pedido_producto');
$routes->get('dashboard/artesano/valoracion_producto', 'ArtesanoController::valoracion_producto');

//rutas cliente
$routes->get('dashboard/cliente/cli_dashboard', 'ClienteController::cliente');
$routes->get('dashboard/cliente/compra', 'ClienteController::compra');
$routes->get('dashboard/cliente/recibido', 'ClienteController::recibido');

//rutas delivery
$routes->get('dashboard/delivery/deli_dashboard', 'DeliveryController::delivery');
$routes->get('dashboard/delivery/envio', 'DeliveryController::envio');
$routes->get('dashboard/delivery/entregado', 'DeliveryController::entregado');


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
//PRODCUTOS
$routes->get('dashboard/administrador/admin_producto', 'AdministradorController::admin_producto');
$routes->post('admin/agregar_producto', 'AdministradorController::admin_agregar_producto');
$routes->post( 'admin/editar_producto/(:num)', 'AdministradorController::admin_editar_producto/$1');
$routes->post('admin/eliminar_producto/(:num)', 'AdministradorController::admin_eliminar_producto/$1');

//PAGOS

$routes->get('pagos/metodo_pago/(:num)', 'PagoController::mostrar_metodos_pago/$1');
$routes->post('pago/procesar/(:num)', 'PagoController::procesar_pago/$1');

$routes->get('verifica_comprobante_completado/(:num)', 'AdministradorController::pago_completado/$1');
$routes->get('verifica_comprobante_fallido/(:num)', 'AdministradorController::pago_fallido/$1');
//

$routes->post('envios/asignar', 'DeliveryController::procesar_asignacion');
$routes->post('envios/entregado', 'DeliveryController::procesar_entrega'); 

$routes->post('compra/entregado', 'ClienteController::procesar_entregado');
$routes->post('compra/cancelado', 'ClienteController::procesar_cancelado');

$routes->post('', 'AdministradorController::admin_compra');
//transporte
$routes->get('dashboard/administrador/admin_transporte', 'AdministradorController::transporte');
$routes->get('administrador/transporte/agregar', 'AdministradorController::agregar_transporte');
$routes->post('administrador/transporte/agregar', 'AdministradorController::agregar_transporte');
$routes->get('administrador/transporte/editar/(:num)', 'AdministradorController::editar_transporte/$1');
$routes->post('administrador/transporte/editar/(:num)', 'AdministradorController::editar_transporte/$1');
$routes->get('administrador/transporte/eliminar/(:num)', 'AdministradorController::eliminar_transporte/$1');
//comuini
$routes->get('pdf/exportarCompraPDF/(:num)', 'PdfController::exportarCompraPDF/$1');


// API ANDROID


// Ruta para login
$routes->post('api/login', 'AuthController::api_login'); // Login de usuario


$routes->get('api/usuarios', 'ApiController::listarUsuarios'); // Listar todos los usuarios

$routes->get('api/usuario/(:num)', 'ApiController::obtenerUsuario/$1'); // Obtener detalles de un usuario
$routes->get('api/productos/artesano/(:num)', 'ApiController::listarProductosPorArtesano/$1'); // Listar productos por artesano
$routes->get('api/compras/cliente/(:num)', 'ApiController::listarComprasPorCliente/$1'); // Listar compras de un cliente
$routes->get('api/compra/detalle/(:num)', 'ApiController::obtenerDetalleCompra/$1'); // Obtener detalles de una compra
$routes->get('api/categorias', 'ApiController::listarCategorias'); // Listar categorías con la cantidad de productos
$routes->get('api/comunidades', 'ApiController::listarComunidades'); // Listar comunidades
$routes->post('api/registro', 'ApiController::registrarUsuario');
$routes->get('api/productos', 'ApiController::listarProductos');
$routes->post('api/compra', 'ApiController::realizarCompra');
$routes->get('api/compras/(:num)', 'ApiController::listarComprasUsuario/$1');
