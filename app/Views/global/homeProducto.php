<!-- Start Featured Product -->
<section class="bg-light">
    <div class="container py-5">
        <div class="row text-center py-3">
            <div class="col-lg-6 m-auto">
                <h1 class="h1">Productos</h1>
                <!-- <p>
                    Reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                    Excepteur sint occaecat cupidatat non proident.
                </p> -->
            </div>
        </div>
        <div class="row">
            <?php
            use App\Models\ProductoModel;
            use App\Models\UsuarioModel;
            $count = 0;
            foreach ($productos as $producto):
                if ($count == 3) {
                    break;
                }
                $count++;
                $productoModel = new ProductoModel();
                $usuarioModel = new UsuarioModel();
                $prod = $productoModel->find($producto['ID_Producto']);
                $artesano = $usuarioModel->find($producto['ID_Artesano']);

                ?>
                <div class="col-12 col-md-4 mb-4">
                    <div class="card h-100">
                        <a href="shop-single.html">
                            <img src="<?= $producto['Imagen_URL'] ?>" class="card-img-top" height="300px" alt="...">
                        </a>
                        <div class="card-body">
                            <ul class="list-unstyled d-flex justify-content-between">
                                <li>
                                    <i class="text-warning fa fa-star"></i>
                                    <i class="text-warning fa fa-star"></i>
                                    <i class="text-warning fa fa-star"></i>
                                    <i class="text-muted fa fa-star"></i>
                                    <i class="text-muted fa fa-star"></i>
                                </li>
                                <li class="text-muted text-right"><?= $producto['Precio'] ?></li>
                            </ul>
                            <a href="shop-single.html" class="h2 text-decoration-none text-dark"></a>
                            <p class="card-text">
                                <?= isset($prod['Descripcion']) ? $prod['Descripcion'] : 'Descripción no disponible'; ?>
                            </p>

                            <p class="text-muted">Reviews (24)</p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<!-- End Featured Product -->