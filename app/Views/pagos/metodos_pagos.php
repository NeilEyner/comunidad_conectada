<!DOCTYPE html>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.js"></script>
    <style>
        #map {
            height: 300px;
        }

        .product-img {
            object-fit: cover;
        }

        .status-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 1rem;
            font-size: 0.875rem;
        }

        .delivery-timeline {
            position: relative;
            padding-left: 2rem;
        }

        .delivery-timeline::before {
            content: '';
            position: absolute;
            left: 0.5rem;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #e9ecef;
        }

        .timeline-item {
            position: relative;
            padding-bottom: 1.5rem;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -1.5rem;
            top: 0.25rem;
            width: 1rem;
            height: 1rem;
            border-radius: 50%;
            background: #fff;
            border: 2px solid #198754;
        }
    </style>
</head>

<body>
    <div class="mt-4 mx-3">
        <div class="row g-2">
            <!-- Left Column: Cart Items -->
            <div class="col-lg-5">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
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
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $total = 0; ?>
                                    <?php foreach ($productos as $prod):
                                        ?>
                                        <tr>
                                            <td class="d-flex align-items-center">
                                                <img src="<?= base_url($prod['Imagen_URL']) ?>"
                                                    class="rounded me-3 product-img" style="width: 60px; height: 60px;"
                                                    alt="Producto">
                                                <div>
                                                    <h6 class="mb-1"><?= $prod['Nombre'] ?></h6>
                                                    <small class="text-muted">
                                                        <i class="ri-price-tag-3-line"></i>
                                                        Bs.<?= number_format($prod['Precio'], 2) ?>
                                                    </small>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="form-control-sm text-center"><?= $prod['Cantidad'] ?> </p>
                                            </td>
                                            <td class="fw-bold">Bs.<?= number_format($prod['Cantidad']*$prod['Precio'] , 2) ?></td>

                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-between border-top pt-3">
                            <h5>Total Productos</h5>
                            <h5>Bs.<?= number_format($prod['Total'] , 2) ?></h5>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h4>Total a Pagar</h4>
                            <h4 id="total_pagar">Bs.<?= number_format($prod['Total'] , 2) ?></h4>
                        </div>
                    </div>
                </div>

                <!-- Delivery Status Timeline -->
                <!-- <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">Estado del Envío</h4>
                    </div>
                    <div class="card-body">
                        <div class="delivery-timeline">
                            <div class="timeline-item">
                                <h6 class="mb-1">Preparando</h6>
                                <small class="text-muted">Tu pedido está siendo preparado</small>
                            </div>
                            <div class="timeline-item">
                                <h6 class="mb-1">En Tránsito</h6>
                                <small class="text-muted">El pedido está en camino</small>
                            </div>
                            <div class="timeline-item">
                                <h6 class="mb-1">Entregado</h6>
                                <small class="text-muted">Pedido entregado con éxito</small>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
            <br>
            <!-- Right Column: Delivery Options -->
            <div class="col-lg-7">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">Opciones de Envío</h4>
                    </div>
                    <div class="card-body">
                        <form action="<?= site_url('pago/procesar/') . $ID ?>" method="post"
                            enctype="multipart/form-data">
                            <div class="row">
                                <!-- Primera columna (Comunidad de Destino y Dirección de Destino) -->
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">
                                            <i class="ri-map-pin-line"></i> Comunidad de Destino
                                        </label>
                                        <select id="Comunidad_Destino" name="Comunidad_Destino" class="form-select">
                                            <!-- Opción predeterminada si no se selecciona una comunidad -->
                                            <option value="0">Seleccione una comunidad</option>

                                            <?php foreach ($comunidades as $comunidad): ?>
                                                <option value="<?= $comunidad['ID']; ?>"
                                                    data-lat="<?= $comunidad['Latitud']; ?>"
                                                    data-lon="<?= $comunidad['Longitud']; ?>"
                                                    <?= $comunidad['ID'] == session()->get('ID_Comunidad') ? 'selected' : ''; ?>>
                                                    <?= $comunidad['Nombre']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">
                                            <i class="ri-home-line"></i> Dirección de Destino
                                        </label>
                                        <textarea id="Direccion_Destino" name="Direccion_Destino" class="form-control"
                                            rows="8" required><?= session()->get('Direccion') ?></textarea>
                                    </div>

                                </div>

                                <!-- Segunda columna (Mapa y Latitud/Longitud) -->
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="map" class="form-label d-flex align-items-center">
                                            <i class="ri-map-2-line me-2"></i> Seleccionar Ubicación
                                        </label>

                                        <!-- Mapa -->
                                        <div id="map" class="rounded-3 border border-light" style="height: 300px;">
                                        </div>

                                        <!-- Contenedor de campos para latitud y longitud -->
                                        <div class="d-flex justify-content-between mt-3">
                                            <div class="w-48">
                                                <input class="form-control form-control-sm rounded-3" type="hidden"
                                                    name="latitud" id="latitud" placeholder="Latitud" value="" readonly>
                                            </div>
                                            <div class="w-48">
                                                <input class="form-control form-control-sm rounded-3" type="hidden"
                                                    name="longitud" id="longitud" placeholder="Longitud" value=""
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="ri-bank-card-line"></i> Método de Pago
                                </label>
                                <select name="metodo_pago" id="metodo_pago" class="form-select" required>
                                    <option value="">Escoja una opción</option>
                                    <option value="TRANSFERENCIA">Transferencia Bancaria</option>
                                    <option value="QR">QR</option>
                                </select>
                            </div>

                            <div id="informacion_pago" style="display:none;">
                                <div id="info_transferencia" style="display:none;">
                                    <div class="alert alert-info">
                                        <h5><i class="ri-bank-line"></i> Datos para Transferencia</h5>
                                        <?= $transferencia ? $transferencia['Contenido'] : '<p>No disponible.</p>' ?>
                                    </div>
                                </div>

                                <div id="info_qr" style="display:none; width:50%;">
                                    <div class="alert alert-info">
                                        <h5><i class="ri-qr-code-line"></i> Código QR</h5>
                                        <?= $qr ? '<img src="' . base_url().$qr['Imagen'] . '" class="img-fluid">' : '<p>No disponible.</p>' ?>
                                    </div>
                                </div>

                                <div id="comprobante" class="mb-3">
                                    <label class="form-label">
                                        <i class="ri-file-upload-line"></i> Subir Comprobante:
                                    </label>
                                    <input type="file" name="comprobante" class="form-control"
                                        accept=".jpg,.jpeg,.png,.pdf">
                                </div>
                            </div>
                            <input type="hidden" name="id_compra" value="<?= $ID ?>">
                            <button type="submit" class="btn btn-primary w-100" onclick="exportToPDF()">
                                <i class="ri-send-plane-line"></i> Procesar Envío
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <script>
        var map = L.map('map').setView([-16.5, -68.15], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        var marker;
        map.on('click', function (e) {
            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker(e.latlng).addTo(map);
            document.getElementById('latitud').value = e.latlng.lat;
            document.getElementById('longitud').value = e.latlng.lng;
            document.getElementById('latitud').setAttribute('value', e.latlng.lat);
            document.getElementById('longitud').setAttribute('value', e.latlng.lng);
        });

        document.getElementById('metodo_pago').addEventListener('change', function () {
            const infoPago = document.getElementById('informacion_pago');
            const infoTransferencia = document.getElementById('info_transferencia');
            const infoQR = document.getElementById('info_qr');
            const comprobante = document.getElementById('comprobante');

            infoPago.style.display = this.value ? 'block' : 'none';
            infoTransferencia.style.display = this.value === 'TRANSFERENCIA' ? 'block' : 'none';
            infoQR.style.display = this.value === 'QR' ? 'block' : 'none';

            // Modificar la lógica para el comprobante
            comprobante.style.display = this.value && this.value !== 'QR' ? 'block' : 'none';
        });


        // PDF export function
        function exportToPDF() {
            const idCompra = document.querySelector('input[name="id_compra"]').value;
            const baseUrl = "<?= base_url() ?>";
            window.location.href = `${baseUrl}/pdf/exportarCompraPDF/${idCompra}`;
        }
    </script>
</body>

</html>