
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


    <!-- Start Content Page -->

    <!-- shopping cart -->
     <div  class="pb-4 pt-4" style="min-height: 50vh;" >
        <div class="cart_area section_padding_b" >
            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        <h4 class="shop_cart_title sopcart_ttl d-none d-lg-flex">
                            <span>Producto</span>
                            <span>Cantidad</span>
                            <span>Precio Total</span>
                        </h4>
                        <div class="shop_cart_wrap">
                            <?php
                            use App\Models\TieneProductoModel;
                            $tieneProductoModel = new TieneProductoModel();
                            foreach($carrito as $prod): 
                                $producto=$tieneProductoModel->ProductosDet($prod['ID_Artesano'],$prod['ID_Producto']);
                            ?>
                            <div class="single_shop_cart d-flex align-items-center flex-wrap">
                                <div class="cart_img mb-4 mb-md-0">
                                    <img loading="lazy"  src="<?= base_url($producto['Imagen_URL'])?>" alt="product" style="width:150px">
                                </div>
                                <div class="cart_cont">
                                    <a href="product-view.html" style="text-decoration:none;">
                                        <h5><?= $producto['Nombre']?></h5>
                                    </a>
                                    <p >Bs.<?= $producto['Precio']?></p>
                                    
                                </div>
                                <div class="cart_qnty d-flex align-items-center ms-md-auto">
                                <ul class="list-inline pb-3">
                                            <li class="list-inline-item text-right">
                                                <input  type="hidden" name="product-quanity" id="product-quanity" max="<?=  $producto['Stock']  ?>" value="<?= $prod['Cantidad']?>" >
                                            </li>
                                            <li class="list-inline-item"><span class="btn btn-success" id="btn-menos" onclick="menos1()">-</span></li>
                                            <li class="list-inline-item" ><span class="badge bg-secondary" id="var-val"><?= $prod['Cantidad']?></span></li>
                                            <li class="list-inline-item" ><span class="btn btn-success" id="btn-mas" onclick="mas1()">+</span></li>
                                        </ul>
                                </div>
                                <div class=" ms-auto">
                                    <p>Bs.<?= $producto['Precio']*$prod['Cantidad']?></p>
                                </div>
                                <div class="cart_remove ms-auto">
                                    <i class="icon-trash"></i>
                                </div>
                            </div>
                            
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="col-lg-3 mt-4 mt-lg-0">
                        <div class="cart_summary">
                            <h4>Resumen del Pedido</h4>
                            <div class="cartsum_text d-flex justify-content-between">
                                <p class="text-semibold">Subtotal</p>
                                <p class="text-semibold">Bs.<?= $prod['Total']?></p>
                            </div>
                            <div class="cartsum_text d-flex justify-content-between">
                                <p>Delivery</p>
                                <p>Free</p>
                            </div>
                            <div class="cartsum_text d-flex justify-content-between">
                                <p>Tax</p>
                                <p>Free</p>
                            </div>
                            <div class="cart_sum_total d-flex justify-content-between">
                                <p>Total</p>
                                <p>Bs.45.00</p>
                            </div>
                            <div class="cart_sum_pros">
                                <button>pagar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     </div>
    


