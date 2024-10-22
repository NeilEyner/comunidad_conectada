<?php include 'header.php'; ?>
<main class="h-full overflow-y-auto">
  <div class="container px-4 mx-auto py-4">
    <h2 class="mb-6 text-xl font-semibold text-gray-700 dark:text-gray-200">
      Realizar Envíos
    </h2>

    <div class="space-y-6">
      <?php if (session()->getFlashdata('mensaje')): ?>
        <div class="alert alert-success">
          <?= session()->getFlashdata('mensaje') ?>
        </div>
      <?php endif; ?>

      <?php foreach ($envios as $envio): ?>
        <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
          <!-- Cabecera con número de compra destacado -->
          <div class="bg-white shadow-md rounded-lg p-4 border border-gray-300 flex items-center justify-between">
            <div class="flex items-center space-x-4">
              <span class="bg-blue-100 text-blue-800 px-4 py-2 rounded-full text-sm font-medium">
                <?= $envio['Tipo'] ?>
              </span>
              <span class="bg-orange-100 text-yellow-800 px-4 py-2 rounded-full text-sm font-medium">
                DELIVERY: <?= $envio['Estado'] ?>
              </span>
              <span class="bg-green-100 text-green-800 px-4 py-2 rounded-full text-sm font-medium">
                CLIENTE: <?= $envio['Cestado'] ?>
              </span>
            </div>

            <?php if ($envio['Estado'] !== 'ENTREGADO'): ?>
              <form action="<?= base_url('envios/entregado') ?>" method="POST">
                <input type="hidden" name="id_compra" value="<?= $envio['ID_Compra'] ?>">
                <button type="submit"
                  class="bg-blue-600 hover:bg-green-500 text-white font-semibold py-2 px-5 rounded-lg shadow transition duration-200 ease-in-out transform hover:scale-105">
                  Marcar como Entregado
                </button>
              </form>
            <?php endif; ?>
          </div>



          <!-- Información resumida (siempre visible) -->
          <div class="px-4 py-3 cursor-pointer hover:bg-gray-50 transition-colors"
            onclick="toggleDetails('envio-<?= $envio['ID_Compra'] ?>')">
            <div class="flex justify-between items-center">
              <div class="flex space-x-4">
                <svg class="w-5 h-5 text-gray-400 transform transition-transform duration-200"
                  id="arrow-<?= $envio['ID_Compra'] ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
                <div class="text-sm">
                  <span class="text-gray-600">Comunidad:</span>
                  <span class="font-medium"><?= $envio['Comunidad'] ?></span>
                  <span class="ml-4 text-gray-600">Costo:</span>
                  <span class="font-medium">Bs. <?= number_format($envio['Costo_envio'], 2) ?></span>
                </div>
              </div>
              <span class="text-sm text-gray-500">Ver detalles</span>
            </div>
          </div>

          <!-- Detalles expandibles -->
          <div class="hidden bg-gray-50" id="envio-<?= $envio['ID_Compra'] ?>">
            <div class="p-4">
              <h3 class="text-sm font-semibold text-gray-600 mb-2">Detalles del Envío</h3>
              <div class="text-sm text-gray-700">
                <p><span class="font-semibold">Dirección:</span> <?= $envio['Direccion_Destino'] ?></p>
                <p><span class="font-semibold">Comunidad:</span> <?= $envio['Comunidad'] ?></p>
              </div>

              <div class="mt-4">
                <h4 class="text-base font-semibold text-gray-700">Productos en el Envío</h4>
                <div class="space-y-3 mt-3">
                  <?php foreach ($envio['productos'] as $producto): ?>
                    <div
                      class="flex items-center gap-4 p-3 bg-white border border-gray-200 rounded-lg hover:shadow transition-all">
                      <div class="w-16 h-16 overflow-hidden rounded-md">
                        <img src="<?= base_url() . $producto['Imagen_URL'] ?>" alt="<?= $producto['Producto'] ?>"
                          class="w-12 h-12 object-cover transition-transform duration-200 hover:scale-105">
                      </div>
                      <div>
                        <h5 class="text-sm font-medium text-gray-800"><?= $producto['Producto'] ?></h5>
                        <p class="text-xs text-gray-500">Comunidad: <?= $producto['Comunidad_Artesano'] ?></p>
                        <p class="text-xs text-gray-500">Cantidad: <?= $producto['Cantidad'] ?></p>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <br>
      <?php endforeach; ?>
    </div>
  </div>

  <script>
    function toggleDetails(envioId) {
      const detailsDiv = document.getElementById(envioId);
      const arrowIcon = document.getElementById('arrow-' + envioId.split('-')[1]);

      detailsDiv.classList.toggle('hidden');

      if (detailsDiv.classList.contains('hidden')) {
        arrowIcon.style.transform = 'rotate(0deg)';
      } else {
        arrowIcon.style.transform = 'rotate(180deg)';
      }
    }

    function asignarDelivery(idCompra) {
      if (confirm('¿Desea asignar un delivery a este envío?')) {
        fetch(`/envios/asignarDelivery/${idCompra}`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          }
        })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              alert('Delivery asignado correctamente');
              location.reload();
            } else {
              alert('Error al asignar delivery');
            }
          });
      }
    }
  </script>
</main>