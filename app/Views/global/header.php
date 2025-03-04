<?php
$telefono = '';
$correo = '';
foreach ($contenido as $cont):

    if ($cont['Tipo_contenido'] == 'TELEFONO'):
        $telefono = $cont['Contenido'];
        $GLOBALS["telefono"] = $cont['Contenido'];
    endif;

    if ($cont['Tipo_contenido'] == 'CORREO'):
        $correo = $cont['Contenido'];
        $GLOBALS["correo"] = $cont['Contenido'];
    endif;
endforeach;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title> COMUNIDAD CONECTADA </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="<?php echo base_url(); ?>assets/img/apple-icon.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>assets/icon/Recurso 2.png">

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/templatemo.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/fontawesome.min.css'); ?>">


    <!-- Slick -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/slick.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/slick-theme.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        .carousel-indicators{
            list-style: none;
        }
    </style>

</head>


<body>
    <!-- Start Top Nav -->
    <nav class="navbar navbar-expand-lg bg-dark navbar-light d-none d-lg-block" id="templatemo_nav_top">
        <div class="container text-light">
            <div class="w-100 d-flex justify-content-between">
                <div>
                    <i class="fa fa-envelope mx-2"></i>
                    <a class="navbar-sm-brand text-light text-decoration-none"
                        href="mailto:info@company.com"><?= $correo ?></a>
                    <i class="fa fa-phone mx-2"></i>
                    <a class="navbar-sm-brand text-light text-decoration-none"
                        href="tel:010-020-0340"><?= $telefono ?></a>
                </div>
            </div>
        </div>
    </nav>
    <!-- Close Top Nav -->


    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light shadow">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand text-success h1 align-self-center" href="<?php echo base_url(); ?>"
                title="<?php echo htmlspecialchars($titulo); ?>">
                <img class="img-fluid" src="<?php echo base_url('assets/icon/Recurso 2.png'); ?>"
                    alt="<?php echo htmlspecialchars($titulo); ?>" width="80" height="90">
                <span class="font-weight-bold h4"><?php echo htmlspecialchars($titulo); ?></span>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#templatemo_main_nav" aria-controls="templatemo_main_nav" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-between" id="templatemo_main_nav">
                <ul class="navbar-nav mx-lg-auto">
                    <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>nosotros">Nosotros</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>tienda">Tienda</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>comunidades">Comunidades</a>
                    </li>
                </ul>

                <div class="navbar align-self-center d-flex">
                    <?php
                    use App\Models\TieneProductoModel;
                    $tieneProductoModel = new TieneProductoModel();
                    if (session()->get('isLoggedIn')) {
                        if (session()->get('ID_Rol') != null) { ?>
                            <div class="dropdown mx-4">
                                <a href="#" class="nav-icon text-decoration-none" id="cartDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false" style="display: flex; align-items: center;">
                                    <i class="fa fa-shopping-cart" style="font-size: 24px; color: #333;"></i>
                                    <?php if (!empty($carrito)): ?>
                                        <span class="badge bg-danger cart-count"
                                            style="position: absolute; top: -8px; right: -8px; font-size: 12px;">
                                            <?= count($carrito) ?>
                                        </span>
                                    <?php endif; ?>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end p-0 " aria-labelledby="cartDropdown"
                                    style="min-width: 320px;">
                                    <div class="card border-0">
                                        <div
                                            class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                                            <h6 class="m-0">Carrito de Compras</h6>
                                            <span class="badge bg-light text-success"><?= count($carrito) ?> Productos</span>
                                        </div>
                                        <?php if (empty($carrito)): ?>
                                            <div class="card-body text-center">
                                                <p class="text-muted mb-0">
                                                    <i class="bi bi-cart-x text-success" style="font-size: 3rem;"></i>
                                                    <br>Tu carrito está vacío
                                                </p>
                                            </div>
                                        <?php else: ?>
                                            <div class="card-body p-0 max-height-300 overflow-auto">
                                                <?php
                                                $totalCarrito = 0;
                                                foreach ($carrito as $item):
                                                    $subtotal = $item['Precio'] * $item['Cantidad'];
                                                    $totalCarrito += $subtotal;
                                                    ?>
                                                    <div class="d-flex align-items-center p-3 border-bottom">
                                                        <img src="<?= base_url() . $item['Imagen_URL'] ?>" alt="<?= $item['Nombre'] ?>"
                                                            class="me-3 rounded" style="width: 60px; height: 60px; object-fit: cover;">
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-1"><?= $item['Nombre'] ?></h6>
                                                            <div class="text-muted small">
                                                                <?= $item['Cantidad'] ?> x Bs. <?= number_format($item['Precio'], 2) ?>
                                                            </div>
                                                        </div>
                                                        <strong class="text-success">Bs. <?= number_format($subtotal, 2) ?></strong>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                            <div class="card-footer bg-light d-flex justify-content-between align-items-center">
                                                <strong>Total:</strong>
                                                <strong class="text-success">Bs.<?= number_format($totalCarrito, 2) ?></strong>
                                            </div>
                                            <div class="card-body">
                                                <div class="d-flex justify-content-evenly">
                                                    <a href="<?= base_url('ver_carrito/') . $item['ID'] ?>"
                                                        class="btn btn-primary w-48 d-flex align-items-center justify-content-center text-white">
                                                        <i class="fas fa-shopping-cart me-2"></i> Ver Carrito
                                                    </a>
                                                    <a href="<?= base_url('pagos/metodo_pago/') . $item['ID'] ?>"
                                                        class="btn btn-success w-48 d-flex align-items-center justify-content-center text-white">
                                                        <i class="fas fa-credit-card me-2"></i> Pagar
                                                    </a>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <?php
                            $notificacionesModel = new \App\Models\NotificacionModel();
                            $usuarioID = session()->get('ID');
                            $notificacionesNoLeidas = $notificacionesModel->obtenerNotificacionesNoLeidas($usuarioID);
                            ?>
                            <div class="dropdown">
                                <a class="nav-icon text-decoration-none" href="#" id="notificationDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false" style="display: flex; align-items: center;">
                                    <i class="bi bi-bell" style="font-size: 24px; color: #333;"></i>
                                    <!-- Icono de campana -->
                                    <span class="badge bg-danger"
                                        style="position: absolute; top: 0; right: 0; font-size: 12px;">
                                        <?= is_array($notificacionesNoLeidas) ? count($notificacionesNoLeidas) : 0 ?>
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end " style="min-width: 320px;"
                                    aria-labelledby="notificationDropdown">
                                    <li>
                                        <h6 class="dropdown-header">Notificaciones</h6>
                                    </li>
                                    <?php if (is_array($notificacionesNoLeidas) && count($notificacionesNoLeidas) > 0): ?>
                                        <?php foreach ($notificacionesNoLeidas as $notificacion): ?>
                                            <li class="mx-2" style="">
                                                <!-- <a class="dropdown-item" href="<?= base_url('notificaciones/ver/' . $notificacion['ID']) ?>"> -->
                                                <strong
                                                    style="font-size:1.2rem !important;"></strong><?= $notificacion['Tipo'] ?></strong> - <em style="font-size:1rem;"><?= $notificacion['Fecha'] ?></em> <br>
                                                <p class="" style="font-size:.8rem !important;">
                                                    <?= substr($notificacion['Mensaje'], 0, 50) . (strlen($notificacion['Mensaje']) > 50 ? '...' : '') ?>
                                                </p>
                                                <!-- </a> -->
                                            </li>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <li><a class="dropdown-item text-muted" href="#">No tienes notificaciones</a></li>
                                    <?php endif; ?>
                                    <!-- <li>
                                        <hr class="dropdown-divider">
                                    </li> -->
                                    <!-- <li><a class="dropdown-item" href="<?= base_url('notificaciones') ?>">Ver todas las notificaciones</a></li> -->
                                </ul>
                            </div>
                            <?php
                            $ruta = '';
                            $opciones = [];
                            switch (session()->get('ID_Rol')) {
                                case 4: // Administrador
                                    $ruta = base_url('dashboard/administrador/admin_dashboard');
                                    $opciones = [
                                        ['text' => 'Panel de Control', 'link' => base_url('dashboard/administrador/admin_dashboard')],
                                        ['text' => 'Mis Compras', 'link' => base_url('dashboard/cliente/cli_dashboard')],
                                        ['text' => 'Perfil', 'link' => base_url('perfil/' . session()->get('ID'))],
                                    ];
                                    break;
                                case 1: // Artesano
                                    $ruta = base_url('dashboard/artesano/arte_dashboard');
                                    $opciones = [
                                        ['text' => 'Mis Productos', 'link' => base_url('dashboard/artesano/arte_dashboard')],
                                        ['text' => 'Mis Compras', 'link' => base_url('dashboard/cliente/cli_dashboard')],
                                        ['text' => 'Perfil', 'link' => base_url('perfil/' . session()->get('ID'))],
                                    ];
                                    break;
                                case 2: // Cliente
                                    $ruta = base_url('dashboard/cliente/cli_dashboard');
                                    $opciones = [
                                        ['text' => 'Mis Compras', 'link' => base_url('dashboard/cliente/cli_dashboard')],
                                        ['text' => 'Perfil', 'link' => base_url('perfil/' . session()->get('ID'))],
                                    ];
                                    break;
                                case 3: // Delivery
                                    $ruta = base_url('dashboard/delivery/deli_dashboard');
                                    $opciones = [
                                        ['text' => 'Mis Compras', 'link' => base_url('dashboard/cliente/cli_dashboard')],
                                        ['text' => 'Realizar Envio', 'link' => base_url('dashboard/delivery/deli_dashboard')],
                                        ['text' => 'Envios', 'link' => base_url('dashboard/delivery/envio')],
                                        ['text' => 'Perfil', 'link' => base_url('perfil/' . session()->get('ID'))],

                                    ];
                                    break;
                            }
                            ?>
                            <!-- Dropdown para el icono de usuario -->
                            <div class="dropdown mx-4">
                                <a class="nav-icon text-decoration-none" href="#" id="userDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false" style="display: flex; align-items: center;">
                                    <img src="<?= base_url() . session()->get('Imagen_URL') ?>" alt="Usuario"
                                        class="img-fluid rounded-circle" style="width: 30px; height: 30px; margin-right: 8px;">
                                    <div style="font-size: 14px; font-weight: 500;"><?= session()->get('Nombre') ?></div>
                                </a>

                                <!-- Menú desplegable -->
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">

                                    <?php foreach ($opciones as $opcion): ?>
                                        <li><a class="dropdown-item" href="<?= $opcion['link'] ?>"><?= $opcion['text'] ?></a>
                                        </li>
                                    <?php endforeach; ?>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item text-danger" href="<?php echo base_url(); ?>logout">Cerrar
                                            Sesión</a></li>
                                </ul>
                            </div>


                        <?php } ?>
                    <?php } else { ?>
                        <ul class="navbar-nav">
                            <li class="nav-item"><a class="nav-link btn btn-success me-2 text-white"
                                    href="<?php echo base_url(); ?>login"> <b>Iniciar Sesión</b> </a></li>
                            <li class="nav-item"><a class="nav-link btn btn-success text-white"
                                    href="<?php echo base_url(); ?>register"><b>Registrarse</b></a></li>
                        </ul>
                    <?php } ?>
                </div>
            </div>
        </div>
    </nav>
    <style>
        /* Mostrar el menú desplegable al hacer hover */
        .dropdown:hover .dropdown-menu {
            display: block;
            margin-top: 0;
            /* Ajusta la posición para evitar espacios no deseados */
        }
    </style>
    <!-- Close Header -->