<style>
    h2,
    h3,
    label {
        color: #2e7d32;
        /* Verde oscuro para los títulos */
    }

    .form-control,
    select {
        border: 1px solid #4caf50;
        /* Borde verde */
        box-shadow: none;
    }

    button {
        background-color: #4caf50;
        /* Botón verde */
        border: none;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #388e3c;
    }

    #informacion_pago {
        margin-top: 20px;
        border: 1px solid #e0e0e0;
        padding: 15px;
        border-radius: 5px;
    }

    .cart_item img {
        max-width: 120px;
    }

    .cart_summary,
    #informacion_pago {
        border: 1px solid #e0e0e0;
        padding: 15px;
        border-radius: 5px;
    }

    .cart_summary h4,
    #informacion_pago h3 {
        margin-bottom: 10px;
    }

    .cart_total {
        font-weight: bold;
        color: #2e7d32;
    }

    .container {
        display: flex;
        gap: 30px;
    }

    .column {
        flex: 1;
    }

    .single_shop_cart {
        font-size: 13px;
        /* Texto más pequeño */
    }

    .cart_summary {
        font-size: 14px;
    }

    .btn-link {
        font-size: 14px;
        /* Tamaño del botón de eliminar */
    }

    h6 {
        font-size: 14px;
    }

    .single_shop_cart {
        margin: 0;
    }
</style>

<body>
    <div class="container mt-5">
        <!-- Columna izquierda: Carrito de compras -->
        <div class="column">
            <h2 class="h5 mb-3">Carrito de Compras</h2>
            <div class="shop_cart_wrap">
                <?php foreach ($carrito as $prod):
                    $producto = $tieneProductoModel->ProductosDet($prod['ID_Artesano'], $prod['ID_Producto']);
                    ?>
                    <div class="single_shop_cart row align-items-center py-2 border-bottom">
                        <div class="col-2 text-center">
                            <img class="img-fluid rounded" style="width: 50px; height: 50px;" loading="lazy"
                                src="<?= base_url($producto['Imagen_URL']) ?>" alt="product">
                        </div>
                        <div class="col-4">
                            <h6 class="m-0"><?= $producto['Nombre'] ?></h6>
                            <small class="text-muted">Bs.<?= $producto['Precio'] ?></small>
                        </div>
                        <div class="col-2 text-center">
                            <span><?= $prod['Cantidad'] ?></span>
                        </div>
                        <div class="col-2 text-end">
                            <p class="mb-0">Bs.<?= $producto['Precio'] * $prod['Cantidad'] ?></p>
                        </div>
                        <div class="col-2 text-center">
                            <button class="btn btn-link text-danger p-0">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="cart_summary mt-3">
                <h4 class="h6">Resumen del Pedido</h4>
                <!-- <div class="d-flex justify-content-between">
                    <span>Subtotal:</span> <span>Bs.<?= $prod['Total'] ?></span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Delivery:</span> <span>Gratis</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Impuestos:</span> <span>Gratis</span>
                </div> -->
                <div class="d-flex justify-content-between fw-bold">
                    <span>Total:</span> <span>Bs.<?= $prod['Total'] ?></span>
                </div>
            </div>
            <br>
            <br><br>
            <br>
        </div>



        <!-- Columna derecha: Selección de método de pago -->
        <div class="column">
            <h2>Seleccionar Método de Pago</h2>
            <form action="<?= site_url('pago/procesar') ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="metodo_pago">Método de Pago:</label>
                    <select name="metodo_pago" id="metodo_pago" class="form-control" required>
                        <option value="TARJETA">Escoja Una</option>
                        <option value="TRANSFERENCIA">Transferencia Bancaria</option>
                        <option value="QR">QR</option>
                    </select>
                </div>

                <div id="informacion_pago" style="display:none;">
                    <div id="info_transferencia" style="display:none;">
                        <h3>Datos para Transferencia Bancaria</h3>
                        <?php if ($transferencia): ?>
                            <?= $transferencia['Contenido']; ?>
                        <?php else: ?>
                            <p>No se encontraron datos de transferencia bancaria.</p>
                        <?php endif; ?>
                    </div>

                    <div id="info_qr" style="display:none;">
                        <h3>Código QR</h3>
                        <?php if ($qr): ?>
                            <img src="<?= $qr['Imagen']; ?>" alt="Código QR" style="width:200px; height:200px;">
                            <p>Escanea este código con tu app bancaria.</p>
                        <?php else: ?>
                            <p>No se encontró el código QR.</p>
                        <?php endif; ?>
                    </div>


                    <div id="comprobante" style="display:none;">
                        <label for="comprobante">Subir Comprobante:</label>
                        <input type="file" name="comprobante" class="form-control-file" accept=".jpg,.jpeg,.png,.pdf"
                            required>
                    </div>
                </div>

                <input type="hidden" name="id_compra" value="<?php echo ($ID); ?>">
                <button type="submit" class="mt-3">Procesar Pago</button>
            </form>
            <br>
            <br><br>
            <br>
        </div>
       
    </div>

    <script>
        document.querySelector('#metodo_pago').addEventListener('change', function () {
            var metodo = this.value;
            var informacionPago = document.getElementById('informacion_pago');
            var transferencia = document.getElementById('info_transferencia');
            var qr = document.getElementById('info_qr');
            var comprobante = document.getElementById('comprobante');

            informacionPago.style.display = 'block';

            if (metodo === 'TRANSFERENCIA') {
                transferencia.style.display = 'block';
                qr.style.display = 'none';
                comprobante.style.display = 'block';
            } else if (metodo === 'QR') {
                transferencia.style.display = 'none';
                qr.style.display = 'block';
                comprobante.style.display = 'block';
            } else {
                transferencia.style.display = 'none';
                qr.style.display = 'none';
                comprobante.style.display = 'none';
            }
        });
    </script>
</body>