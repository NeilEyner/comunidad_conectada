<!-- application/Views/dashboard/cliente/verCarrito.php -->
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="ri-shopping-cart-line me-2"></i>Mi Carrito
                    </h4>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-light text-dark me-3"><?= count($Shop) ?> Productos</span>
                        <?php if (!empty($Shop)): ?>
                            <a href="<?php echo base_url('eliminarCarrito/' . $Shop[0]['compra_id'])?>" class="btn btn-danger btn-sm">
                                <i class="ri-delete-bin-line me-1"></i>Vaciar Carrito
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (empty($Shop)): ?>
                        <div class="alert alert-info text-center" role="alert">
                            <i class="ri-information-line me-2"></i>Tu carrito está vacío
                        </div>
                    <?php else: ?>
                        <?php
                        $subtotal = 0;
                        foreach ($Shop as $producto):
                            $subtotal += $producto['Precio'] * $producto['Cantidad'];
                            ?>
                            <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                                <div class="flex-shrink-0">
                                    <img src="<?= base_url() . $producto['Imagen_URL'] ?>"
                                        alt="<?= $producto['producto_nombre'] ?>" class="img-thumbnail me-3"
                                        style="width: 100px; height: 100px; object-fit: cover;">
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="mb-1"><?= $producto['producto_nombre'] ?></h5>
                                            <p class="text-muted mb-1">
                                                <small>
                                                    <i class="ri-user-line me-1"></i>Artesano:
                                                    <?= $producto['artesano_nombre'] ?>
                                                </small>

                                            </p>
                                        </div>
                                        <div class=" top-0 end-0">
                                            <a href="<?php echo base_url('eliminarProducto/' . $producto['compra_id'] . '/' . $producto['producto_id']); ?>" class="btn btn-xl btn-outline-danger">
                                                <i class="ri-delete-bin-line"></i>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="quantity-control d-flex align-items-center">
                                            <?php if ($producto['Stock'] >= 0): ?>
                                                <a href="<?php echo base_url('disminuir/' . $producto['compra_id'] . '/' . $producto['producto_id']); ?>"
                                                    class="btn btn-sm me-2 btn-outline-light bg-success">
                                                    <i class="ri-subtract-line text-white"></i>
                                                </a>
                                                <span class="mx-2"><?= $producto['Cantidad'] ?></span>
                                                <a href="<?php echo base_url('aumentar/' . $producto['compra_id'] . '/' . $producto['producto_id']); ?>"
                                                    class="btn btn-sm ms-2 <?= ($producto['Stock']) <= 0 ? 'disabled btn-outline-secondary' : 'bg-success btn-outline-light' ?>"
                                                    <?= ($producto['Stock']) <= 0 ? 'aria-disabled="true"' : '' ?>>
                                                    <i
                                                        class="ri-add-line <?= ($producto['Stock']) <= 0 ? 'text-secondary' : 'text-white' ?>"></i>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                        <div class="product-price ">
                                            <strong class="text-3xl">
                                                Bs. <?= number_format($producto['Precio'] * $producto['Cantidad'], 2) ?>
                                            </strong>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="ri-calculator-line me-2"></i>Resumen de Compra
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <strong>Bs. <?= number_format($subtotal, 2) ?></strong>
                    </div>
                    <!-- <div class="d-flex justify-content-between mb-2">
                        <span>IVA (16%)</span>
                        <strong>$<?= number_format($subtotal * 0.16, 2) ?></strong>
                    </div>
                    <div class="d-flex justify-content-between mb-3 pb-2 border-bottom">
                        <span>Envío</span>
                        <strong>$<?= number_format(0, 2) ?></strong>
                    </div>
                    <div class="d-flex justify-content-between total-amount">
                        <h5>Total</h5> 
                        <h5>$<?= number_format($subtotal * 1.16, 2) ?></h5>
                    </div> -->
                    <div class="d-flex justify-content-between total-amount">
                        <h5>Total</h5>
                        <h5>Bs. <?= number_format($subtotal, 2) ?></h5>
                    </div>
                    <div class="mt-4">
                        <a href="<?php echo base_url('pagos/metodo_pago/' . $producto['compra_id']); ?> "
                            class="btn btn-primary w-100">
                            <i class="ri-secure-payment-line me-2"></i>Procesar Compra
                        </a>
                        <a href="<?php echo base_url('tienda'); ?>" class="btn btn-outline-secondary w-100 mt-2">
                            <i class="ri-arrow-left-line me-2"></i>Continuar Comprando
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>