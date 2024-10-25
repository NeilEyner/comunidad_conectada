<body>
    <div class="container mt-5">
        <div class="row g-4">
            <!-- Columna izquierda: Productos en el carrito -->
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">Carrito de Compras</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Subtotal</th>
                                        <th>Distancia</th>
                                        <th>Costo Envío</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $total = 0; ?>
                                    <?php foreach ($carrito as $prod):
                                        $producto = $tieneProductoModel->ProductosDet($prod['ID_Artesano'], $prod['ID_Producto']);
                                        $subtotal = $producto['Precio'] * $prod['Cantidad'];
                                        $total += $subtotal;
                                        ?>
                                        <tr data-lat="<?= $prod['Latitud'] ?>" data-lon="<?= $prod['Longitud'] ?>"
                                            id="producto_<?= $prod['ID_Producto'] ?>">
                                            <td class="d-flex align-items-center">
                                                <img src="<?= base_url($producto['Imagen_URL']) ?>" class="rounded me-3"
                                                    style="width: 60px; height: 60px;" alt="Producto">
                                                <div>
                                                    <h6 class="mb-1"><?= $producto['Nombre'] ?></h6>
                                                    <small
                                                        class="text-muted">Bs.<?= number_format($producto['Precio'], 2) ?></small>
                                                </div>
                                            </td>
                                            <td><?= $prod['Cantidad'] ?></td>
                                            <td class="fw-bold">Bs.<?= number_format($subtotal, 2) ?></td>
                                            <td class="distancia_calculada">0 km</td>
                                            <td class="costo_envio">Bs.0.00</td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-between border-top pt-3">
                            <h5>Total Productos</h5>
                            <h5>Bs.<?= number_format($total, 2) ?></h5>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h5>Costo Envío Total</h5>
                            <h5 id="costo_envio_total">Bs.0.00</h5>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h4>Total a Pagar</h4>
                            <h4 id="total_pagar">Bs.<?= number_format($total, 2) ?></h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Columna derecha: Opciones de Envío y Pago -->
            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">Opciones de Envío</h4>
                    </div>
                    <div class="card-body">
                        <form action="<?= site_url('pago/procesar') ?>" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="Comunidad_Destino" class="form-label">Comunidad de Destino</label>
                                <select id="Comunidad_Destino" name="Comunidad_Destino" class="form-select">
                                    <option value="">Seleccione una comunidad</option>
                                    <?php foreach ($comunidades as $comunidad): ?>
                                        <option value="<?= $comunidad['ID']; ?>" data-lat="<?= $comunidad['Latitud']; ?>"
                                            data-lon="<?= $comunidad['Longitud']; ?>">
                                            <?= $comunidad['Nombre']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="Direccion_Destino" class="form-label">Dirección de Destino</label>
                                <input type="text" id="Direccion_Destino" name="Direccion_Destino" class="form-control"
                                    required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="tipo_transporte" class="form-label">Tipo de Transporte</label>
                                <select id="tipo_transporte" name="tipo_transporte" class="form-select">
                                    <option value="">Seleccione el tipo de transporte</option>
                                    <?php foreach ($transportes as $transporte): ?>
                                        <option value="<?= $transporte['ID']; ?>"
                                            data-costo="<?= $transporte['Costo_por_km']; ?>">
                                            <?= $transporte['Tipo']; ?> (Bs.<?= $transporte['Costo_por_km']; ?>/km)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <input type="hidden" name="costo_envio" id="costo_envio" value="0.00">

                            <div class="mb-3">
                                <label for="metodo_pago" class="form-label">Método de Pago</label>
                                <select name="metodo_pago" id="metodo_pago" class="form-select" required>
                                    <option value="">Escoja una opción</option>
                                    <option value="TRANSFERENCIA">Transferencia Bancaria</option>
                                    <option value="QR">QR</option>
                                </select>
                            </div>

                            <div id="informacion_pago" style="display:none;">
                                <div id="info_transferencia" style="display:none;">
                                    <h5>Datos para Transferencia Bancaria</h5>
                                    <?= $transferencia ? $transferencia['Contenido'] : '<p>No disponible.</p>' ?>
                                </div>

                                <div id="info_qr" style="display:none;">
                                    <h5>Código QR</h5>
                                    <?= $qr ? '<img src="' . $qr['Imagen'] . '" style="width:200px;">' : '<p>No disponible.</p>' ?>
                                </div>

                                <div id="comprobante" style="display:none;">
                                    <label for="comprobante">Subir Comprobante:</label>
                                    <input type="file" name="comprobante" class="form-control"
                                        accept=".jpg,.jpeg,.png,.pdf">
                                </div>
                            </div>
                            <!-- <input type="hidden" name="id_compra" value="<?php echo ($ID); ?>"> -->

                            <input type="hidden" name="id_compra" value="<?= $ID ?>">
                            <button type="submit" class="btn btn-primary w-100 mt-3">Procesar Envío</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br><br>


</body>

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
            informacionPago.style.display = 'none';
        }
    });

    function toRad(value) {
        return value * Math.PI / 180;
    }

    function calcularDistancia(lat1, lon1, lat2, lon2) {
        const R = 6371; // Radio de la Tierra en km
        const dLat = toRad(lat2 - lat1);
        const dLon = toRad(lon2 - lon1);
        const a = Math.sin(dLat / 2) ** 2 +
            Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) *
            Math.sin(dLon / 2) ** 2;
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return R * c;
    }

    function actualizarTotales() {
        let totalEnvio = 0;
        document.querySelectorAll(".costo_envio").forEach(costo => {
            totalEnvio += parseFloat(costo.innerText.replace("Bs.", "")) || 0;
        });

        const totalProductos = <?= $total ?>;
        const totalPagar = totalProductos + totalEnvio;

        document.getElementById("costo_envio_total").innerText = `Bs.${totalEnvio.toFixed(2)}`;
        document.getElementById("costo_envio").value = totalEnvio.toFixed(2);
        document.getElementById("total_pagar").innerText = `Bs.${totalPagar.toFixed(2)}`;
    }

    function calcularYMostrarDistanciaPorProducto() {
        const comunidadDestino = document.getElementById("Comunidad_Destino").selectedOptions[0];
        const latDestino = parseFloat(comunidadDestino.getAttribute("data-lat")) || 0;
        const lonDestino = parseFloat(comunidadDestino.getAttribute("data-lon")) || 0;

        const transporte = document.getElementById("tipo_transporte").selectedOptions[0];
        const costoPorKm = parseFloat(transporte.getAttribute("data-costo")) || 0;

        document.querySelectorAll("tbody tr").forEach(producto => {
            const latOrigen = parseFloat(producto.getAttribute("data-lat")) || 0;
            const lonOrigen = parseFloat(producto.getAttribute("data-lon")) || 0;

            if (latOrigen && lonOrigen) {
                const distancia = calcularDistancia(latOrigen, lonOrigen, latDestino, lonDestino).toFixed(2);
                const costoEnvio = (distancia * costoPorKm).toFixed(2);

                producto.querySelector(".distancia_calculada").innerText = `${distancia} km`;
                producto.querySelector(".costo_envio").innerText = `Bs.${costoEnvio}`;
            }
        });

        actualizarTotales();
    }

    // Eventos de cambio
    document.getElementById("Comunidad_Destino").addEventListener("change", calcularYMostrarDistanciaPorProducto);
    document.getElementById("tipo_transporte").addEventListener("change", calcularYMostrarDistanciaPorProducto);

</script>