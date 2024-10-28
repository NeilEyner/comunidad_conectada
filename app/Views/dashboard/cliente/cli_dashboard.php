
<!-- Custom CSS -->
<style>
.timeline-track {
    position: relative;
    padding-left: 30px;
}

.timeline-track::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    height: 100%;
    width: 2px;
    background: #e9ecef;
}

.purchase-card {
    transition: all 0.3s ease;
    border: none;
}

.purchase-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}

.status-badge {
    position: relative;
    padding-left: 25px;
}

.status-badge::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

.status-pending::before { background-color: #ffc107; }
.status-process::before { background-color: #17a2b8; }
.status-sent::before { background-color: #007bff; }
.status-delivered::before { background-color: #28a745; }
.status-cancelled::before { background-color: #dc3545; }

.detail-card {
    height: 100%;
    transition: all 0.3s ease;
}

.detail-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.shipping-info {
    position: relative;
    overflow: hidden;
}

.shipping-info::after {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 100px;
    height: 100px;
    background: linear-gradient(45deg, transparent 50%, rgba(0,123,255,0.1) 50%);
}
</style>

<div class="container-fluid py-5 bg-light">
    <div class="container">
        <!-- Header Section -->
        <div class="row mb-5">
            <div class="col-12 text-center">
                <div class="d-flex justify-content-center gap-4 mb-4">
                    <div class="px-4 py-2 bg-white rounded-pill shadow-sm">
                        <i class="bi bi-bag-check text-primary me-2"></i>
                        <span class="fw-semibold">Total de Compras: <?= count($compras) ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Timeline of Purchases -->
        <div class="timeline-track">
            <?php foreach ($compras as $compra): ?>
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="purchase-card card shadow-sm">
                            <!-- Purchase Header -->
                            <div class="card-header bg-white border-bottom-0 py-3">
                                <div class="row align-items-center">
                                    <div class="col-md-3">
                                        <?php 
                                        $envioCompra = array_filter($envios, function ($e) use ($compra) {
                                            return $e->ID_Compra == $compra->ID;
                                        });
                                        $envio = reset($envioCompra);
                                        
                                        $statusClass = '';
                                        switch ($compra->Estado) {
                                            case 'PENDIENTE': $statusClass = 'status-pending'; break;
                                            case 'EN PROCESO': $statusClass = 'status-process'; break;
                                            case 'ENVIADO': $statusClass = 'status-sent'; break;
                                            case 'ENTREGADO': $statusClass = 'status-delivered'; break;
                                            case 'CANCELADO': $statusClass = 'status-cancelled'; break;
                                        }
                                        ?>
                                        <span class="status-badge <?= $statusClass ?> fw-semibold">
                                            <?= $compra->Estado ?>
                                        </span>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-cash-stack text-success me-2"></i>
                                            <span class="fw-bold">Bs. <?= number_format($compra->Total, 2) ?></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <?php if ($envio): ?>
                                            <div class="d-flex align-items-center text-primary">
                                                <i class="bi bi-truck me-2"></i>
                                                <span>Envío a <?= $envio->Nombre_Comunidad ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <button class="btn btn-outline-primary btn-sm rounded-pill" 
                                                data-bs-toggle="collapse" 
                                                data-bs-target="#details-<?= $compra->ID ?>">
                                            <i class="bi bi-chevron-down me-1"></i>
                                            Detalles
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Collapsible Details -->
                            <div class="collapse" id="details-<?= $compra->ID ?>">
                                <div class="card-body bg-light py-4">
                                    <div class="row g-4">
                                        <!-- Purchase Details -->
                                        <div class="col-md-6">
                                            <div class="detail-card card bg-white">
                                                <div class="card-body">
                                                    <h5 class="card-title d-flex align-items-center mb-4">
                                                        <i class="bi bi-cart-check text-primary me-2"></i>
                                                        Detalles del Pedido
                                                    </h5>
                                                    <?php
                                                    $detallesCompra = array_filter($detalles, function ($d) use ($compra) {
                                                        return $d->ID_Compra == $compra->ID;
                                                    });
                                                    foreach ($detallesCompra as $detalle): ?>
                                                        <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                                                            <div>
                                                                <h6 class="mb-1"><?= $detalle->Nombre ?></h6>
                                                                <small class="text-muted">Cantidad: <?= $detalle->Cantidad ?></small>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>

                                                    <div class="d-flex gap-2 mt-4">
                                                        <form action="<?= base_url('compra/entregado') ?>" method="POST" class="d-inline">
                                                            <input type="hidden" name="id_compra" value="<?= $compra->ID ?>">
                                                            <button type="submit" class="btn btn-success rounded-pill">
                                                                <i class="bi bi-check-circle me-2"></i>Confirmar Recepción
                                                            </button>
                                                        </form>
                                                        <form action="<?= base_url('compra/cancelado') ?>" method="POST" class="d-inline">
                                                            <input type="hidden" name="id_compra" value="<?= $compra->ID ?>">
                                                            <button type="submit" class="btn btn-danger rounded-pill">
                                                                <i class="bi bi-x-circle me-2"></i>Cancelar
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Shipping Information -->
                                        <?php if ($envio): ?>
                                            <div class="col-md-6">
                                                <div class="detail-card card bg-white shipping-info">
                                                    <div class="card-body">
                                                        <h5 class="card-title d-flex align-items-center mb-4">
                                                            <i class="bi bi-geo-alt text-primary me-2"></i>
                                                            Información de Envío
                                                        </h5>
                                                        <div class="row g-3">
                                                            <div class="col-6">
                                                                <div class="p-3 bg-light rounded">
                                                                    <small class="text-muted d-block">Transporte</small>
                                                                    <span class="fw-semibold"><?= $envio->Tipo ?></span>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="p-3 bg-light rounded">
                                                                    <small class="text-muted d-block">Delivery</small>
                                                                    <span class="fw-semibold"><?= $envio->Nombre_Delivery ?></span>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="p-3 bg-light rounded">
                                                                    <small class="text-muted d-block">Dirección de Entrega</small>
                                                                    <span class="fw-semibold"><?= $envio->Direccion_Destino ?></span>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="p-3 bg-light rounded">
                                                                    <small class="text-muted d-block">Estado del Envío</small>
                                                                    <span class="fw-semibold"><?= $envio->Estado ?></span>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="p-3 bg-light rounded">
                                                                    <small class="text-muted d-block">Costo de Envío</small>
                                                                    <span class="fw-semibold">Bs. <?= number_format($envio->Costo_envio, 2) ?></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <div class="col-md-6">
                                                <div class="detail-card card bg-white h-100">
                                                    <div class="card-body d-flex align-items-center justify-content-center">
                                                        <div class="text-center text-muted">
                                                            <i class="bi bi-box-seam display-4 mb-3"></i>
                                                            <h5>Sin información de envío</h5>
                                                            <p class="mb-0">Esta compra no incluye servicio de envío</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">