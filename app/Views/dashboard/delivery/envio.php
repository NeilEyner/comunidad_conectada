
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="position-relative p-4 bg-gradient-primary text-white rounded-lg shadow-sm" 
                 style="background: linear-gradient(45deg, #3b82f6, #2563eb);">
                <div class="row align-items-center">
                    <div class="col">
                        <h1 class="display-6 mb-0">Gestión de Envíos</h1>
                        <p class="opacity-75 mb-0">Sistema de seguimiento y control de entregas</p>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-shipping-fast fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    <?php if (session()->getFlashdata('mensaje')): ?>
        <div class="alert alert-success border-0 shadow-sm slide-in-top" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <?= session()->getFlashdata('mensaje') ?>
        </div>
    <?php endif; ?>

    <!-- Envíos Grid -->
    <div class="row g-4">
        <?php foreach ($envios as $envio): ?>
            <div class="col-12">
                <div class="card border-0 shadow-sm hover-shadow-lg transition-all">
                    <!-- Estado Badges Section -->
                    <div class="card-header border-bottom-0 bg-white pt-4">
                        <div class="d-flex flex-wrap gap-3 mb-3">
                            <div class="status-pill">
                                <span class="badge rounded-pill px-4 py-2" 
                                      style="background: linear-gradient(45deg, #60a5fa, #3b82f6);">
                                    <i class="fas fa-box me-2"></i>
                                    <?= $envio['Tipo'] ?>
                                </span>
                            </div>
                            <div class="status-pill">
                                <span class="badge rounded-pill px-4 py-2" 
                                      style="background: linear-gradient(45deg, #f59e0b, #d97706);">
                                    <i class="fas fa-motorcycle me-2"></i>
                                    Delivery: <?= $envio['Estado'] ?>
                                </span>
                            </div>
                            <div class="status-pill">
                                <span class="badge rounded-pill px-4 py-2" 
                                      style="background: linear-gradient(45deg, #10b981, #059669);">
                                    <i class="fas fa-user me-2"></i>
                                    Cliente: <?= $envio['Cestado'] ?>
                                </span>
                            </div>
                        </div>

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

                    <!-- Envío Summary -->
                    <div class="card-body pt-0">
                        <div class="envio-summary cursor-pointer p-3 rounded-3 hover-bg-light" 
                             onclick="toggleDetails('envio-<?= $envio['ID_Compra'] ?>')">
                            <div class="row align-items-center">
                                <div class="col">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-chevron-down me-3 transition-transform" 
                                           id="arrow-<?= $envio['ID_Compra'] ?>"></i>
                                        <div>
                                            <div class="text-muted mb-1">Información General</div>
                                            <div class="d-flex flex-wrap gap-4">
                                                <div class="info-item">
                                                    <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                                    <strong>Comunidad:</strong>
                                                    <span class="ms-2"><?= $envio['Comunidad'] ?></span>
                                                </div>
                                                <div class="info-item">
                                                    <i class="fas fa-coins text-warning me-2"></i>
                                                    <strong>Costo:</strong>
                                                    <span class="ms-2">Bs. <?= number_format($envio['Costo_envio'], 2) ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <span class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Ver detalles
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Detalles Expandibles -->
                        <div class="collapse" id="envio-<?= $envio['ID_Compra'] ?>">
                            <div class="border-top mt-3 pt-4">
                                <div class="row">
                                    <!-- Detalles de Envío -->
                                    <div class="col-md-4 mb-4">
                                        <div class="card h-100 bg-light border-0">
                                            <div class="card-body">
                                                <h6 class="card-title text-uppercase text-muted mb-3">
                                                    <i class="fas fa-info-circle me-2"></i>
                                                    Detalles del Envío
                                                </h6>
                                                <div class="details-list">
                                                    <div class="detail-item mb-3">
                                                        <i class="fas fa-map-marked-alt text-danger me-2"></i>
                                                        <strong>Dirección:</strong>
                                                        <p class="text-muted mb-0 mt-1 ps-4">
                                                            <?= $envio['Direccion_Destino'] ?>
                                                        </p>
                                                    </div>
                                                    <div class="detail-item">
                                                        <i class="fas fa-home text-primary me-2"></i>
                                                        <strong>Comunidad:</strong>
                                                        <p class="text-muted mb-0 mt-1 ps-4">
                                                            <?= $envio['Comunidad'] ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Lista de Productos -->
                                    <div class="col-md-8">
                                        <h6 class="text-uppercase text-muted mb-3">
                                            <i class="fas fa-box-open me-2"></i>
                                            Productos en el Envío
                                        </h6>
                                        <div class="row g-3">
                                            <?php foreach ($envio['productos'] as $producto): ?>
                                                <div class="col-md-6">
                                                    <div class="card h-100 hover-shadow-sm transition-all">
                                                        <div class="row g-0">
                                                            <div class="col-4 p-3">
                                                                <div class="ratio ratio-1x1 rounded-3 overflow-hidden">
                                                                    <img src="<?= base_url() . $producto['Imagen_URL'] ?>"
                                                                         class="object-fit-cover"
                                                                         alt="<?= $producto['Producto'] ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-8">
                                                                <div class="card-body">
                                                                    <h6 class="card-title text-truncate">
                                                                        <?= $producto['Producto'] ?>
                                                                    </h6>
                                                                    <div class="small text-muted mb-2">
                                                                        <i class="fas fa-map-pin me-1"></i>
                                                                        <?= $producto['Comunidad_Artesano'] ?>
                                                                    </div>
                                                                    <span class="badge bg-secondary">
                                                                        <i class="fas fa-cubes me-1"></i>
                                                                        Cantidad: <?= $producto['Cantidad'] ?>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Custom CSS -->
<style>
.hover-shadow-lg {
    transition: box-shadow 0.3s ease-in-out;
}

.hover-shadow-lg:hover {
    box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;
}

.hover-lift {
    transition: transform 0.2s ease-in-out;
}

.hover-lift:hover {
    transform: translateY(-2px);
}

.hover-bg-light:hover {
    background-color: rgba(0,0,0,.03);
}

.slide-in-top {
    animation: slideInTop 0.5s ease-out;
}

@keyframes slideInTop {
    from {
        transform: translateY(-100%);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.transition-all {
    transition: all 0.3s ease-in-out;
}

.status-pill .badge {
    font-size: 0.9rem;
    font-weight: 500;
}

.detail-item strong {
    color: #4b5563;
}
</style>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/your-code.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.forEach(function(tooltipTriggerEl) {
        new bootstrap.Tooltip(tooltipTriggerEl)
    });
});

function toggleDetails(envioId) {
    const detailsDiv = document.getElementById(envioId);
    const arrowIcon = document.getElementById('arrow-' + envioId.split('-')[1]);
    const collapse = new bootstrap.Collapse(detailsDiv, {
        toggle: true
    });
    
    detailsDiv.addEventListener('show.bs.collapse', function() {
        arrowIcon.style.transform = 'rotate(180deg)';
    });
    
    detailsDiv.addEventListener('hide.bs.collapse', function() {
        arrowIcon.style.transform = 'rotate(0deg)';
    });
}
</script>