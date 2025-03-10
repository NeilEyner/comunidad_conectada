<!-- Start Footer -->
<footer class="bg-dark" id="tempaltemo_footer">
    <div class="container">
        <div class="row">

            <div class="col-md-4 pt-5">
                <h2 class="h2 text-success border-bottom pb-3 border-light logo">Tienda de Artesanias</h2>
                <ul class="list-unstyled text-light footer-link-list">
                    <!-- <li>
                            <i class="fas fa-map-marker-alt fa-fw"></i>
                            Av. Rosedales Nro 1660
                        </li> -->
                    <li>
                        <i class="fa fa-phone fa-fw"></i>
                        <a class="text-decoration-none" href="tel:010-020-0340"><?= $GLOBALS["telefono"] ?></a>
                    </li>
                    <li>
                        <i class="fa fa-envelope fa-fw"></i>
                        <a class="text-decoration-none" href="mailto:info@company.com"><?= $GLOBALS["correo"] ?></a>
                    </li>
                </ul>
            </div>

            <div class="col-md-4 pt-5">
                <h2 class="h2 text-light border-bottom pb-3 border-light">Productos</h2>
                <ul class="list-unstyled text-light footer-link-list">
                    <?php
                    use
                    App\Models\CategoriaModel;
                    $categoriaModel = new CategoriaModel();
                    $categorias = $categoriaModel->findAll();
                    $count = 0;
                    foreach ($categorias as $categoria):
                        if ($count > 4)
                            break;
                        $count++;
                        ?>
                        <li><a class="text-decoration-none"
                                href="<?php echo base_url(); ?>tienda"><?= $categoria['Nombre'] ?></a></li>
                    <?php endforeach; ?>

                </ul>
            </div>

            <div class="col-md-4 pt-5">
                <h2 class="h2 text-light border-bottom pb-3 border-light">Más Información</h2>
                <ul class="list-unstyled text-light footer-link-list">
                    <li><a class="text-decoration-none" href="<?php echo base_url(); ?>">Inicio</a></li>
                    <li><a class="text-decoration-none" href="<?php echo base_url(); ?>nosotros">Nosotros</a></li>
                    <li><a class="text-decoration-none" href="<?php echo base_url(); ?>tienda">Tienda</a></li>
                    <li><a class="text-decoration-none" href="<?php echo base_url(); ?>contacto">Contacto</a></li>
                    <li><a class="text-decoration-none" href="<?php echo base_url(); ?>comunidades">Comunidades</a></li>
                </ul>
            </div>

        </div>

        <div class="row text-light mb-4">
            <div class="col-12 mb-3">
                <div class="w-100 my-3 border-top border-light"></div>
            </div>
        </div>
    </div>

    <div class="w-100 bg-black py-3">
        <div class="container">
            <div class="row pt-2">
                <div class="col-12">
                    <p class="text-left text-light">
                        Copyright &copy; 2021 Comunidad Conectada
                        </p>
                </div>
            </div>
        </div>
    </div>

</footer>
<!-- End Footer -->

<!-- Start Script -->
<script src="<?php echo base_url(); ?>assets/js/jquery-1.11.0.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-migrate-1.2.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/templatemo.js"></script>
<script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
<!-- End Script -->

<script src="<?php echo base_url(); ?>assets/js/slick.min.js"></script>
<script>

    $('#carousel-related-product').slick({
        infinite: true,
        arrows: false,
        slidesToShow: 4,
        slidesToScroll: 3,
        dots: true,
        responsive: [{
            breakpoint: 1024,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3
            }
        },
        {
            breakpoint: 600,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 3
            }
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 3
            }
        }
        ]
    });
</script>
</body>

</html>