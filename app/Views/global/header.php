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

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/fontawesome.min.css'); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Slick -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/slick.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/slick-theme.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css">
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
                <!-- <div>
                    <a class="text-light" href="https://fb.com/templatemo" target="_blank" rel="sponsored"><i class="fab fa-facebook-f fa-sm fa-fw me-2"></i></a>
                    <a class="text-light" href="https://www.instagram.com/" target="_blank"><i class="fab fa-instagram fa-sm fa-fw me-2"></i></a>
                    <a class="text-light" href="https://twitter.com/" target="_blank"><i class="fab fa-twitter fa-sm fa-fw me-2"></i></a>
                    <a class="text-light" href="https://www.linkedin.com/" target="_blank"><i class="fab fa-linkedin fa-sm fa-fw"></i></a>
                </div> -->
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
                            <div class="shopcart position-relative">
                                <a class="nav-icon text-decoration-none" href="<?php echo base_url(); ?>tienda">
                                    <i class="fa fa-fw fa-cart-arrow-down text-dark"></i>
                                    <span
                                        class="position-absolute top-0 left-100 translate-middle badge rounded-pill bg-light text-dark"><?= sizeof($carrito) ?></span>
                                </a>
                                <div class="shopcart_dropdown" id='carrito-m'>
                                    <?php if ($carrito != null) { ?>
                                        <div class="cart_droptitle">
                                            <h4 class="text-lg"><?= sizeof($carrito) ?> Productos</h4>
                                        </div>
                                        <?php foreach ($carrito as $prod):
                                            $total = $prod['Total'];
                                            $producto = $tieneProductoModel->ProductosDet($prod['ID_Artesano'], $prod['ID_Producto']); ?>
                                            <div class="cartsdrop_wrap">
                                                <a href="#" class="single_cartdrop mb-2 d-flex align-items-center"
                                                    style="text-decoration:none">
                                                    <span class="remove_cart"><i class="las la-times"></i></span>
                                                    <img loading="lazy" src="<?= base_url($producto['Imagen_URL']) ?>" alt="product"
                                                        class="cartdrop_img me-2" width="40" height="40">
                                                    <div>
                                                        <h5 class="mb-0"><?= $producto['Nombre'] ?></h5>
                                                        <p class="mb-0 text-xs text-muted">x<?= $prod['Cantidad'] ?>
                                                            <span class="ms-2"><?= $producto['Precio'] ?></span>
                                                        </p>
                                                    </div>
                                                </a>
                                            </div>
                                        <?php endforeach; ?>
                                        <div class="total_cartdrop">
                                            <h5 class="text-uppercase mb-0">Sub Total:</h5>
                                            <h5 class="ms-2"><?= $total ?></h5>
                                        </div>
                                        <div class="d-flex mt-3">
                                            <a href="<?= base_url('carrito') ?>" class="btn btn-success w-50 px-1">Ver Carrito</a>
                                            <a href="<?= base_url('pagos/metodo_pago/' . $prod['ID']); ?>"
                                                class="btn btn-secondary ms-3 w-50 px-1">Pagar</a>
                                        </div>
                                    <?php } else { ?>
                                        <div class="cartsdrop_wrap">
                                            <h5 class="text-center">No hay productos en el carrito</h5>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>

                            <?php
                            $ruta = '';
                            $opciones = [];
                            switch (session()->get('ID_Rol')) {
                                case 4: // Administrador
                                    $ruta = base_url('dashboard/administrador/admin_dashboard');
                                    $opciones = [
                                        ['text' => 'Dashboard', 'link' => base_url('dashboard/administrador/admin_dashboard')],
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
                            <div class="dropdown">
                                <a class="nav-icon text-decoration-none" href="#" id="userDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false" style="display: flex; align-items: center;">
                                    <img src="<?=base_url().session()->get('Imagen_URL') ?>" alt="Usuario"
                                        class="img-fluid rounded-circle" style="width: 30px; height: 30px; margin-right: 8px;">
                                    <div style="font-size: 14px; font-weight: 500;"><?= session()->get('Nombre') ?></div>
                                </a>

                                <!-- Menú desplegable -->
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    
                                    <?php foreach ($opciones as $opcion): ?>
                                        <li><a class="dropdown-item" href="<?= $opcion['link'] ?>"><?= $opcion['text'] ?></a></li>
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