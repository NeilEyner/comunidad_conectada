

<script   src="<?php echo base_url() ?>assets/js/scripts/producto.js" >
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


<!-- Start Content Page -->

<!-- shopping cart -->
<div class="pb-4 pt-4" style="min-height: 50vh;">
    <div class="cart_area section_padding_b">
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
                        foreach ($carrito as $prod):
                            $producto = $tieneProductoModel->ProductosDet($prod['ID_Artesano'], $prod['ID_Producto']);
                            ?>
                            <div id="prod-carr-<?=$prod['ID'].'-'.$prod['ID_Producto'].'-'.$prod['ID_Artesano']?>" class="single_shop_cart d-flex align-items-center flex-wrap">
                                <div class="cart_img mb-4 mb-md-0">
                                    <img loading="lazy"  src="<?= base_url($prod['Imagen_URL'])?>" alt="product" style="width:150px">
                                </div>
                                <div class="cart_cont">
                                    <a href="product-view.html" style="text-decoration:none;">
                                        <h5><?= $prod['Nombre']?></h5>
                                    </a>
                                    <p ><?= $prod['Precio']?> Bs.</p>
                                    
                                </div>
                                <div class="cart_qnty d-flex align-items-center ms-md-auto">
                                <ul id="carr-edit" class="list-inline pb-3">
                                            <li class="list-inline-item text-right">
                                                <input  type="hidden" name="product-quanity" id="product-quanity" max="<?=  $prod['Stock']  ?>" value="<?= $prod['Cantidad']?>" >
                                            </li>
                                            <li class="list-inline-item"><span class="btn btn-success" id="<?= 'carr-btn-menos-'.$prod['ID_Producto'].'-'.$prod['ID_Artesano'];?>" onclick="editCarr('<?=base_url()?>',<?=$prod['ID'].','.$prod['ID_Producto'].','.$prod['ID_Artesano'].','.$prod['Stock'].','.$prod['Cantidad'].','.$prod['Precio']?>,-1)">-</span></li>
                                            <li class="list-inline-item" ><span class="badge bg-secondary" id="<?= 'var-val-'.$prod['ID_Producto'].'-'.$prod['ID_Artesano'];?>"><?= $prod['Cantidad']?></span></li>
                                            <li class="list-inline-item" ><span class="btn btn-success" id="<?= 'carr-btn-mas-'.$prod['ID_Producto'].'-'.$prod['ID_Artesano'];?>" onclick="editCarr('<?=base_url()?>',<?=$prod['ID'].','.$prod['ID_Producto'].','.$prod['ID_Artesano'].','.$prod['Stock'].','.$prod['Cantidad'].','.$prod['Precio']?>,1)">+</span></li>
                                        </ul>
                                </div>
                                <div class=" ms-auto">
                                    <p id="<?= 'pre-'.$prod['ID_Producto'].'-'.$prod['ID_Artesano'];?>"><?= $prod['Precio']*$prod['Cantidad']?> Bs.</p>
                                    
                                </div>
                                <div class=" align-items-center ms-md-auto ms-auto">
                                    <ul class="list-inline pb-3">
                                        
                                        <li class="list-inline-item btn p-0 m-0 " onclick="eliminar('<?=base_url()?>',<?=$prod['ID'].','.$prod['ID_Producto'].','.$prod['ID_Artesano']?>)"><span class=""><i class="bi bi-trash "  data-bs-toggle="tooltip" data-bs-placement="right" title="eliminar"></i></span></li>
                                        
                                    </ul>
                                </div>
                            </div>
                            
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 mt-4 mt-lg-0">
                        <div class="cart_summary">
                            <h4>Resumen del Pedido</h4>
                            <?php
                            $total=0;
                            foreach($carrito as $prod): 
                                // $producto=$tieneProductoModel->ProductosDet($prod['ID_Artesano'],$prod['ID_Producto']);
                                // $total+=$producto['Precio']*$prod['Cantidad'];

                            ?>
                            <div id="res-<?=$prod['ID'].'-'.$prod['ID_Producto'].'-'.$prod['ID_Artesano']?>" class="cartsum_text d-flex justify-content-between">
                                <p><?= $prod['Nombre']?></p>
                                <p id="<?= 'pre2-'.$prod['ID_Producto'].'-'.$prod['ID_Artesano'];?>"><?= $prod['Precio']*$prod['Cantidad']?> Bs.</p>
                            </div>
                            <?php
                            endforeach;
                            ?>
                            
                           
                            <div class="cart_sum_total d-flex justify-content-between">
                                <p ><b>Total</b></p>
                                <p ><b id="total"><?= $prod['Total']?> Bs.</b></p>
                            </div>
                            <div class="cart_sum_pros">
                                <a href="<?php echo base_url('pagos/metodo_pago/'.$prod['ID']); ?>"
                                class="default_btn second ms-3 w-50  px-1" style="text-decoration:none;">Pagar</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
     </div>


<script src="<?= base_url('assets/js/bootstrap.bundle.min.js')?>"></script>
<script>
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
return new bootstrap.Tooltip(tooltipTriggerEl)
})
</script>
    


