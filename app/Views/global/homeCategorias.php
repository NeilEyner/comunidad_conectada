
    <!-- Start Categories of The Month -->
    <section class="container py-5">
        <div class="row text-center pt-3">
            <div class="col-lg-6 m-auto">
                <h1 class="h1">Categorias del Mes</h1>
                <!-- <p>
                    Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
                    deserunt mollit anim id est laborum.
                </p> -->
            </div>
        </div>
        <div class="row">

            <?php 
                use App\Models\CategoriaModel;
                use App\Models\ProductoModel;
                use App\Models\ProductoCategoriaModel;
                use App\Models\TieneProductoModel;
                $categoriaModel = new CategoriaModel();
                $categorias = $categoriaModel->findAll();
                $c=0;
                foreach($categorias as $categoria): 
                    $count =0;
                    //$productoModel = new ProductoModel();
                    $productoCategoriaModel = new ProductoCategoriaModel();
                    $tieneProductoModel = new TieneProductoModel();

                    $producto = $productoCategoriaModel->where('ID_Categoria', $categoria['ID'])->findAll();
                    //$jjj=reset($producto);
                    //echo serialize($jjj);
                    foreach($producto as $prodC):
                        $prod = $tieneProductoModel->where('ID_Producto', $prodC['ID_Producto'])->findAll();
                        if(sizeof($prod)==0){
                            continue;
                        }else{
                            $count=1;
                            $c++;
                        ?>
                        <div class="col-12 col-md-4 p-5 mt-3">
                            <a href="<?php echo base_url();?>tienda" ><img src="<?= array_shift($prod)['Imagen_URL'] ?>" class="rounded-circle  square img-fluid border " style='width:30vh; height:30vh;'></a>
                            <h5 class="text-center mt-3 mb-3"><?= $categoria['Nombre'] ?></h5>
                            <p class="text-center"><a class="btn btn-success">Ir a la Tienda</a></p>
                        </div>
                        <?php
                        }
                        if($count>=1)
                            break;
                    endforeach;
                    if($c>=3)
                            break;
                ?>
            <?php endforeach; ?>
            <!-- <div class="col-12 col-md-4 p-5 mt-3">
                <a href="#"><img src="./assets/img/imagen3.jpg" class="rounded-circle img-fluid border"></a>
                <h5 class="text-center mt-3 mb-3">Cat 1</h5>
                <p class="text-center"><a class="btn btn-success">Go Shop</a></p>
            </div>
            <div class="col-12 col-md-4 p-5 mt-3">
                <a href="#"><img src="./assets/img/imagen3.jpg" class="rounded-circle img-fluid border"></a>
                <h2 class="h5 text-center mt-3 mb-3">Cat 2</h2>
                <p class="text-center"><a class="btn btn-success">Go Shop</a></p>
            </div>
            <div class="col-12 col-md-4 p-5 mt-3">
                <a href="#"><img src="./assets/img/imagen3.jpg" class="rounded-circle img-fluid border"></a>
                <h2 class="h5 text-center mt-3 mb-3">Cat 3</h2>
                <p class="text-center"><a class="btn btn-success">Go Shop</a></p>
            </div> -->
        </div>
    </section>
    <!-- End Categories of The Month -->
