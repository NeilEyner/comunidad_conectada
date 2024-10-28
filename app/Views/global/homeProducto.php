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
            use App\Models\ValoracionModel;
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
                        <a href="<?= base_url().'producto'.'/'. $producto['ID_Artesano'].'/'.$producto['ID_Producto'];  ?>">
                        <img src="<?= $producto['Imagen_URL'] ?>" class="card-img-top" style="width: 100%; height: 300px; object-fit: cover;" alt="...">

                        </a>
                        <div class="card-body">
                            <ul class="list-unstyled d-flex justify-content-between">
                                <li>
                                <?php 
                                    
                                    $valoracionModel = new ValoracionModel();
                                    $puntajeRow=$valoracionModel->puntaje($producto['ID_Producto'],$producto['ID_Artesano']);
                                    $puntaje=(15+$puntajeRow->Puntaje)/($puntajeRow->Num+5);
                                    $puntaje=round($puntaje,1);
                                    $puntajed=$puntaje;
                                    for($i=0;$i<5;$i++){
                                        if($puntajed>=1){
                                            echo '<i class="text-warning fa fa-star"></i>';
                                        }else{
                                            if($puntajed>=0.29 && $puntajed<=0.8){
                                                echo '<i class="text-warning fa fa-star-half-alt"></i>';
                                            }else{
                                                echo '<i class="text-muted fa fa-star"></i>';
                                            }
                                        }
                                        $puntajed--;
                                    } ?>
                                </li>
                                <li class="text-muted text-right"><?= $producto['Precio'] ?></li>
                            </ul>
                            <a href="shop-single.html" class="h2 text-decoration-none text-dark"></a>
                            <p class="card-text">
                                <?= isset($prod['Descripcion']) ? $prod['Descripcion'] : 'Descripción no disponible'; ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<!-- End Featured Product -->