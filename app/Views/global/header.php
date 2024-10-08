<!DOCTYPE html>
<html lang="en">

<head>
    <title> comercio artesanal</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="<?php echo base_url();?>assets/img/apple-icon.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>assets/img/favicon.ico">

    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/templatemo.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/custom.css">

    <!-- Load fonts style after rendering the layout styles -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/fontawesome.min.css">

    <!-- Slick -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/slick.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/slick-theme.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/style.css">
<!--
    
TemplateMo 559 Zay Shop

https://templatemo.com/tm-559-zay-shop

-->
</head>


<body>
    <!-- Start Top Nav -->
    <nav class="navbar navbar-expand-lg bg-dark navbar-light d-none d-lg-block" id="templatemo_nav_top">
        <div class="container text-light">
            <div class="w-100 d-flex justify-content-between">
                <div>
                    <i class="fa fa-envelope mx-2"></i>
                    <a class="navbar-sm-brand text-light text-decoration-none" href="mailto:info@company.com">info@company.com</a>
                    <i class="fa fa-phone mx-2"></i>
                    <a class="navbar-sm-brand text-light text-decoration-none" href="tel:010-020-0340">010-020-0340</a>
                </div>
                <div>
                    <a class="text-light" href="https://fb.com/templatemo" target="_blank" rel="sponsored"><i class="fab fa-facebook-f fa-sm fa-fw me-2"></i></a>
                    <a class="text-light" href="https://www.instagram.com/" target="_blank"><i class="fab fa-instagram fa-sm fa-fw me-2"></i></a>
                    <a class="text-light" href="https://twitter.com/" target="_blank"><i class="fab fa-twitter fa-sm fa-fw me-2"></i></a>
                    <a class="text-light" href="https://www.linkedin.com/" target="_blank"><i class="fab fa-linkedin fa-sm fa-fw"></i></a>
                </div>
            </div>
        </div>
    </nav>
    <!-- Close Top Nav -->


    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light shadow">
        <div class="container d-flex justify-content-between align-items-center">
            <!-- <img class="img-fluid" src="<?php echo base_url();?>assets/icon/Recurso 2.png" alt="" width="100" height="110"> -->
            <a class="navbar-brand text-success logo h1 align-self-center" href="<?php echo base_url();?>">
                <img class="img-fluid" src="<?php echo base_url();?>assets/icon/Recurso 2.png" alt="" width="80" height="90">
                <?php echo ($titulo); ?>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#templatemo_main_nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="align-self-center collapse navbar-collapse flex-fill  d-lg-flex justify-content-lg-between" id="templatemo_main_nav">
                <div class="flex-fill">
                    <ul class="nav navbar-nav d-flex justify-content-between mx-lg-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url();?>">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url();?>nosotros">Nosotros</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url();?>tienda">Tienda</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url();?>contacto">Contacto</a>
                        </li> -->
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url();?>comunidades">Comunidades</a>
                        </li>

                        <p>
                            <?php if(!session()->get('isLoggedIn')){ ?>
                                <li class="nav-item">
                                <a class="nav-link" href="<?php echo base_url();?>login">Login</a>
                            </li>
                            <?php }else{ ?>
                                <li class="nav-item">
                                <a class="nav-link" href="<?php echo base_url();?>logout">Logout</a>
                            </li>
                            <?php } ?>
                            
                        </p>

                    </ul>
                </div>
                <div class="navbar align-self-center d-flex">

                <?php 
                use App\Models\TieneProductoModel;
                $tieneProductoModel = new TieneProductoModel();
                if(session()->get('isLoggedIn')){ 
                    if (session()->get('ID_Rol') == 2) {
                        
                    
                    ?>
                    <div class="shopcart">
                    <a class="nav-icon position-relative text-decoration-none" href="<?php echo base_url();?>tienda">
                    <i class="fa fa-fw fa-cart-arrow-down text-dark mr-1"></i>
                    <!-- <span class="position-absolute top-0 left-100 translate-middle badge rounded-pill bg-light text-dark">7</span> -->
                </a>
                <div class="shopcart_dropdown">
                    <?php 
                    
                    $size=0;
                        $total=0;
                        if($carrito!=null){
                            ?>
                        <div class="cart_droptitle">
                                <h4 class="text_lg"><?=sizeof($carrito)?> Productos</h4>
                            </div>
                            <?php
                            
                            foreach($carrito as $prod): 
                                $total=$prod['Total'];
                                $producto=$tieneProductoModel->ProductosDet($prod['ID_Artesano'],$prod['ID_Producto']);
                            ?>
                                <div class="cartsdrop_wrap">
                                    <a href="" class="single_cartdrop mb-3" style="text-decoration:none">
                                        <span class="remove_cart"><i class="las la-times"></i></span>
                                        <div class="cartdrop_img">
                                            <img loading="lazy"  src="<?=base_url($producto['Imagen_URL'])?>" alt="product">
                                        </div>
                                        <div class="cartdrop_cont">
                                            <h5 class=" mb-0 ">
                                            <?=$producto['Nombre']?>
                                            </h5>
                                            <p class="mb-0 text_xs text_p">x<?=$prod['Cantidad']?> <span class="ms-2"><?=$producto['Precio']?></span></p>
                                        </div>
                                    </a>
                                </div>

                            <?php
                            endforeach;
                            ?>
                            <div class="total_cartdrop">
                            <h5 class=" text-uppercase mb-0">Sub Total:</h5>
                            <h5 class=" mb-0 ms-2"><?= $total?></h5>
                        </div>
                        <div class=" d-flex mt-3">
                            <a href="shopping-cart.html" class="default_btn w-50  px-1"  style="text-decoration:none;">Ver Carrito</a>
                            <a href="<?php base_url('pagos/metodo_pago/9') ?>" class="default_btn second ms-3 w-50  px-1" style="text-decoration:none;">Pagar</a>
                        </div>
                        <?php
                        }else{
                            ?>
                            <div class="cartsdrop_wrap">
                                <h5 class="text-center">No hay productos en el carrito</h5>
                            </div>
                        <?php
                        }
                        
                        ?>
                        
                    </div>
                
                </div>
                        
                    <?php } ?>
                    <?= $ruta='';
                        if (session()->get('ID_Rol') == 4) {
                            $ruta = base_url().'dashboard/administrador/admin_dashboard';
                            }
                        if (session()->get('ID_Rol') == 1) {
                            $ruta = base_url().'dashboard/artesano/arte_dashboard';
                            }
                        if (session()->get('ID_Rol') == 2) {
                            $ruta = base_url().'dashboard/cliente/cli_dashboard';
                        }
                        if (session()->get('ID_Rol') == 3) {
                            $ruta = base_url().'dashboard/delivery/deli_dashboard';
                        }
                    ?>
                    <a class="nav-icon position-relative text-decoration-none" href="<?= $ruta?>" >
                        <i class="fa fa-fw fa-user text-dark mr-3"></i>
                        <!-- <span class="position-absolute top-0 left-100 translate-middle badge rounded-pill bg-light text-dark"> +99> </span> -->
                    </a>
                    <?php } ?>


                
                </div>
            </div>

        </div>
    </nav>
    <!-- Close Header -->