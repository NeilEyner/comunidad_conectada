<?php include 'header.php'; ?>

<main class="h-full overflow-y-auto">
  <div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
      COMPRAS REALIZADAS
    </h2>

    <div class="container mx-auto px-4 py-8">
      <h2 class="text-3xl font-bold text-green-800 mb-6">Historial de Compras</h2>

      <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="divide-y divide-green-200">
          <?php foreach ($compras as $compra): ?>
            <div class="border-b border-green-100">
              <!-- Cabecera de la compra -->
              <div class="bg-white p-4 cursor-pointer hover:bg-green-50 transition-colors"
                onclick="toggleDetails('compra-<?= $compra->ID ?>')">
                <div class="grid grid-cols-4 items-center">
                  <div class="">
                    <?php $envioCompra = array_filter($envios, function ($e) use ($compra) {
                      return $e->ID_Compra == $compra->ID;
                    });
                    $envio = reset($envioCompra); // Obtiene el primer elemento del array filtrado
                  
                    if ($envio): ?>
                      <p class="text-green-600 font-bold text-center py-4">¡Con envío disponible!</p>
                    <?php else: ?>
                      <p class="text-red-600 font-bold text-center py-4">¡Sin envío disponible!</p>
                    <?php endif; ?>

                  </div>
                  <?php
                  $estado = $compra->Estado;
                  $colorClass = '';

                  switch ($estado) {
                    case 'PENDIENTE':
                      $colorClass = 'bg-yellow-100 text-yellow-800';
                      break;
                    case 'EN PROCESO':
                      $colorClass = 'bg-blue-100 text-blue-800';
                      break;
                    case 'ENVIADO':
                      $colorClass = 'bg-green-100 text-green-800';
                      break;
                    case 'ENTREGADO':
                      $colorClass = 'bg-teal-100 text-teal-800';
                      break;
                    case 'CANCELADO':
                      $colorClass = 'bg-red-100 text-red-800';
                      break;
                    default:
                      $colorClass = 'bg-gray-100 text-gray-800'; // color por defecto
                      break;
                  }
                  ?>

                  <div>
                    <span class="px-2 inline-flex text-xxx leading-5 font-semibold rounded-full <?= $colorClass ?>">
                      <?= $estado ?>
                    </span>
                  </div>

                  <div class="text-sm text-gray-700">Bs. <?= $compra->Total ?></div>
                  <div class="flex justify-end">
                    <svg id="icon-<?= $compra->ID ?>"
                      class="h-6 w-6 text-green-600 transform transition-transform duration-200" fill="none"
                      stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                  </div>
                </div>
              </div>

              <!-- Contenido expandible -->
              <!-- Contenido expandible -->
              <div id="compra-<?= $compra->ID ?>" class="hidden bg-green-50">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-6">
                  <!-- Detalles de la Compra -->
                  <div class="bg-white rounded-lg shadow p-4">
                    <h3 class="text-lg font-semibold text-green-800 mb-4 flex items-center">
                      <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                      </svg>
                      Detalles de la Compra
                    </h3>
                    <div class="space-y-3">
                      <?php
                      $detallesCompra = array_filter($detalles, function ($d) use ($compra) {
                        return $d->ID_Compra == $compra->ID;
                      });
                      foreach ($detallesCompra as $detalle): ?>
                        <div class="flex justify-between items-center bg-green-50 p-2 rounded">
                          <span class="text-gray-600">Cantidad:</span>
                          <span class="font-medium text-green-700"><?= $detalle->Nombre ?></span>
                          <span class="font-medium text-green-700"><?= $detalle->Cantidad ?></span>
                        </div>

                      <?php endforeach; ?>
                      <form action="<?= base_url('compra/entregado') ?>" method="POST">
                        <input type="hidden" name="id_compra" value="<?= $compra->ID ?>">
                        <button type="submit"
                          class="bg-blue-600 hover:bg-green-500 text-white font-semibold py-2 px-5 rounded-lg shadow transition duration-200 ease-in-out transform hover:scale-105">
                          Recibido
                        </button>
                      </form>
                      <BR>
                      <form action="<?= base_url('compra/cancelado') ?>" method="POST">
                        <input type="hidden" name="id_compra" value="<?= $compra->ID ?>">
                        <button type="submit"
                          class="bg-blue-600 hover:bg-green-500 text-white font-semibold py-2 px-5 rounded-lg shadow transition duration-200 ease-in-out transform hover:scale-105">
                          Cancelado
                        </button>
                      </form>
                    </div>
                  </div>

                  <!-- Detalles del Envío -->
                  <div class="bg-white rounded-lg shadow p-4">
                    <h3 class="text-lg font-semibold text-green-800 mb-4 flex items-center">
                      <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                      Información del Envío
                    </h3>
                    <?php
                    $envioCompra = array_filter($envios, function ($e) use ($compra) {
                      return $e->ID_Compra == $compra->ID;
                    });
                    $envio = reset($envioCompra); // Obtiene el primer elemento del array filtrado
                  
                    if ($envio): ?>
                      <div class="space-y-3">
                        <div class="flex justify-between items-center bg-green-50 p-2 rounded">
                          <span class="text-gray-600">Tipo de Transporte:</span>
                          <span class="font-medium text-green-700"><?= $envio->Tipo ?></span>
                        </div>
                        <div class="flex justify-between items-center bg-green-50 p-2 rounded">
                          <span class="text-gray-600">Delivery:</span>
                          <span class="font-medium text-green-700"><?= $envio->Nombre_Delivery ?></span>
                        </div>
                        <div class="flex justify-between items-center bg-green-50 p-2 rounded">
                          <span class="text-gray-600">Comunidad:</span>
                          <span class="font-medium text-green-700"><?= $envio->Nombre_Comunidad ?></span>
                        </div>
                        <div class="flex justify-between items-center bg-green-50 p-2 rounded">
                          <span class="text-gray-600">Dirección:</span>
                          <span class="font-medium text-green-700"><?= $envio->Direccion_Destino ?></span>
                        </div>
                        <div class="flex justify-between items-center bg-green-50 p-2 rounded">
                          <span class="text-gray-600">Estado:</span>
                          <span class="font-medium text-green-700"><?= $envio->Estado ?></span>
                        </div>
                        <div class="flex justify-between items-center bg-green-50 p-2 rounded">
                          <span class="text-gray-600">Costo de Envío:</span>
                          <span class="font-medium text-green-700">Bs. <?= $envio->Costo_envio ?></span>
                        </div>
                      </div>
                    <?php else: ?>
                      <p class="text-gray-600 text-center py-4">No hay información de envío disponible</p>
                    <?php endif; ?>
                  </div>
                </div>
              </div>

            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <script>
      function toggleDetails(id) {
        const content = document.getElementById(id);
        const iconId = id.replace('compra-', 'icon-');
        const icon = document.getElementById(iconId);

        if (content.classList.contains('hidden')) {
          content.classList.remove('hidden');
          icon.style.transform = 'rotate(180deg)';
        } else {
          content.classList.add('hidden');
          icon.style.transform = 'rotate(0)';
        }
      }
    </script>
  </div>
</main>