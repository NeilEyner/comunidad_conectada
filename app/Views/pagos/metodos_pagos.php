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
        flex-wrap: wrap;
        gap: 30px;
    }

    .column {
        flex: 1;
        min-width: 300px;
    }

    .single_shop_cart {
        font-size: 13px;
    }

    .cart_summary {
        font-size: 14px;
    }

    h6 {
        font-size: 14px;
    }
</style>

<body>
    <div class="container mt-6">
        <div class=" column shop_cart_wrap">
            <?php
            $total = 0; // Inicializa la variable total
            foreach ($carrito as $prod):
                $producto = $tieneProductoModel->ProductosDet($prod['ID_Artesano'], $prod['ID_Producto']);
                $subtotal = $producto['Precio'] * $prod['Cantidad']; // Calcula el subtotal por producto
                $total += $subtotal; // Suma el subtotal al total general
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
                        <p class="mb-0">Bs.<?= $subtotal ?></p>
                    </div>
                    <div class="col-2 text-end">
                        <p class="mb-0 text-primary distancia_calculada" id="distancia_<?= $prod['ID_Producto'] ?>">
                            Distancia: 0 km</p>
                    </div>
                </div>
            <?php endforeach; ?>


            <div class="row align-items-center py-2 mt-3 border-top">
                <div class="col-8 text-end">
                    <h5 class="m-0">Total Productos</h5>
                </div>
                <div class="col-4 text-end">
                    <p class="mb-0">Bs.<?= number_format($total, 2) ?></p> <!-- Total productos -->
                </div>
            </div>

            <!-- Mostrar el total de kilómetros -->
            <div class="row align-items-center py-2 mt-1 border-top">
                <div class="col-8 text-end">
                    <h5 class="m-0">Total Kilómetros</h5>
                </div>
                <div class="col-4 text-end">
                    <p class="mb-0" id="total_km">0 km</p> <!-- Total de kilómetros -->
                </div>
            </div>

        </div>



        <!-- Columna derecha: Selección de método de pago -->
        <div class="column">
            <h2>Opciones de Envio</h2>

            <form action="<?= site_url('envio/procesar') ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="Comunidad_Destino">Comunidad de Destino:</label>
                    <select name="Comunidad_Destino" id="Comunidad_Destino" class="form-control" required>
                        <option value="">Seleccione una comunidad</option>
                        <?php foreach ($comunidades as $comunidad): ?>
                            <option value="<?= $comunidad['ID']; ?>" data-lat="<?= $comunidad['Latitud']; ?>"
                                data-lon="<?= $comunidad['Longitud']; ?>">
                                <?= $comunidad['Nombre']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                </div>

                <div class="form-group">
                    <label for="direccion_destino">Dirección de Destino:</label>
                    <input type="text" name="direccion_destino" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="tipo_transporte">Tipo de Transporte:</label>
                    <select name="tipo_transporte" id="tipo_transporte" class="form-control" required>
                        <option value="">Seleccione el tipo de transporte</option>
                        <?php foreach ($transportes as $transporte): ?>
                            <option value="<?= $transporte['ID']; ?>"><?= $transporte['Tipo']; ?>
                                (Bs.<?= $transporte['Costo_por_km']; ?>/km)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <br>
                <br>
                <br>
                <h2>Seleccionar Método de Pago</h2>
                <div class="form-group">
                    <label for="metodo_pago">Método de Pago:</label>
                    <select name="metodo_pago" id="metodo_pago" class="form-control" required>
                        <option value="">Escoja una opción</option>
                        <option value="TRANSFERENCIA">Transferencia Bancaria</option>
                        <option value="QR">QR</option>
                    </select>
                </div>

                <div id="informacion_pago" style="display:none;">
                    <div id="info_transferencia" style="display:none;">
                        <h3>Datos para Transferencia Bancaria</h3>
                        <?= $transferencia ? $transferencia['Contenido'] : '<p>No se encontraron datos de transferencia bancaria.</p>' ?>
                    </div>

                    <div id="info_qr" style="display:none;">
                        <h3>Código QR</h3>
                        <?= $qr ? '<img src="' . $qr['Imagen'] . '" alt="Código QR" style="width:200px; height:200px;">' : '<p>No se encontró el código QR.</p>' ?>
                        <p>Escanea este código con tu app bancaria.</p>
                    </div>

                    <div id="comprobante" style="display:none;">
                        <label for="comprobante">Subir Comprobante:</label>
                        <input type="file" name="comprobante" class="form-control-file" accept=".jpg,.jpeg,.png,.pdf">
                    </div>
                </div>

                <input type="hidden" name="id_compra" value="<?= $ID ?>">
                <button type="submit" class="mt-3">Procesar Envío</button>
            </form>
            <br>
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
                informacionPago.style.display = 'none';
            }
        });
    </script>
    <script>
        // Función para convertir grados a radianes
        function toRad(value) {
            return value * Math.PI / 180;
        }

        // Función para calcular la distancia usando Haversine
        function calcularDistancia(lat1, lon1, lat2, lon2) {
            var R = 6371; // Radio de la Tierra en km
            var dLat = toRad(lat2 - lat1);
            var dLon = toRad(lon2 - lon1);
            var lat1Rad = toRad(lat1);
            var lat2Rad = toRad(lat2);

            var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.sin(dLon / 2) * Math.sin(dLon / 2) * Math.cos(lat1Rad) * Math.cos(lat2Rad);
            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            var d = R * c;
            return d.toFixed(2); // Devuelve la distancia con dos decimales
        }

        // Función para actualizar la distancia y sumar el total de km
        function actualizarDistancia() {
            var comunidadDestino = document.getElementById("Comunidad_Destino");
            var selectedComunidad = comunidadDestino.options[comunidadDestino.selectedIndex];

            var latComunidad = parseFloat(selectedComunidad.getAttribute("data-lat"));
            var lonComunidad = parseFloat(selectedComunidad.getAttribute("data-lon"));

            let totalKm = 0; // Variable para almacenar el total de kilómetros

            <?php foreach ($carrito as $prod): ?>
                var latProducto = parseFloat('<?= $prod["Latitud"] ?>');
                var lonProducto = parseFloat('<?= $prod["Longitud"] ?>');

                if (!isNaN(latComunidad) && !isNaN(lonComunidad)) {
                    var distancia = calcularDistancia(latProducto, lonProducto, latComunidad, lonComunidad);
                    totalKm += parseFloat(distancia); // Acumula la distancia
                    document.getElementById("distancia_<?= $prod['ID_Producto'] ?>").innerText = "Distancia: " + distancia + " km";
                } else {
                    document.getElementById("distancia_<?= $prod['ID_Producto'] ?>").innerText = "Distancia: 0 km";
                }
            <?php endforeach; ?>

            // Actualiza el total de kilómetros en la interfaz
            document.getElementById("total_km").innerText = totalKm.toFixed(2) + " km";
        }

        // Ejecuta la función cuando se selecciona una comunidad
        document.getElementById("Comunidad_Destino").addEventListener("change", actualizarDistancia);

    </script>

</body>