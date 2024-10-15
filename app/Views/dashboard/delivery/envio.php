<?php include 'header.php'; ?>
<main class="h-full overflow-y-auto">
  <div class="container px-6 mx-auto">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
      Realizar Envíos
    </h2>

    <?php if (!empty($compras)): ?>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-4">
        <?php
        $currentCompraID = null;
        $totalCompra = 0;
        ?>
        <?php foreach ($compras as $index => $compra): ?>
          <?php if ($currentCompraID !== $compra->ID): ?>
            <?php if ($index !== 0): ?>
              <!-- Botón para la compra anterior -->
              <div class="flex justify-end mt-4">
                <button onclick="openModal('modal-<?= $currentCompraID ?>')"
                  class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md shadow-md hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                  Realizar Envío para Compra ID <?= $currentCompraID ?>
                </button>
              </div>

              <!-- Modal para la compra anterior -->
              <div id="modal-<?= $currentCompraID ?>"
                class="fixed inset-0 z-50 hidden items-center justify-center bg-gray-800 bg-opacity-75">
                <div class="bg-white rounded-lg shadow-lg p-4 max-w-sm mx-auto">
                  <h3 class="text-lg font-semibold mb-4">Confirmar Envío</h3>
                  <p>¿Estás seguro de que quieres realizar el envío de <strong>Compra ID <?= $currentCompraID ?></strong> con un
                    total de <strong>$<?= $totalCompra ?></strong>?</p>
                  <div class="mt-4 flex justify-between">
                    <button class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600"
                      onclick="confirmarEnvio(<?= $currentCompraID ?>)">Confirmar</button>
                    <button class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600"
                      onclick="closeModal('modal-<?= $currentCompraID ?>')">Cancelar</button>
                  </div>
                </div>
              </div>
            <?php endif; ?>

            <!-- Card compacto para cada Compra -->
            <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
              <h3 class="text-md font-bold text-gray-900 dark:text-gray-200 mb-3">Compra ID: <?= $compra->ID ?></h3>

              <div class="space-y-2">
                <?php
                $currentCompraID = $compra->ID;
                $totalCompra = 0;
                ?>
              <?php endif; ?>

              <!-- Detalles del producto dentro del card compacto -->
              <div class="flex items-center">
                <div style="width: 96px; height: 96px;" class="mr-3">
                  <img class="object-cover w-full h-full rounded-md shadow-sm" src="<?= base_url() . $compra->Imagen_URL ?>"
                    alt="Producto">
                </div>


                <div class="text-sm">
                  <p class="font-medium text-gray-900 dark:text-gray-100"><?= $compra->Nombre ?></p>
                  <p class="text-gray-600 dark:text-gray-400">Cantidad: <?= $compra->Cantidad ?></p>
                  <p class="text-gray-600 dark:text-gray-400">Total: $<?= $compra->Total ?></p>
                </div>
              </div>
              <?php $totalCompra += $compra->Total; ?>

              <?php if ($index === count($compras) - 1): ?>
              </div>
              <div class="flex justify-end mt-4">
                <button onclick="openModal('modal-<?= $currentCompraID ?>')"
                  class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md shadow-md hover:bg-blue-700">
                  Realizar Envío para Compra ID <?= $currentCompraID ?>
                </button>
              </div>

              <!-- Modal para la última Compra -->
              <div id="modal-<?= $currentCompraID ?>"
                class="fixed inset-0 z-50 hidden items-center justify-center bg-gray-800 bg-opacity-75">
                <div class="bg-white rounded-lg shadow-lg p-4 max-w-sm mx-auto">
                  <h3 class="text-lg font-semibold mb-4">Confirmar Envío</h3>
                  <p>¿Estás seguro de que quieres realizar el envío de <strong>Compra ID <?= $currentCompraID ?></strong> con
                    un total de <strong>$<?= $totalCompra ?></strong>?</p>
                  <div class="mt-4 flex justify-between">
                    <button class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600"
                      onclick="confirmarEnvio(<?= $currentCompraID ?>)">Confirmar</button>
                    <button class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600"
                      onclick="closeModal('modal-<?= $currentCompraID ?>')">Cancelar</button>
                  </div>
                </div>
              </div>
            </div> <!-- Fin del card compacto -->
          <?php endif; ?>
        <?php endforeach; ?>
      </div> <!-- Fin del grid layout compacto -->
    <?php else: ?>
      <p class="text-center text-gray-500 dark:text-gray-400">No hay envíos pendientes.</p>
    <?php endif; ?>
  </div>
</main>

<script>
  function openModal(id) {
    document.getElementById(id).classList.remove('hidden');
    document.getElementById(id).classList.add('flex');
  }

  function closeModal(id) {
    document.getElementById(id).classList.remove('flex');
    document.getElementById(id).classList.add('hidden');
  }

  function confirmarEnvio(id) {
    alert('Envío confirmado para la compra ID: ' + id);
    closeModal('modal-' + id);
  }
</script>