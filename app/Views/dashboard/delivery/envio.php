<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
<style>
    :root {
        --primary-color: #2962ff;
        --success-color: #00c853;
        --warning-color: #ffd600;
        --danger-color: #d50000;
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

    .order-card {
        border-radius: 12px;
        border: none;
        margin-bottom: 1rem;
        background: white;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .order-card:hover {
        transform: translateX(5px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
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
    <!-- Stats Row -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Envíos Pendientes</h6>
                            <h3 class="mb-0"><?= count($envios) ?></h3>
                            <small class="text-warning">Por Asignar</small>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded">
                            <i class="ri-truck-line text-warning ri-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">En Tránsito</h6>
                            <h3 class="mb-0">
                                <?= count(array_filter($envios, function ($e) {
                                    return $e['Estado'] === 'EN TRÁNSITO';
                                })) ?>
                            </h3>
                            <small class="text-primary">Activos</small>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <i class="ri-road-map-line text-primary ri-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Entregados Hoy</h6>
                            <h3 class="mb-0">
                                <?= count(array_filter($envios, function ($e) {
                                    return $e['Estado'] === 'ENTREGADO' && date('Y-m-d', strtotime($e['Fecha_Entrega'])) === date('Y-m-d');
                                })) ?>
                            </h3>
                            <small class="text-success">Completados</small>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <i class="ri-check-double-line text-success ri-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Ganancias Hoy</h6>
                            <h3 class="mb-0">
                                Bs. <?= number_format(array_sum(array_column($envios, 'Costo_envio')), 2) ?></h3>
                            <small class="text-success">Por Envíos</small>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded">
                            <i class="ri-money-dollar-circle-line text-info ri-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Envíos Section -->
    <div class="row">
        <div class="">
            <div class="">
                <div class="card-body">
                    <?php foreach ($envios as $envio): ?>
                        <div class="order-card p-3" data-bs-toggle="modal"
                            data-bs-target="#orderModal_<?= $envio['ID_Compra'] ?>" style="cursor: pointer;">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0">
                                    <span
                                        class="status-indicator status-<?= strtolower(str_replace(' ', '', $envio['Estado'])) ?>"></span>
                                    Pedido #<?= $envio['ID_Compra'] ?>
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
                                            <i class="ri-store-2-line text-primary ri-lg"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted">Recoger en</small>
                                            <p class="mb-0"><?= $envio['productos'][0]['Comunidad_Artesano'] ?></p>
                                        </div>
                                    </div>
                                    <div class="d-flex mb-2">
                                        <div class="me-3">
                                            <i class="ri-map-pin-line text-danger ri-lg"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted">Entregar en</small>
                                            <p class="mb-0"><?= $envio['Direccion_Destino'] ?></p>
                                            <small class="text-muted"><?= $envio['Comunidad'] ?></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex flex-column align-items-end">
                                        <div class="mb-2">
                                            <span class="badge bg-info"><?= $envio['Tipo'] ?></span>
                                            <span
                                                class="badge bg-warning ms-1">$<?= number_format($envio['Costo_envio'], 2) ?></span>
                                        </div>
                                        <small class="text-muted"><?= count($envio['productos']) ?> productos</small>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex align-items-center gap-2">
                                    <?php
                                    $shown = 0;
                                    foreach ($envio['productos'] as $producto):
                                        if ($shown < 5):  // Solo mostrar los primeros 5 productos
                                            ?>
                                            <img src="<?= base_url($producto['Imagen_URL']) ?>" class="product-image"
                                                alt="<?= $producto['Producto'] ?>" data-bs-toggle="tooltip"
                                                title="<?= $producto['Producto'] ?>">
                                            <?php
                                            $shown++;
                                        endif;
                                    endforeach;

                                    // Si hay más de 5 productos, mostrar el contador
                                    if (count($envio['productos']) > 5):
                                        ?>
                                        <div class="stats-icon bg-light text-primary">+<?= count($envio['productos']) - 5 ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <!-- Mostrar el total de la compra en la parte derecha -->
                                <div class="text-end">
                                    <small class="text-muted d-block">Total</small>
                                    <h4 class="mb-0 text-primary fw-bold">Bs. <?= number_format($envio['Costo_envio'], 2) ?>
                                    </h4>
                                </div>

                            </div>

                            <div class="action-buttons text-end mt-3">
                                <?php if ($envio['Estado'] === 'PREPARANDO'): ?>
                                    <button class="btn btn-primary btn-sm">
                                        <i class="ri-bike-line me-1"></i>Aceptar Envío
                                    </button>
                                <?php elseif ($envio['Estado'] === 'EN TRÁNSITO'): ?>
                                    <button class="btn btn-success btn-sm">
                                        <i class="ri-check-line me-1"></i>Confirmar Entrega
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Modal para cada envío -->
        <?php foreach ($envios as $envio): ?>
            <div class="modal fade" id="orderModal_<?= $envio['ID_Compra'] ?>" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Detalles del Pedido #<?= $envio['ID_Compra'] ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Indicador de Progreso -->
                            <div class="step-indicator mb-4">
                                <?php
                                $estados = ['PREPARANDO' => 1, 'EN TRÁNSITO' => 2, 'ENTREGADO' => 3];
                                $estadoActual = $estados[$envio['Estado'] ?? 'PREPARANDO'];
                                ?>
                                <div class="step <?= $estadoActual >= 1 ? 'completed' : '' ?>" data-bs-toggle="tooltip"
                                    title="Pedido Recibido">
                                    <i class="ri-check-line"></i>
                                </div>
                                <div class="step <?= $estadoActual >= 2 ? 'completed' : ($estadoActual == 2 ? 'active' : '') ?>"
                                    data-bs-toggle="tooltip" title="En Tránsito">
                                    <?= $estadoActual >= 2 ? '<i class="ri-check-line"></i>' : '2' ?>
                                </div>
                                <div class="step <?= $estadoActual == 3 ? 'completed' : '' ?>" data-bs-toggle="tooltip"
                                    title="Entregado">
                                    <?= $estadoActual == 3 ? '<i class="ri-check-line"></i>' : '3' ?>
                                </div>
                            </div>

                            <!-- Información del Envío -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h6>Información de Recogida</h6>
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <p class="mb-1"><strong>Comunidad:</strong> <?= esc($envio['Comunidad']) ?>
                                            </p>
                                            <p class="mb-1"><strong>Tipo de Transporte:</strong>
                                                <?= esc($envio['Tipo']) ?></p>
                                            <p class="mb-0"><strong>Distancia:</strong>
                                                <?= number_format($envio['Distancia'] ?? 0, 2) ?> km</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6>Información de Entrega</h6>
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <p class="mb-1"><strong>Dirección:</strong>
                                                <?= esc($envio['Direccion_Destino']) ?></p>
                                            <p class="mb-1"><strong>Costo de envío:</strong>
                                                Bs. <?= number_format($envio['Costo_envio'], 2) ?></p>
                                            <p class="mb-0"><strong>Fecha estimada:</strong>
                                                <?= $envio['Fecha_Envio'] ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Lista de Productos -->
                            <h6>Productos</h6>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>Comunidad Artesano</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($envio['productos'] as $producto): ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="<?= base_url($producto['Imagen_URL']) ?>"
                                                            class="product-image me-2" alt="<?= esc($producto['Producto']) ?>"
                                                            onerror="this.src='/api/placeholder/60/60'">
                                                        <div>
                                                            <p class="mb-0"><?= esc($producto['Producto']) ?></p>
                                                            <small class="text-muted">ID:
                                                                <?= $producto['ID_Producto'] ?></small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><?= $producto['Cantidad'] ?></td>
                                                <td><?= esc($producto['Comunidad_Artesano']) ?></td>
                                                <td>
                                                    <span
                                                        class="badge bg-<?= $envio['Estado'] == 'PREPARANDO' ? 'warning' : ($envio['Estado'] == 'EN TRÁNSITO' ? 'primary' : 'success') ?>">
                                                        <?= $envio['Estado'] ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Acciones de Entrega -->
                            <!-- <div class="mt-4">
                                <h6>Acciones de Entrega</h6>
                                <form action="<?= base_url('delivery/updateEstado') ?>" method="POST" class="d-flex gap-2">
                                    <input type="hidden" name="ID_Compra" value="<?= $envio['ID_Compra'] ?>">
                                    <select name="nuevo_estado" class="form-select flex-grow-1">
                                        <option value="PREPARANDO" <?= $envio['Estado'] == 'PREPARANDO' ? 'selected' : '' ?>>
                                            Preparando</option>
                                        <option value="EN TRÁNSITO" <?= $envio['Estado'] == 'EN TRÁNSITO' ? 'selected' : '' ?>>
                                            En Tránsito</option>
                                        <option value="ENTREGADO" <?= $envio['Estado'] == 'ENTREGADO' ? 'selected' : '' ?>>
                                            Entregado</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary">
                                        Actualizar Estado
                                    </button>
                                </form>
                            </div> -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <?php if ($envio['Estado'] !== 'ENTREGADO'): ?>
                                <div class="action-button mb-3">
                                    <form action="<?= base_url('envios/entregado') ?>" method="POST">
                                        <input type="hidden" name="id_compra" value="<?= $envio['ID_Compra'] ?>">
                                        <button type="submit" class="btn btn-success btn-lg px-4 shadow-sm hover-lift">
                                            <i class="fas fa-check-circle me-2"></i>
                                            Marcar como Entregado
                                        </button>
                                    </form>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <!-- Script para manejar la confirmación de entrega -->
    <script>
        function confirmarEntrega(idCompra) {
            if (confirm('¿Está seguro que desea confirmar la entrega?')) {
                fetch('<?= base_url('delivery/confirmarEntrega') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        ID_Compra: idCompra
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert('Error al confirmar la entrega');
                        }
                    });
            }
        }

        // Inicializar tooltips
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        });
    </script>