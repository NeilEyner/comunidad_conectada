<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<?php
function calcularDistancia($lat1, $lon1, $lat2, $lon2)
{
    $radioTierra = 6371; // Radio de la Tierra en kilómetros
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);

    $a = sin($dLat / 2) * sin($dLat / 2) +
        cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
        sin($dLon / 2) * sin($dLon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

    return $radioTierra * $c; // Distancia en kilómetros
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
        right: 200px !important;
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

    /* Aseguramos que la fila sea un contenedor flexible */


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

    .order-progress {
        height: 8px;
        border-radius: 4px;
        background-color: #e0e0e0;
        margin: 1rem 0;
    }

    .progress-bar {
        border-radius: 4px;
    }

    .step-indicator {
        display: flex;
        justify-content: center;
        margin-bottom: 2rem;
    }

    .step-indicator .step {
        width: 40px;
        height: 40px;
        background-color: #f5f6fa;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0 1rem;
        position: relative;
    }

    .step-indicator .step.completed {
        background-color: var(--success-color);
        color: white;
    }

    .step-indicator .step.active {
        background-color: var(--primary-color);
        color: white;
    }

    .step-indicator .step::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 100%;
        transform: translateY(-50%);
        width: 100px;
        height: 2px;
        background-color: #e0e0e0;
    }

    .step-indicator .step:last-child::after {
        display: none;
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
                                            <p class="mb-0"><?= $envio['Costo_envio'] ?> Bs.</p>
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
                                        if (count($envio['productos']) > 5):
                                            ?>
                                            <div class="stats-icon bg-light text-primary">+<?= count($envio['productos']) - 5 ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="action-buttons text-end mt-3">
                                    <?php if ($envio['Estado'] === 'PREPARANDO'): ?>
                                        <form action="<?= base_url('envios/asignar') ?>" method="POST">
                                            <input type="hidden" name="id_compra" value="<?= $envio['ID_Compra'] ?>">
                                            <button type="submit" class="btn btn-primary btn-lg">
                                                <i class="ri-bike-line me-1"></i>Aceptar Envío
                                            </button>
                                        </form>
                                    <?php elseif ($envio['Estado'] === 'EN TRÁNSITO'): ?>
                                        <form action="<?= base_url('envios/entregado') ?>" method="POST">
                                            <input type="hidden" name="id_compra" value="<?= $envio['ID_Compra'] ?>">
                                            <button type="submit"
                                                class="btn btn-outline-success btn-lg d-flex align-items-center justify-content-center rounded-pill px-4 py-2 fw-bold">
                                                <i class="ri-check-line me-2"></i>Confirmar Entrega
                                            </button>
                                        </form>

                                    <?php endif; ?>
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
                                            <div class="d-flex align-items-center mb-3">
                                                <i class="bi bi-house-door-fill text-primary fs-4 me-2"></i>
                                                <h5 class="card-title mb-0">Información de Entrega</h5>
                                            </div>
                                            <div class="mb-3">
                                                <p class="mb-1">
                                                    <strong>Comunidad:</strong> <?= esc($envio['Comunidad']) ?>
                                                </p>
                                                <p class="mb-1">
                                                    <strong>Dirección:</strong> <?= esc($envio['Direccion_Destino']) ?>
                                                </p>
                                            </div>
                                            <button type="button" class="btn btn-outline-primary btn-sm w-100"
                                                data-bs-toggle="modal"
                                                data-bs-target="#mapModal_<?= $envio['ID_Compra'] ?>_<?= $producto['ID_Producto'] ?>">
                                                <i class="bi bi-map-fill me-1"></i> Ver Ubicación en el Mapa
                                            </button>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="card bg-light shadow-lg rounded-3">
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
                                                        zoom: 9,
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


                            <div class="table-responsive card bg-light shadow-lg rounded-3">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Direccion</th>
                                            <th>Estado</th>
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
                                                            class="product-image me-2" alt="<?= esc($producto['Producto']) ?>"
                                                            onerror="this.src='/api/placeholder/60/60'">
                                                        <div>
                                                            <p class="mb-0"><?= esc($producto['Producto']) ?></p>
                                                            <small class="text-muted">Cantidad:
                                                                <?= $producto['Cantidad'] ?></small>

                                                        </div>
                                                    </div>
                                                </td>
                                                <td><?= esc($producto['Comunidad_Artesano']) ?> <br>
                                                    <?= esc($producto['Direccion']) ?>
                                                    <small><?= number_format($distancia, 2) ?> Km</small><br>
                                                </td>
                                                <td>
                                                    <?php
                                                    $estado = esc($producto['Estado']);
                                                    $estadoIcono = '';
                                                    $estadoClass = '';

                                                    switch ($estado) {
                                                        case 'PREPARANDO':
                                                            $estadoIcono = 'ri-loader-2-line';
                                                            $estadoClass = 'btn-warning';
                                                            break;
                                                        case 'RECOGIDO':
                                                            $estadoIcono = 'ri-truck-line';
                                                            $estadoClass = 'btn-primary';
                                                            break;
                                                        case 'EN TRÁNSITO':
                                                            $estadoIcono = 'ri-road-line';
                                                            $estadoClass = 'btn-info';
                                                            break;
                                                        case 'ENTREGADO':
                                                            $estadoIcono = 'ri-check-line';
                                                            $estadoClass = 'btn-success';
                                                            break;
                                                    }
                                                    ?>

                                                    <!-- Estado actual -->
                                                    <span class="btn <?= $estadoClass ?> btn-sm">
                                                        <i class="ri <?= $estadoIcono ?>"></i> <?= $estado ?>
                                                    </span>

                                                    <!-- Enlaces para cambiar el estado -->
                                                    <div class="btn-group mt-2">
                                                        <a href="<?= base_url('producto/cambiarEstado/' . $producto['ID_Producto'] .'/'. $producto['ID_Compra']. '/PREPARANDO') ?>"
                                                            class="btn btn-outline-warning btn-sm">
                                                            PREPARANDO
                                                        </a>
                                                        <a href="<?= base_url('producto/cambiarEstado/' . $producto['ID_Producto'] .'/'. $producto['ID_Compra']. '/RECOGIDO') ?>"
                                                            class="btn btn-outline-primary btn-sm">
                                                            RECOGIDO
                                                        </a>
                                                        <a href="<?= base_url('producto/cambiarEstado/' . $producto['ID_Producto'] .'/'. $producto['ID_Compra']. '/ENTRANSITO') ?>"
                                                            class="btn btn-outline-info btn-sm">
                                                            EN TRÁNSITO
                                                        </a>
                                                        <a href="<?= base_url('producto/cambiarEstado/' . $producto['ID_Producto'] .'/'. $producto['ID_Compra']. '/ENTREGADO') ?>"
                                                            class="btn btn-outline-success btn-sm">
                                                            ENTREGADO
                                                        </a>
                                                    </div>
                                                </td>
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