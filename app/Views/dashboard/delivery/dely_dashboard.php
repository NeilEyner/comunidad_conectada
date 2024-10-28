<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
          <h3 class="mb-0">
            <i class="fas fa-shipping-fast me-2"></i>
            Gestión de Envíos
          </h3>
          <div class="d-flex gap-2">
            <button class="btn btn-light btn-sm" data-bs-toggle="tooltip" title="Actualizar">
              <i class="fas fa-sync-alt"></i>
            </button>
          </div>
        </div>

        <div class="card-body">
          <?php if (session()->getFlashdata('mensaje')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <i class="fas fa-check-circle me-2"></i>
              <?= session()->getFlashdata('mensaje') ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>

          <div class="row g-4">
            <?php foreach ($envios as $envio): ?>
              <div class="col-12">
                <div class="card h-100 border-0 shadow-sm">
                  <div class="card-header bg-light d-flex justify-content-between align-items-center py-3">
                    <div class="d-flex align-items-center gap-3">
                      <span class="badge bg-primary rounded-pill">
                        Envío #<?= $envio['ID_Compra'] ?>
                      </span>
                      <span class="badge bg-info rounded-pill">
                        <?= $envio['Tipo'] ?>
                      </span>
                    </div>
                    <form action="<?= base_url('envios/asignar') ?>" method="POST">
                      <input type="hidden" name="id_compra" value="<?= $envio['ID_Compra'] ?>">
                      <button type="submit" class="btn btn-success btn-sm">
                        <i class="fas fa-user-plus me-2"></i>
                        Asignar Delivery
                      </button>
                    </form>
                  </div>

                  <div class="card-body">
                    <div class="mb-3 cursor-pointer" onclick="toggleDetails('envio-<?= $envio['ID_Compra'] ?>')">
                      <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-3">
                          <i class="fas fa-chevron-down transition-transform" id="arrow-<?= $envio['ID_Compra'] ?>"></i>
                          <div>
                            <div class="text-muted small">Comunidad:</div>
                            <div class="fw-bold"><?= $envio['Comunidad'] ?></div>
                          </div>
                          <div class="ms-4">
                            <div class="text-muted small">Costo de envío:</div>
                            <div class="fw-bold text-success">Bs. <?= number_format($envio['Costo_envio'], 2) ?></div>
                          </div>
                        </div>
                        <span class="badge bg-light text-dark">
                          Click para ver detalles
                        </span>
                      </div>
                    </div>

                    <div class="collapse" id="envio-<?= $envio['ID_Compra'] ?>">
                      <div class="card bg-light">
                        <div class="card-body">
                          <h5 class="card-title mb-3">
                            <i class="fas fa-info-circle me-2"></i>
                            Detalles del Envío
                          </h5>

                          <div class="row mb-4">
                            <div class="col-md-6">
                              <div class="mb-2">
                                <i class="fas fa-map-marker-alt text-danger me-2"></i>
                                <span class="fw-bold">Dirección:</span>
                                <?= $envio['Direccion_Destino'] ?>
                              </div>
                              <div>
                                <i class="fas fa-home text-primary me-2"></i>
                                <span class="fw-bold">Comunidad:</span>
                                <?= $envio['Comunidad'] ?>
                              </div>
                            </div>
                          </div>

                          <h6 class="mb-3">
                            <i class="fas fa-box me-2"></i>
                            Productos en el Envío
                          </h6>

                          <div class="row g-3">
                            <?php foreach ($envio['productos'] as $producto): ?>
                              <div class="col-md-6">
                                <div class="card h-100 border">
                                  <div class="row g-0">
                                    <div class="col-4 d-flex justify-content-center align-items-center">
                                      <div class="image-container">
                                        <img src="<?= base_url() . $producto['Imagen_URL'] ?>"
                                          class="img-fluid rounded shadow" alt="<?= $producto['Producto'] ?> " width="100px">
                                      </div>
                                    </div>

                                    <div class="col-8">
                                      <div class="card-body">
                                        <h6 class="card-title"><?= $producto['Producto'] ?></h6>
                                        <p class="card-text small mb-1">
                                          <i class="fas fa-map-pin text-muted me-1"></i>
                                          <?= $producto['Comunidad_Artesano'] ?>
                                        </p>
                                        <p class="card-text">
                                          <span class="badge bg-secondary">
                                            <i class="fas fa-cubes me-1"></i>
                                            Cantidad: <?= $producto['Cantidad'] ?>
                                          </span>
                                        </p>
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
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Font Awesome -->
<script src="https://kit.fontawesome.com/your-code.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Inicializar todos los tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    });
  });

  function toggleDetails(envioId) {
    const detailsDiv = document.getElementById(envioId);
    const arrowIcon = document.getElementById('arrow-' + envioId.split('-')[1]);
    const collapse = new bootstrap.Collapse(detailsDiv, {
      toggle: true
    });

    detailsDiv.addEventListener('shown.bs.collapse', function () {
      arrowIcon.style.transform = 'rotate(180deg)';
    });

    detailsDiv.addEventListener('hidden.bs.collapse', function () {
      arrowIcon.style.transform = 'rotate(0deg)';
    });
  }

  function asignarDelivery(idCompra) {
    if (confirm('¿Está seguro que desea asignar un delivery a este envío?')) {
      fetch(`/envios/asignarDelivery/${idCompra}`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        }
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            showToast('Delivery asignado correctamente', 'success');
            setTimeout(() => location.reload(), 1500);
          } else {
            showToast('Error al asignar delivery', 'error');
          }
        });
    }
  }

  function showToast(message, type) {
    const toastContainer = document.createElement('div');
    toastContainer.style.position = 'fixed';
    toastContainer.style.top = '20px';
    toastContainer.style.right = '20px';
    toastContainer.style.zIndex = '1050';

    const toast = document.createElement('div');
    toast.className = `toast align-items-center text-white bg-${type === 'success' ? 'success' : 'danger'} border-0`;
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');

    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    `;

    toastContainer.appendChild(toast);
    document.body.appendChild(toastContainer);

    const bsToast = new bootstrap.Toast(toast);
    bsToast.show();

    toast.addEventListener('hidden.bs.toast', function () {
      toastContainer.remove();
    });
  }
</script>