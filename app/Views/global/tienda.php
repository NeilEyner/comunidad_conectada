<?php
 $numProd=6;
 $prodMostrados=0;
?>
    
    
    <!-- <script  type="module" src="./assets/js/scripts/categoria.js" >
        import {cambiarCat,catTodos} from './assets/js/scripts/categoria.js';
        import {mostraProdCat,mostrarTodos} from './assets/js/scripts/producto.js';
    </script> -->
    <script   src="./assets/js/scripts/categoria.js" ></script>
        
    <script   src="./assets/js/scripts/producto.js" >
        // import {cambiarCat,catTodos} from './assets/js/scripts/categoria.js';
    </script>
    <script src="./assets/js/scripts/tienda.js"></script>
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



    <!-- Start Content -->
    <div class="container py-5">
        <div class="row">

            <div class="col-lg-3 " id="templatemo_main_nav">
                <h1 class="h2 pb-4">Categorias</h1>
                <ul class="list-unstyled nav navbar-nav ">
                    
                    <li class="p-0 nav-item" style="cursor: pointer" >
                        <a class=" d-flex nav-link justify-content-between p-0 " onclick="catTodos()">
                        &nbsp &nbsp Todo
                            <i id='cat-00' name='cat' class="pull-right fa fa-fw fa-check-circle mt-1"></i>
                        </a>
                    </li>

                    <?php usort($categorias, function($a, $b) {
                        return $a['Nombre'] <=> $b['Nombre'];
                    });
                    
                    foreach($categorias as $categoria): 
                           
                    ?>
                        
                    <li class="p-0 nav-item" style="cursor: pointer" onclick="cambiarCat('<?= $categoria['ID'] ?>')">
                        <a class=" d-flex nav-link justify-content-between p-0"  >
                        &nbsp &nbsp <?= $categoria['Nombre'] ?>
                            <i id='cat-<?= $categoria['ID'] ?>' name='cat' class="pull-right fa fa-fw fa-check-circle mt-1" hidden></i>
                        </a>
                    </li>
                    <?php endforeach; ?>
                    
                </ul>
            </div>

            <div class="col-lg-9">
                <div class="row">
                    <h1 class="h1" style="text-align: center;"> Nuestros Productos</h1>
                </div>
                <div class="row" id="div-prod">
                    <?php 
                    use App\Models\ProductoModel;
                   // use App\Models\UsuarioModel;
                    use App\Models\ProductoCategoriaModel;
                    use App\Models\ValoracionModel;
                    $count=0;
                    $prodMostrados=0;	
                    foreach($productos as $producto): 
                        $productoModel = new ProductoModel();
                        $valoracionModel = new ValoracionModel();
                        $puntajeRow=$valoracionModel->puntaje($producto['ID_Producto'],$producto['ID_Artesano']);
                        $puntaje=(15+$puntajeRow->Puntaje)/($puntajeRow->Num+5);
                        $puntaje=round($puntaje,1);
                        //$usuarioModel = new UsuarioModel();
                        $prod=$productoModel->find($producto['ID_Producto']);
                        //$artesano=$usuarioModel->find($producto['ID_Artesano']);
                        $productoCategoriaModel = new ProductoCategoriaModel();
                        $categorias = $productoCategoriaModel->where('ID_Producto', $producto['ID_Producto'])->findAll();

                        $hidden="";
                        if($count>=$numProd){
                            $hidden="hidden";
                        }
                        $count++;
                        ?>
                        <div class="col-md-4 <?php foreach($categorias as $categoria): 
                                echo 'cat-'.$categoria['ID_Categoria'].' ';
                            endforeach; ?>" <?php echo $hidden?> name="prod">
                            <div class="card mb-4 product-wap rounded-0">
                                <div class="card rounded-0">
                                    <img class="card-img rounded-0 " src="<?= $producto['Imagen_URL']?>" height="400px">
                                    <div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                        <ul class="list-unstyled">
                                        <?php if(session()->get('isLoggedIn')){
                                            if($puntajeRow->Puntaje==null){?>
                                                <li><a class="btn btn-success text-white"  id="h-t-<?=$producto['ID_Producto']?>-<?=$producto['ID_Artesano']?>" onclick="mostrarPunt('<?=base_url()?>',<?=$producto['ID_Producto']?>,<?=$producto['ID_Artesano']?>)" ><i id="heart-<?=$producto['ID_Producto']?>-<?=$producto['ID_Artesano']?>" class="far fa-heart " ></i></a></li>
                                            <?php }else{
                                                
                                        ?>
                                            <!-- <li><a class="btn btn-success text-white"   onclick="puntuar()" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="far fa-heart"></i></a></li> -->
                                            
                                            <li><a class="btn btn-success text-white"  ><i id="heart-<?=$producto['ID_Producto']?>-<?=$producto['ID_Artesano']?>" class="fa fa-heart " ></i></a></li>
                                        <?php } } ?>
                                            <li><a class="btn btn-success text-white mt-2" href="<?= base_url().'producto'.'/'. $producto['ID_Artesano'].'/'.$producto['ID_Producto'];  ?>"><i class="far fa-eye"></i></a></li>
                                            <li><a class="btn btn-success text-white mt-2" onclick="anadirProducto('<?= base_url()?>',<?= $producto['ID_Artesano']?>,<?= $producto['ID_Producto']?>,1,<?= $producto['Precio']?>)"><i class="fas fa-cart-plus" ></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body" style="text-align: center;"><b></b>
                                    <a href="<?= base_url().'producto'.'/'. $producto['ID_Artesano'].'/'.$producto['ID_Producto'];  ?>" class="h3 text-decoration-none"><b><?= $prod['Nombre'] ?> </b></a>
                                    <ul class="w-100 list-unstyled d-flex justify-content-between mb-0">
                                        <li><?= $producto['Descripcion']?></li>
                                        <li class="pt-2">
                                            <span class="product-color-dot color-dot-red float-left rounded-circle ml-1"></span>
                                            <span class="product-color-dot color-dot-blue float-left rounded-circle ml-1"></span>
                                            <span class="product-color-dot color-dot-black float-left rounded-circle ml-1"></span>
                                            <span class="product-color-dot color-dot-light float-left rounded-circle ml-1"></span>
                                            <span class="product-color-dot color-dot-green float-left rounded-circle ml-1"></span>
                                        </li>
                                    </ul>
                                    <p class="text-center mb-0"><b><?= $producto['Precio'] ?> Bs.</b></p>
                                    <hr></hr>
                                    <ul class="w-100 list-unstyled justify-content-between mb-0">
                                        <li><b>Artesano:</b> <?= $producto['Nombre'] ?></li>
                                        <li >
                                        <b>Comunidad:</b>
                                        <?= $producto['Comunidad'] ?>
                                        </li>
                                    </ul>
                                    <ul class="list-unstyled d-flex justify-content-center mb-1">
                                        <li id="estr-ti-<?=$producto['ID_Producto']?>-<?=$producto['ID_Artesano']?>">
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
                                    
                                </div>
                            </div>
                        </div>

                        <?php 
                        $prodMostrados++;
                    endforeach; ?>
                        
                </div>
                <div class="row" id='prod-Message'></div>
                <div div="row">
                    <ul  id="pag-t" class="pagination pagination-lg justify-content-end" >
                        
                    </ul>
                </div>
                <script >paginarTienda(<?php echo ($prodMostrados / $numProd)?>) </script>
            </div>

        </div>
    </div>
    <!-- End Content -->


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
  <div class="modal-dialog modal-dialog-centered" role="document" width="50"  style="width:fit-content">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Calificación</h5>
        
      </div>
      <div id="mod-body" class="modal-body" >
        
      </div>
      <div class="modal-footer">
        <button id="btn-mod-cancelar" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" id="accept" onclick="puntuar()" class="btn btn-primary" data-bs-dismiss="modal">Calificar</button>
      </div>
    </div>
  </div>
</div>
