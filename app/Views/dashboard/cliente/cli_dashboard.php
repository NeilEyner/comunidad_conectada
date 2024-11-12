<!-- Dashboard de Compras -->
<div class="container py-5">
    <!-- Header con estadísticas -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card stats-card bg-primary text-white animate-hover">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-2">Total Compras</h6>
                            <h3 class="mb-0 fw-bold">Bs.
                                <?= number_format(array_sum(array_column($compras, 'Total')), 2) ?>
                            </h3>
                            <small class="text-white-50">Total histórico</small>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-shopping-cart fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stats-card bg-success text-white animate-hover">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-2">Entregados</h6>
                            <h3 class="mb-0 fw-bold">
                                <?= count(array_filter($compras, function ($c) {
                                    return $c->Estado === 'ENTREGADO';
                                })) ?>
                            </h3>
                            <small class="text-white-50">Pedidos completados</small>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-check-circle fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stats-card bg-warning animate-hover">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-2 text-dark">En Proceso</h6>
                            <h3 class="mb-0 fw-bold text-dark">
                                <?= count(array_filter($compras, function ($c) {
                                    return $c->Estado === 'EN PROCESO';
                                })) ?>
                            </h3>
                            <small class="text-dark">Pedidos activos</small>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-truck fa-lg text-dark"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stats-card bg-info text-white animate-hover">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-2">Productos</h6>
                            <h3 class="mb-0 fw-bold">
                                <?= array_sum(array_column($detalles, 'Cantidad')) ?>
                            </h3>
                            <small class="text-white-50">Items comprados</small>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-box fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <!-- <div class="card filter-card shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label text-muted small mb-1">Buscar pedido</label>
                    <div class="input-group">
                        <span class="input-group-text bg-primary text-white">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" class="form-control" placeholder="Número de orden..." id="searchOrder">
                    </div>
                </div>
                
                <div class="col-md-4">
                    <label class="form-label text-muted small mb-1">Estado</label>
                    <div class="input-group">
                        <span class="input-group-text bg-primary text-white">
                            <i class="fas fa-filter"></i>
                        </span>
                        <select class="form-select" id="statusFilter">
                            <option value="" selected>Todos los estados</option>
                            <option value="PENDIENTE">Pendiente</option>
                            <option value="EN PROCESO">En proceso</option>
                            <option value="ENVIADO">Enviado</option>
                            <option value="ENTREGADO">Entregado</option>
                            <option value="CANCELADO">Cancelado</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <label class="form-label text-muted small mb-1">Fecha</label>
                    <div class="input-group">
                        <span class="input-group-text bg-primary text-white">
                            <i class="fas fa-calendar"></i>
                        </span>
                        <input type="date" class="form-control" id="dateFilter">
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <!-- Lista de Órdenes -->
    <div class="row g-4" id="ordersList">
        <?php foreach ($compras as $index => $compra):
            // Obtener los detalles de esta compra
            $compraDetalles = array_filter($detalles, function ($d) use ($compra) {
                return $d->ID_Compra === $compra->ID;
            });

            // Obtener el envío de esta compra si existe
            $compraEnvio = array_filter($envios, function ($e) use ($compra) {
                return $e->ID_Compra === $compra->ID;
            });
            $compraEnvio = !empty($compraEnvio) ? reset($compraEnvio) : null;
            ?>
            <div class="col-md-6 animate-slide-in" style="animation-delay: <?= $index * 0.1 ?>s">
                <div class="card cart-card shadow-sm animate-hover" data-bs-toggle="modal"
                    data-bs-target="#cartModal<?= $compra->ID ?>">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon <?= getStatusColor($compra->Estado) ?> me-3">
                                    <i class="fas fa-shopping-bag"></i>
                                </div>
                                <div>
                                    <h5 class="card-title mb-0 fw-bold">Orden #<?= $compra->ID ?></h5>
                                    <small class="text-muted"><?= date('d/m/Y - H:i', strtotime($compra->Fecha)) ?></small>
                                </div>
                            </div>
                            <span class="badge <?= getStatusBadgeColor($compra->Estado) ?> status-badge">
                                <i class="<?= getStatusIcon($compra->Estado) ?> me-1"></i>
                                <?= $compra->Estado ?>
                            </span>
                        </div>

                        <div class="row mb-3">
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-box text-primary me-2"></i>
                                    <span><?= count($compraDetalles) ?> productos</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-truck text-primary me-2"></i>
                                    <span><?= $compraEnvio ? 'Envío: Bs. ' . number_format($compraEnvio->Costo_envio, 2) : 'Sin envío' ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center gap-2">
                                <?php
                                $shown = 0;
                                foreach ($compraDetalles as $detalle):
                                    if ($shown < 5):
                                        ?>
                                        <img src="<?= base_url() . $detalle->Imagen_URL ?>" class="product-image"
                                            alt="<?= $detalle->Nombre ?>" data-bs-toggle="tooltip" title="<?= $detalle->Nombre ?>">
                                        <?php
                                        $shown++;
                                    endif;
                                endforeach;

                                if (count($compraDetalles) > 5):
                                    ?>
                                    <div class="stats-icon bg-light text-primary">+<?= count($compraDetalles) - 5 ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="text-end">
                                <small class="text-muted d-block">Total</small>
                                <h4 class="mb-0 text-primary fw-bold">Bs. <?= number_format($compra->Total, 2) ?></h4>
                            </div>
                        </div>

                        <div class="progress">
                            <div class="progress-bar <?= getProgressBarColor($compra->Estado) ?>"
                                style="width: <?= getProgressWidth($compra->Estado) ?>%" role="progressbar"
                                aria-valuenow="<?= getProgressWidth($compra->Estado) ?>" aria-valuemin="0"
                                aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal de Detalles -->
            <div class="modal fade" id="cartModal<?= $compra->ID ?>" tabindex="-1"
                aria-labelledby="cartModal<?= $compra->ID ?>Label" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="cartModal<?= $compra->ID ?>Label">
                                Orden #<?= $compra->ID ?>
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h6 class="fw-bold">Información de la Orden</h6>
                                    <p><strong>Fecha:</strong> <?= date('d/m/Y - H:i', strtotime($compra->Fecha)) ?></p>
                                    <p><strong>Estado:</strong>
                                        <span class="badge rounded-pill <?= getStatusBadgeColor($compra->Estado) ?>">
                                            <?= $compra->Estado ?>
                                        </span>
                                    </p>
                                    <p><strong>Total:</strong> Bs. <?= number_format($compra->Total, 2) ?></p>
                                </div>
                                <?php if ($compraEnvio): ?>
                                    <div class="col-md-6">
                                        <h6 class="fw-bold">Información de Envío</h6>
                                        <p><strong>Método de envío:</strong> <?= $compraEnvio->Tipo ?></p>
                                        <p><strong>Empresa de envío:</strong> <?= $compraEnvio->Nombre_Delivery ?></p>
                                        <p><strong>Comunidad:</strong> <?= $compraEnvio->Nombre_Comunidad ?></p>
                                        <p><strong>Dirección:</strong> <?= $compraEnvio->Direccion_Destino ?></p>
                                        <p><strong>Costo de envío:</strong> Bs.
                                            <?= number_format($compraEnvio->Costo_envio, 2) ?>
                                        </p>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <h6 class="fw-bold mb-3">Productos</h6>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($compraDetalles as $detalle): ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="<?= base_url() . $detalle->Imagen_URL ?>"
                                                            class="product-image me-2" alt="<?= $detalle->Nombre ?>">
                                                        <span><?= $detalle->Nombre ?></span>
                                                    </div>
                                                </td>
                                                <td><?= $detalle->Cantidad ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="d-flex gap-2 mt-4">
                                <form action="<?= base_url('compra/entregado') ?>" method="POST" class="d-inline">
                                    <input type="hidden" name="id_compra" value="<?= $compra->ID ?>">
                                    <button type="submit" class="btn btn-success rounded">
                                        <i class="bi bi-check-circle me-2"></i>Confirmar Recepción
                                    </button>
                                </form>
                                <form action="<?= base_url('compra/cancelado') ?>" method="POST" class="d-inline">
                                    <input type="hidden" name="id_compra" value="<?= $compra->ID ?>">
                                    <button type="submit" class="btn btn-danger rounded">
                                        <i class="bi bi-x-circle me-2"></i>Cancelar
                                    </button>
                                </form>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                            
                        </div>
                    </div>
                </div>

            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php
// Funciones auxiliares para el estado de las órdenes
function getStatusColor($status)
{
    switch ($status) {
        case 'ENTREGADO':
            return 'bg-success text-white';
        case 'EN PROCESO':
        case 'ENVIADO':
            return 'bg-warning text-dark';
        case 'PENDIENTE':
            return 'bg-info text-white';
        case 'CANCELADO':
            return 'bg-danger text-white';
        default:
            return 'bg-secondary text-white';
    }
}

function getStatusBadgeColor($status)
{
    switch ($status) {
        case 'ENTREGADO':
            return 'bg-success';
        case 'EN PROCESO':
        case 'ENVIADO':
            return 'bg-warning text-dark';
        case 'PENDIENTE':
            return 'bg-info';
        case 'CANCELADO':
            return 'bg-danger';
        default:
            return 'bg-secondary';
    }
}

function getStatusIcon($status)
{
    switch ($status) {
        case 'ENTREGADO':
            return 'fas fa-check-circle';
        case 'EN PROCESO':
            return 'fas fa-cog';
        case 'ENVIADO':
            return 'fas fa-truck';
        case 'PENDIENTE':
            return 'fas fa-clock';
        case 'CANCELADO':
            return 'fas fa-times-circle';
        default:
            return 'fas fa-question-circle';
    }
}

function getProgressBarColor($status)
{
    switch ($status) {
        case 'ENTREGADO':
            return 'bg-success';
        case 'EN PROCESO':
        case 'ENVIADO':
            return 'bg-warning';
        case 'PENDIENTE':
            return 'bg-info';
        case 'CANCELADO':
            return 'bg-danger';
        default:
            return 'bg-secondary';
    }
}

function getProgressWidth($status)
{
    switch ($status) {
        case 'PENDIENTE':
            return 25;
        case 'EN PROCESO':
            return 50;
        case 'ENVIADO':
            return 75;
        case 'ENTREGADO':
            return 100;
        case 'CANCELADO':
            return 100;
        default:
            return 0;
    }
}
?>

<!-- Scripts específicos para el dashboard -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Inicializar tooltips de Bootstrap
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Función de filtrado de órdenes
        function filterOrders() {
            const searchTerm = document.getElementById('searchOrder').value.toLowerCase();
            const statusFilter = document.getElementById('statusFilter').value;
            const dateFilter = document.getElementById('dateFilter').value;

            const orders = document.querySelectorAll('#ordersList .col-md-6');

            orders.forEach(order => {
                const orderCard = order.querySelector('.cart-card');
                const orderNumber = order.querySelector('.card-title').textContent.toLowerCase();
                const orderStatus = order.querySelector('.status-badge').textContent.trim();
                const orderDate = order.querySelector('.text-muted').textContent.split(' - ')[0];

                let showOrder = true;

                // Filtrar por número de orden
                if (searchTerm && !orderNumber.includes(searchTerm)) {
                    showOrder = false;
                }

                // Filtrar por estado
                if (statusFilter && !orderStatus.includes(statusFilter)) {
                    showOrder = false;
                }

                // Filtrar por fecha
                if (dateFilter) {
                    const filterDate = new Date(dateFilter);
                    const orderDateTime = new Date(orderDate.split('/').reverse().join('-'));
                    if (filterDate.toDateString() !== orderDateTime.toDateString()) {
                        showOrder = false;
                    }
                }

                order.style.display = showOrder ? 'block' : 'none';
            });
        }

        // Eventos de filtrado
        document.getElementById('searchOrder').addEventListener('input', filterOrders);
        document.getElementById('statusFilter').addEventListener('change', filterOrders);
        document.getElementById('dateFilter').addEventListener('change', filterOrders);

        // Añadir animaciones de entrada
        const orders = document.querySelectorAll('.animate-slide-in');
        orders.forEach((order, index) => {
            order.style.animationDelay = `${index * 0.1}s`;
        });
    });
</script>

<!-- Estilos específicos -->
<style>
    :root {
        --primary-color: #4361ee;
        --success-color: #2ec4b6;
        --warning-color: #ff9f1c;
        --danger-color: #e71d36;
        --info-color: #4cc9f0;
    }

    body {
        background-color: #f8f9fc;
        font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
    }

    .animate-hover {
        transition: all 0.3s ease;
    }

    .animate-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }

    .stats-card {
        border-radius: 15px;
        border: none;
        overflow: hidden;
    }

    .stats-card .card-body {
        padding: 1.5rem;
    }

    .stats-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.2);
    }

    .cart-card {
        border-radius: 15px;
        border: none;
        cursor: pointer;
    }

    .status-badge {
        font-size: 0.85rem;
        padding: 0.5em 1em;
        border-radius: 20px;
        font-weight: 500;
    }

    .product-image {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 8px;
    }

    .progress {
        height: 8px;
        border-radius: 4px;
        background-color: #e3e6f0;
        overflow: hidden;
    }

    .progress-bar {
        transition: width 0.6s ease;
    }

    @keyframes slideIn {
        from {
            transform: translateY(20px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .animate-slide-in {
        animation: slideIn 0.5s ease forwards;
    }

    /* Estilos para el modal */
    .modal-content {
        border-radius: 15px;
        border: none;
    }

    .modal-header {
        border-bottom: 1px solid rgba(0, 0, 0, .1);
        padding: 1.5rem;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .modal-footer {
        border-top: 1px solid rgba(0, 0, 0, .1);
        padding: 1.5rem;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .stats-card .card-body {
            padding: 1rem;
        }

        .stats-icon {
            width: 40px;
            height: 40px;
        }

        .product-image {
            width: 32px;
            height: 32px;
        }
    }
</style>