<?php
function calcularDistancia($lat1, $lon1, $lat2, $lon2)
{
    $radioTierra = 6371;
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);

    $a = sin($dLat / 2) * sin($dLat / 2) +
        cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
        sin($dLon / 2) * sin($dLon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    return $radioTierra * $c;
}
?>
<style>
    :root {
        --primary-color: #2962ff;
        --success-color: #00c853;
        --warning-color: #ffd600;
        --danger-color: #d50000;
    }

    .modal-content {
        right: 300px !important;
        max-width: 1200px;
        width: 1200px !important;
        margin: auto;
    }

    button {
        margin-top: 10px;
    }

    body {
        font-family: 'Montserrat', sans-serif;
        background-color: #f5f6fa;
    }

    .stat-card {
        border-radius: 15px;
        border: none;
        transition: all 0.3s ease;
        background: white;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .order-cards {
        border-radius: 12px;
        border: black;
        background: white;
        width: 30%;

    }

    .order-cards:hover {
        background: var(---primary-color);
    }

    .status-indicator {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 5px;
    }

    .status-preparando {
        background-color: var(--warning-color);
    }

    .status-transito {
        background-color: var(--primary-color);
    }

    .status-entregado {
        background-color: var(--success-color);
    }

    .product-image {
        width: 60px;
        height: 60px;
        border-radius: 8px;
        object-fit: cover;
    }

    .custom-modal {
        font-family: 'Inter', sans-serif;
    }

    .progress-shipping {
        position: relative;
        height: 8px;
        background: #e9ecef;
        border-radius: 4px;
        margin: 2rem 0;
    }

    .progress-bar-shipping {
        position: absolute;
        height: 100%;
        background: linear-gradient(90deg, #4CAF50, #8BC34A);
        border-radius: 4px;
        transition: width 0.3s ease;
    }

    .shipping-step {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
    }

    .step-number {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .step-active .step-number {
        background: #4CAF50;
        color: white;
    }

    .form-floating {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .form-control:focus {
        border-color: #4CAF50;
        box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.25);
    }

    .cost-preview {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 8px;
        margin-top: 1rem;
    }

    .shipping-map {
        height: 200px;
        background: #f8f9fa;
        border-radius: 8px;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-confirm {
        background: #4CAF50;
        border: none;
        padding: 0.8rem 1.5rem;
        transition: all 0.3s ease;
    }

    .btn-confirm:hover {
        background: #43A047;
        transform: translateY(-1px);
    }

    .floating-alert {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1060;
        animation: slideIn 0.3s ease;
    }

    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
</style>

<div class="container-fluid py-4">
    <div class="">
        <div class="">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <?php if (!empty($envios)): ?>
                        <?php foreach ($envios as $envio): ?>
                            <div class="order-cards p-3 col-12 col-sm-6 col-md-4 m-1" data-bs-toggle="modal"
                                data-bs-target="#orderModal_<?= $envio['ID_Compra'] ?>" style="cursor: pointer;">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="mb-0">
                                        <span
                                            class="status-indicator status-<?= strtolower(str_replace(' ', '', $envio['Estado'])) ?>"></span>
                                        Pedido

                                    </h6>
                                    <span
                                        class="badge bg-<?= $envio['Estado'] === 'PREPARANDO' ? 'warning' : ($envio['Estado'] === 'EN TRÁNSITO' ? 'primary' : 'success') ?>">
                                        <?= $envio['Estado'] ?>
                                    </span>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">

                                        <div class="d-flex mb-2">
                                            <div class="me-3">
                                                <i class="ri-map-pin-line text-danger ri-lg"></i>
                                            </div>
                                            <div>
                                                <small class="text-muted">Entregar en</small>
                                                <!-- <p class="mb-0"><?= $envio['Direccion_Destino'] ?></p> -->
                                                <small class="text-muted"><?= $envio['Comunidad'] ?></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex flex-column align-items-end">
                                            <small class="text-muted"><?= count($envio['productos']) ?> productos</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <?php
                                        $shown = 0;
                                        foreach ($envio['productos'] as $producto):
                                            if ($shown < 5):
                                                ?>
                                                <img src="<?= base_url($producto['Imagen_URL']) ?>" class="product-image"
                                                    alt="<?= $producto['Producto'] ?>" data-bs-toggle="tooltip"
                                                    title="<?= $producto['Producto'] ?>">
                                                <?php
                                                $shown++;
                                            endif;
                                        endforeach;
                                        if (count($envio['productos']) > 5): ?>
                                            <div class="stats-icon bg-light text-primary">+<?= count($envio['productos']) - 5 ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No hay envíos para mostrar.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Modal para cada envío -->
        <?php foreach ($envios as $envio): ?>
            <div class="modal fade" id="orderModal_<?= $envio['ID_Compra'] ?>" tabindex="-1">
                <div class=" modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Detalles del Pedido <?= $envio['ID_Compra'] ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row mb-4">

                                <div class="col-md-6">
                                    <div class="card bg-light shadow-lg rounded-3">
                                        <div class="card-body">
                                            <!-- Encabezado con icono -->
                                            <div class="d-flex align-items-center mb-3">
                                                <i class="bi bi-house-door-fill text-primary fs-4 me-2"></i>
                                                <h5 class="card-title mb-0">Información de Entrega</h5>
                                            </div>
                                            <!-- Detalles de la dirección -->
                                            <div class="mb-3">
                                                <p class="mb-1">
                                                    <strong>Comunidad:</strong> <?= esc($envio['Comunidad']) ?>
                                                </p>
                                                <p class="mb-1">
                                                    <strong>Dirección:</strong> <?= esc($envio['Direccion_Destino']) ?>
                                                </p>
                                            </div>
                                            <!-- Mapa de seguimiento de envío -->
                                            <div id="map_<?= $envio['ID_Compra'] ?>_<?= $producto['ID_Producto'] ?>"
                                                class="delivery-map" data-lat="<?= esc($envio['Latitud']) ?>"
                                                data-lng="<?= esc($envio['Longitud']) ?>"
                                                data-productos='<?= json_encode($envio['productos']) ?>'>
                                            </div>

                                            <script>
                                                document.addEventListener('DOMContentLoaded', function () {
                                                    function initDeliveryMap(mapElement) {
                                                        const latPrincipal = parseFloat(mapElement.dataset.lat);
                                                        const lngPrincipal = parseFloat(mapElement.dataset.lng);
                                                        const productos = JSON.parse(mapElement.dataset.productos);

                                                        // Configuración del mapa
                                                        const map = L.map(mapElement, {
                                                            center: [latPrincipal, lngPrincipal],
                                                            zoom: 8,
                                                            zoomControl: true,
                                                            attributionControl: false
                                                        });

                                                        // Capas de mapas
                                                        const osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                                            attribution: '© OpenStreetMap contributors'
                                                        });

                                                        const stadiaLayer = L.tileLayer('https://tiles.stadiamaps.com/tiles/osm_bright/{z}/{x}/{y}{r}.png', {
                                                            attribution: '© Stadia Maps'
                                                        });

                                                        // Añadir capas
                                                        map.addLayer(osmLayer);
                                                        map.addLayer(stadiaLayer);

                                                        // Marcador de entrega principal
                                                        const principalMarker = L.marker([latPrincipal, lngPrincipal])
                                                            .addTo(map)
                                                            .bindPopup('<strong>Punto de Entrega</strong>')
                                                            .openPopup();

                                                        // Marcadores de productos
                                                        productos.forEach(producto => {
                                                            const latSecundaria = parseFloat(producto.Latitud || 0);
                                                            const lngSecundaria = parseFloat(producto.Longitud || 0);

                                                            if (latSecundaria !== 0 && lngSecundaria !== 0) {
                                                                const secondaryMarker = L.marker([latSecundaria, lngSecundaria])
                                                                    .addTo(map)
                                                                    .bindPopup(`<strong>${producto.Producto}</strong>`);

                                                                // Línea de conexión
                                                                L.polyline(
                                                                    [[latPrincipal, lngPrincipal], [latSecundaria, lngSecundaria]],
                                                                    { color: 'blue', weight: 3, dashArray: '10, 10' }
                                                                ).addTo(map);
                                                            }
                                                        });

                                                        // Ajustar mapa al contenedor
                                                        map.invalidateSize();
                                                    }

                                                    // Inicializar mapas en modales
                                                    document.querySelectorAll('.delivery-map').forEach(mapElement => {
                                                        const modalId = mapElement.closest('.modal').id;

                                                        $(`#${modalId}`).on('shown.bs.modal', () => initDeliveryMap(mapElement));
                                                    });
                                                });
                                            </script>

                                            <style>
                                                .delivery-map {
                                                    width: 100%;
                                                    height: 300px;
                                                    margin: 0;
                                                    padding: 0;
                                                    border: none;
                                                }
                                            </style>

                                        </div>
                                    </div>
                                </div>

                                <!-- Columna para acciones -->
                                <div class="col-md-6">
                                    <div class="card bg-light shadow-lg rounded-3">
                                        <div class="card-body">
                                            <!-- Encabezado con icono -->
                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                <h5 class="card-title mb-0">
                                                    <i class="bi bi-truck text-success me-2"></i> Detalles del Envío
                                                </h5>
                                                <span class="badge bg-warning text-dark">
                                                    <?= strtoupper($envio['Estado']) ?>
                                                </span>
                                            </div>
                                            <?php if ($envio['Estado'] === 'PREPARANDO'): ?>
                                                <?php
                                                $totalDistancia = 0; // Variable para acumular el total
                                                foreach ($envio['productos'] as $p):
                                                    $latProducto = isset($p['Latitud']) ? $p['Latitud'] : 0;
                                                    $lngProducto = isset($p['Longitud']) ? $p['Longitud'] : 0;
                                                    $distancia = calcularDistancia($envio['Latitud'], $envio['Longitud'], $latProducto, $lngProducto);
                                                    $totalDistancia += $distancia; ?>
                                                <?php endforeach; ?>
                                                <form id="shippingForm" action="<?= base_url('envios/asignar') ?>"
                                                    method="POST">
                                                    <input type="hidden" name="id_compra" value="<?= $envio['ID_Compra'] ?>">

                                                    <div class="mb-3">
                                                        <label for="transporte_id" class="form-label">
                                                            <i class="bi bi-truck-front me-1"></i> Seleccionar Transporte
                                                        </label>
                                                        <select name="transporte_id" class="form-select" required>
                                                            <?php foreach ($transportes as $transporte): ?>
                                                                <option value="<?= $transporte['ID'] ?>">
                                                                    <?= $transporte['Tipo'] ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>

                                                    <!-- Distancia Total -->
                                                    <div class="mb-3">
                                                        <h6 class="mb-1"><i class="bi bi-geo-alt-fill me-1"></i> Distancia
                                                            Total:</h6>
                                                        <div class="d-flex align-items-center">
                                                            <span class="badge bg-primary fs-6 p-2">
                                                                <?= number_format($totalDistancia, 2) ?> KM
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <!-- Costo de Envío -->
                                                    <div class="form-floating mb-3">
                                                        <input type="hidden" class="form-control" id="distancia"
                                                            name="distancia" value=" <?= number_format($totalDistancia, 2) ?>"
                                                            required>

                                                    </div>
                                                    <!-- Costo de Envío -->
                                                    <div class="form-floating mb-3">
                                                        <input type="number" class="form-control" id="costo_envio"
                                                            name="costo_envio" required>
                                                        <label for="costo_envio">
                                                            <i class="bi bi-cash-coin me-1"></i> Costo de Envío
                                                        </label>
                                                    </div>

                                                    <div class="text-end">
                                                        <button type="submit" class="btn btn-success">
                                                            <i class="bi bi-check-circle me-1"></i> Realizar Envío
                                                        </button>
                                                    </div>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive card bg-light shadow-lg rounded-3">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Direccion</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach ($envio['productos'] as $producto): ?>
                                            <?php
                                            $latProducto = isset($producto['Latitud']) ? $producto['Latitud'] : 0;
                                            $lngProducto = isset($producto['Longitud']) ? $producto['Longitud'] : 0;
                                            $distancia = calcularDistancia($envio['Latitud'], $envio['Longitud'], $latProducto, $lngProducto);
                                            ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="<?= base_url($producto['Imagen_URL']) ?>"
                                                            class="product-image me-2" alt="<?= esc($producto['Producto']) ?>">
                                                        <div>
                                                            <p class="mb-0"><?= esc($producto['Producto']) ?></p>
                                                            <small class="text-muted">Cantidad:
                                                                <?= $producto['Cantidad'] ?></small>

                                                        </div>
                                                    </div>
                                                </td>
                                                <td><?= esc($producto['Comunidad_Artesano']) ?> <br>
                                                    <?= esc($producto['Direccion']) ?> <br>
                                                    <?= number_format($distancia, 2) ?> KM. </td>
                                               

                                            </tr>

                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>