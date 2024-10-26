 
 <script   src="<?php echo base_url() ?>assets/js/scripts/producto.js" >
        // import {cambiarCat,catTodos} from './assets/js/scripts/categoria.js';
    </script>

 <!-- Modal -->
 <div class="modal fade bg-white" id="templatemo_search" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="w-100 pt-1 mb-5 text-right">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="get" class="modal-content modal-body border-0 p-0">
                <div class="input-group mb-2">
                    <input type="text" class="form-control" id="inputModalSearch" name="q" placeholder="Search ...">
                    <button type="submit" class="input-group-text bg-success text-light">
                        <i class="fa fa-fw fa-search text-white"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>



    <!-- Open Content -->
    <section class="bg-light">
        <div class="container pb-5">
            <div class="row">
                <div class="col-lg-5 mt-5">
                    <div class="card mb-3">
                        <img class="card-img img-fluid" src="<?php echo base_url().$producto['Imagen_URL']; ?>" alt="Card image cap" id="product-detail">
                    </div>
                    <div class="row">
                        
                    </div>
                </div>
                <!-- col end -->
                <div class="col-lg-7 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="h2"><?php echo $prod['Nombre'] ?></h1>
                            <p class="h3 py-2"><?php echo $producto['Precio']; ?></p>
                            <p class="py-2">
                            <?php 
                            use App\Models\ValoracionModel;
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
                                <span class="list-inline-item text-dark">Rating <?= $puntaje?></span>
                            </p>
                            <!-- <ul class="list-inline">
                                <li class="list-inline-item">
                                    <h6>Brand:</h6>
                                </li>
                                <li class="list-inline-item">
                                    <p class="text-muted"><strong>Easy Wear</strong></p>
                                </li>
                            </ul> -->

                            <h6>Descripción:</h6>
                            <p><?php echo $producto['Descripcion']; ?></p>
                            <!-- <ul class="list-inline">
                                <li class="list-inline-item">
                                    <h6>Avaliable Color :</h6>
                                </li>
                                <li class="list-inline-item">
                                    <p class="text-muted"><strong>White / Black</strong></p>
                                </li>
                            </ul> -->

                            <!-- <h6>Specification:</h6>
                            <ul class="list-unstyled pb-3">
                                <li>Lorem ipsum dolor sit</li>
                                <li>Amet, consectetur</li>
                                <li>Adipiscing elit,set</li>
                                <li>Duis aute irure</li>
                                <li>Ut enim ad minim</li>
                                <li>Dolore magna aliqua</li>
                                <li>Excepteur sint</li>
                            </ul> -->

                            <!-- <form action="" method="GET"> -->
                                <input type="hidden" name="product-title" value="Activewear">
                                <div class="row">
                                    <!-- <div class="col-auto">
                                        <ul class="list-inline pb-3">
                                            <li class="list-inline-item">Size :
                                                <input type="hidden" name="product-size" id="product-size" value="S">
                                            </li>
                                            <li class="list-inline-item"><span class="btn btn-success btn-size">S</span></li>
                                            <li class="list-inline-item"><span class="btn btn-success btn-size">M</span></li>
                                            <li class="list-inline-item"><span class="btn btn-success btn-size">L</span></li>
                                            <li class="list-inline-item"><span class="btn btn-success btn-size">XL</span></li>
                                        </ul>
                                    </div> -->
                                    <?php if(session()->get('isLoggedIn')){ ?>
                                    <div class="col-auto">
                                        <ul class="list-inline pb-3">
                                            <li class="list-inline-item text-right">
                                                Cantidad
                                                <input  type="hidden" name="product-quanity" id="product-quanity" max="<?=  $producto['Stock']  ?>" value="1" >
                                            </li>
                                            <li class="list-inline-item"><span class="btn btn-success" id="btn-menos" onclick="menos1()">-</span></li>
                                            <li class="list-inline-item" ><span class="badge bg-secondary" id="var-val">1</span></li>
                                            <li class="list-inline-item" ><span class="btn btn-success" id="btn-mas" onclick="mas1()">+</span></li>
                                        </ul>
                                    </div>
                                </div>
                                
                                <!-- <script>
                                        var a=document.getElementById("product-quanity").max ;
                                        console.log(a);
                                        console.log(typeof(val));
                                            console.log(typeof($("#product-quanity").attr("max")));
                                    </script> -->
                                <div class="row pb-3">
                                    <!-- <div class="col d-grid">
                                        <button type="submit" class="btn btn-success btn-lg" name="submit" value="buy">Comprar</button>
                                    </div> -->
                                    <div class="col d-grid">
                                        <button  class="btn btn-success btn-lg"  value="addtocard" onclick="anadirProducto('<?= base_url()?>',<?= $producto['ID_Artesano']?>,<?= $producto['ID_Producto']?>, document.getElementById('product-quanity').value ,<?= $producto['Precio']?>)">Añadir al Carrito</button>
                                    </div>
                                </div>
                                <?php } ?>
                            <!-- </form> -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Close Content -->

    <!-- Start Article -->
    <section class="py-5">
        <div class="container">
            <div class="row text-left p-2 pb-3">
                <h4>Productos Relacionados</h4>
            </div>

            <!--Start Carousel Wrapper-->
            <div id="carousel-related-product">
                <?php 
                use App\Models\ProductoModel;
                
                foreach ($prodR as $p): 
                    $productoModel = new ProductoModel();
                    $prodDet=$productoModel->find($p['ID_Producto']);
                    $valoracionModel = new ValoracionModel();
                    $puntajeRow=$valoracionModel->puntaje($p['ID_Producto'],$p['ID_Artesano']);
                    $puntaje=(15+$puntajeRow->Puntaje)/($puntajeRow->Num+5);
                    $puntaje=round($puntaje,1);
                    ?>
                <div class="p-2 pb-3">
                    <div class="product-wap card rounded-0">
                        <div class="card rounded-0">
                            <img class="card-img rounded-0 img-fluid" src="<?=  base_url().$p['Imagen_URL']  ?>" style="height:30vh">
                            <div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                <ul class="list-unstyled">
                                <?php if(session()->get('isLoggedIn')){?>
                                    <li><a class="btn btn-success text-white" href=""><i class="far fa-heart"></i></a></li>
                                <?php } ?>
                                    <li><a class="btn btn-success text-white mt-2" href="<?= base_url().'producto'.'/'. $p['ID_Artesano'].'/'.$p['ID_Producto'];  ?>"><i class="far fa-eye"></i></a></li>
                                    <li><a class="btn btn-success text-white mt-2" href=""><i class="fas fa-cart-plus"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <a href="<?= base_url().'producto'.'/'. $p['ID_Artesano'].'/'.$p['ID_Producto'];  ?>" class="h3 text-decoration-none"><?=  $prodDet['Nombre']  ?></a>
                            <!-- <ul class="w-100 list-unstyled d-flex justify-content-between mb-0">
                                <li>M/L/X/XL</li>
                                <li class="pt-2">
                                    <span class="product-color-dot color-dot-red float-left rounded-circle ml-1"></span>
                                    <span class="product-color-dot color-dot-blue float-left rounded-circle ml-1"></span>
                                    <span class="product-color-dot color-dot-black float-left rounded-circle ml-1"></span>
                                    <span class="product-color-dot color-dot-light float-left rounded-circle ml-1"></span>
                                    <span class="product-color-dot color-dot-green float-left rounded-circle ml-1"></span>
                                </li>
                            </ul> -->
                            <ul class="list-unstyled d-flex justify-content-center mb-1">
                                <li>
                                <?php for($i=0;$i<5;$i++){
                                        if($puntaje>=1){
                                            echo '<i class="text-warning fa fa-star"></i>';
                                        }else{
                                            if($puntaje>=0.29 && $puntaje<=0.8){
                                                echo '<i class="text-warning fa fa-star-half-alt"></i>';
                                            }else{
                                                echo '<i class="text-muted fa fa-star"></i>';
                                            }
                                        }
                                        $puntaje--;
                                    } ?>
                                </li>
                            </ul>
                            <p class="text-center mb-0"><?=  $p['Precio']  ?> Bs.</p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

            </div>


        </div>
    </section>
    <!-- End Article -->

    <!-- Start Slider Script -->
    
    <!-- End Slider Script -->
