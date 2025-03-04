<style>
    :root {
        --primary-gradient: linear-gradient(95deg, #a8e063 0%, #56ab2f 100%);
        --secondary-gradient: linear-gradient(95deg, #f3f3f3 0%, #a0e9e9 100%);

    }

    .gradient-bg {
        background: var(--primary-gradient);
        color: white;
    }

    .card-hover {
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
    }

    .card-hover:hover {
        transform: translateY(-10px);
        box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
    }

    .status-badge {
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .dashboard-header {
        background: var(--secondary-gradient);
        padding: 2rem;
        border-radius: 0 0 30px 30px;
        color: white;
    }

    .envio-card {
        cursor: pointer;
        border-left: 4px solid transparent;
        transition: all 0.3s ease;
    }

    .envio-card:hover {
        border-left-color: #2575fc;
        background-color: rgba(37, 117, 252, 0.05);
    }

    .modal-custom-header {
        background: var(--primary-gradient);
        color: white;
        border-bottom: none;
    }

    .modal-custom-header .btn-close {
        filter: invert(1) grayscale(100%) brightness(200%);
    }

    .product-card {
        transition: transform 0.3s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .product-card:hover {
        transform: scale(1.05);
    }

    .modal-envio-timeline {
        position: relative;
        padding-left: 30px;
        border-left: 3px solid #e0e0e0;
    }

    .modal-envio-timeline::before {
        content: '';
        position: absolute;
        width: 20px;
        height: 20px;
        background-color: #2575fc;
        left: -12px;
        top: 0;
        border-radius: 50%;
    }

    .estado-track {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 15px;
    }

    .detalle-producto {
        transition: all 0.3s ease;
    }

    .detalle-producto:hover {
        transform: scale(1.03);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
</style>

<div class="container-fluid p-0">
    <!-- Header Dashboard -->
    <div class="dashboard-header text-center mb-4">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-start text-black">
                    <h1 class="display-6 fw-bold">
                        <i class="ri-user-line me-2"></i> Mis Envios
                    </h1>
                    <p class="lead opacity-75">Bienvenido, <?= session()->get('Nombre') ?? 'Cliente' ?></p>
                </div>
                <!-- <div>
                    <button class="btn btn-light btn-lg rounded-pill">
                        <i class="ri-settings-3-line me-2"></i> Configuración
                    </button>
                </div> -->
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Tarjetas de Resumen -->
        <!-- <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card card-hover gradient-bg">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-4">
                            <i class="ri-truck-line display-4"></i>
                        </div>
                        <div>
                            <h5 class="card-title opacity-75">Envíos Totales</h5>
                            <h2 class="fw-bold"><?= count($envios) ?></h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-hover" style="background: var(--secondary-gradient); color: white;">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-4">
                            <i class="ri-shopping-cart-line display-4"></i>
                        </div>
                        <div>
                            <h5 class="card-title opacity-75">Compras Recientes</h5>
                            <h2 class="fw-bold"><?= count($compras) ?></h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-hover gradient-bg">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-4">
                            <i class="ri-roadster-line display-4"></i>
                        </div>
                        <div>
                            <h5 class="card-title opacity-75">En Tránsito</h5>
                            <h2 class="fw-bold">
                                <?= count(array_filter($envios, function ($envio) {
                                    return $envio['Estado'] != 'Entregado';
                                })) ?>
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->

        <!-- Tabla de Envíos Mejorada -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="ri-truck-line me-2 text-primary"></i> Seguimiento de Envíos
                </h4>
                <!-- <div class="btn-group" role="group">
                    <button class="btn btn-outline-primary active">Todos</button>
                    <button class="btn btn-outline-primary">En Proceso</button>
                    <button class="btn btn-outline-primary">Entregados</button>
                </div> -->
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Compra</th>
                                <th>Destino</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($envios as $envio): ?>
                                <tr class="envio-card" data-bs-toggle="modal"
                                    data-bs-target="#envioDetalleModal<?= $envio['ID'] ?>">
                                    <td>
                                        <?php
                                        // Filtrar los productos de la compra asociada al envío
                                        $productosEnvio = array_filter($compras, function ($compra) use ($envio) {
                                            return $compra['compra_id'] == $envio['IdCompra'];
                                        });

                                        // Obtener solo los primeros 3 productos
                                        $productosEnvio = array_slice($productosEnvio, 0, 3);
                                        ?>

                                        <div class="d-flex">
                                            <?php foreach ($productosEnvio as $producto): ?>
                                                <div class="card me-2" style="width: 100px; height: 120px;">
                                                    <img src="<?= base_url() . $producto['Imagen_URL'] ?>" class="card-img-top"
                                                        alt="<?= $producto['producto_nombre'] ?>"
                                                        style="object-fit: cover; height: 80px;">
                                                    <div class="card-body p-1">
                                                        <p class="card-text text-center" style="font-size: 12px;">
                                                            <?= $producto['producto_nombre'] ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                            <?php if (count($productosEnvio)): ?>
                                                <div class="border-1 extra-products d-flex align-items-center justify-content-center position-relative bg-success-subtle"
                                                    style="width: 100px; height: 120px;">
                                                    <span class="text-black-50 fw-bold fs-4 position-absolute "
                                                        style="z-index: 1;">
                                                        + mas
                                                    </span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td><?= $envio['ComunidaDestino'] ?></td>
                                    <td><?= $envio['FechaCompra'] ?></td>
                                    <td>
                                        <span class="badge rounded-pill status-badge <?=
                                            $envio['Estado'] == 'ENTREGADO' ? 'bg-success' :
                                            ($envio['Estado'] == 'EN PROCESO' ? 'bg-warning' : 'bg-secondary')
                                            ?>">
                                            <?= $envio['Estado'] ?>
                                        </span>
                                    </td>

                                    <td>
                                        <button class="btn btn-sm btn-outline-primary rounded-pill">
                                            <i class="ri-eye-line me-1"></i> Detalles
                                        </button>
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


<?php foreach ($envios as $envio): ?>
    <div class="modal fade" id="envioDetalleModal<?= $envio['ID'] ?>" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #2575fc; color: white;">
                    <h5 class="modal-title">
                        <i class="ri-truck-line me-2"></i> Detalle de Envío #<?= $envio['ID'] ?>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Columna de Seguimiento -->
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="card-title text-muted mb-3">
                                        <i class="ri-map-pin-line me-2"></i> Información de Envío
                                    </h6>
                                    <div class="modal-envio-timeline">
                                        <div class="estado-track mb-3">
                                            <h6 class="mb-2">
                                                <i class="ri-check-line text-success me-2"></i>
                                                Pedido Confirmado
                                            </h6>
                                            <small class="text-muted">
                                                <?= $envio['Fecha_Envio'] == '0000-00-00' ? 'SIN ENVIO' : $envio['Fecha_Envio'] ?>
                                            </small>
                                        </div>
                                        <div class="estado-track mb-3">
                                            <h6 class="mb-2">
                                                <i class="ri-truck-line text-warning me-2"></i>
                                                En Tránsito
                                            </h6>
                                        </div>
                                        <div class="estado-track mb-3">
                                            <h6 class="mb-2">
                                                <?= $envio['Estado'] == 'ENTREGADO' ?
                                                    '<i class="ri-checkbox-circle-line text-success me-2"></i> Entregado' :
                                                    '<i class="ri-error-warning-line text-secondary me-2"></i> Pendiente de Entrega'
                                                    ?>
                                            </h6>
                                            <small class="text-muted">
                                                <?= $envio['Fecha_Entrega'] ?? 'Próximamente' ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card border-0 shadow-sm mt-3">
                                <div class="card-body">
                                    <h6 class="card-title text-muted mb-3">
                                        <i class="ri-roadster-line me-2"></i> Detalles de Envío
                                    </h6>
                                    <div>
                                        <p class="mb-2">
                                            <strong>Dirección:</strong>
                                            <?= $envio['Direccion_Destino'] ?>
                                        </p>
                                        <p class="mb-2">
                                            <strong>Comunidad:</strong>
                                            <?= $envio['ComunidaDestino'] ?>
                                        </p>
                                        <p class="mb-2">
                                            <strong>Transporte:</strong>
                                            <?= $envio['NombreTransporte'] ?>
                                        </p>
                                        <p class="mb-2">
                                            <strong>Costo de Envío:</strong>
                                            Bs. <?= number_format($envio['Costo_envio'], 2) ?>
                                        </p>
                                        <p class="mb-0">
                                            <strong>Delivery:</strong>
                                            <?= $envio['NombreDelivery'] ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Columna de Productos -->
                        <div class="col-md-8">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="card-title text-muted mb-3">
                                        <i class="ri-shopping-basket-line me-2"></i> Productos en este Envío
                                    </h6>
                                    <?php
                                    $productosEnvio = array_filter($compras, function ($compra) use ($envio) {
                                        return $compra['compra_id'] == $envio['IdCompra'];
                                    });
                                    ?>
                                    <div class="row g-3">
                                        <table class="table table-striped table-hover">
                                            <thead class="table">
                                                <tr>
                                                    <th>Nombre</th>
                                                    <th>Cantidad</th>
                                                    <th>Estado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($productosEnvio as $producto): ?>
                                                    <tr>
                                                        <td class="text-center">
                                                            <img src="<?= base_url() . $producto['Imagen_URL'] ?>"
                                                                alt="<?= $producto['producto_nombre'] ?>"
                                                                class="img-fluid rounded" style="max-width: 50px;">
                                                            <?= $producto['producto_nombre'] ?>
                                                        </td>
                                                        <td><?= $producto['Cantidad'] ?></td>
                                                        <td>
                                                            <span class="badge 
                                                        <?=
                                                                    $producto['Estado'] == 'PREPARANDO' ? 'bg-secondary' :
                                                                    ($producto['Estado'] == 'RECOGIDO' ? 'bg-primary' :
                                                                        ($producto['Estado'] == 'ENTRANSITO' ? 'bg-warning' :
                                                                            'bg-success'))
                                                                    ?>">
                                                                <?= $producto['Estado'] ?>
                                                            </span>

                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="card border-0 shadow-sm mt-3">
                                <div class="card-body">
                                    <h6 class="card-title text-muted mb-3">
                                        <i class="ri-calculator-line me-2"></i> Resumen de Compra
                                    </h6>
                                    <?php
                                    // Obtener el total de la primera compra relacionada
                                    $compraActual = current(array_filter($compras, function ($compra) use ($envio) {
                                        return $compra['compra_id'] == $envio['IdCompra'];
                                    }));
                                    ?>
                                    <div class="d-flex justify-content-between">
                                        <span>Total de Productos:</span>
                                        <strong>Bs. <?= number_format($compraActual['Total'], 2) ?></strong>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>Costo de Envío:</span>
                                        <strong>Bs. <?= number_format($envio['Costo_envio'], 2) ?></strong>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between fw-bold">
                                        <span>Total Final:</span>
                                        <strong>
                                            Bs. <?= number_format($compraActual['Total'] + $envio['Costo_envio'], 2) ?>
                                        </strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cerrar
                    </button>
                    <!-- <button type="button" class="btn btn-primary">
                        <i class="ri-customer-service-2-line me-2"></i> Contactar Soporte
                    </button> -->
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>