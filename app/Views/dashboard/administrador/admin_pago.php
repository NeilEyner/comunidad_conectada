<?php include 'header_admin.php'; ?>
<script src="https://cdn.tailwindcss.com"></script>
<main class="h-full overflow-y-auto">
  <div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">PAGOS</h2>
    <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">LISTA DE PAGOS Y COMPRAS</h4>
    <div class="w-full overflow-hidden rounded-lg shadow-xs">
      <div class="w-full overflow-x-auto">
        <table class="min-w-full leading-normal">
          <thead>
            <tr>
              <th class="px-4 py-3">Comprobante</th>
              <th class="px-4 py-3">Fecha de Pago</th>
              <th class="px-4 py-3">Método de Pago</th>
              <th class="px-4 py-3">Estado de Pago</th>
              <th class="px-4 py-3">Cliente</th>
              <th class="px-4 py-3">Fecha de Compra</th>
              <th class="px-4 py-3">Detalle de la Compra</th>

            </tr>
          </thead>
          <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
            <?php if (!empty($pagos) && is_array($pagos)): ?>
              <?php foreach ($pagos as $pago): ?>
                <tr class="text-gray-700 dark:text-gray-400">
                  <td class="px-4 py-3 text-sm">
                    <?php if (!empty($pago['IMG_Comprobante'])): ?>
                      <img src="<?php echo $pago['IMG_Comprobante']; ?>" alt="Comprobante de Pago"
                        style="width: 200px; height: auto;">
                    <?php else: ?>
                      <p>No disponible</p>
                    <?php endif; ?>
                  </td>
                  <td class="px-4 py-3 text-sm"><?php echo esc($pago['Fecha']); ?></td>
                  <td class="px-4 py-3 text-sm"><?php echo esc($pago['Metodo_pago']); ?></td>

                  <td class="px-4 py-3 text-sm">
                    <div class="flex space-x-2 px-4 py-3 bold">
                      <?php echo $pago['Estado'] ?>
                    </div>
                    <?php if ($pago['Estado'] == 'PENDIENTE'): ?>
                      <div class="flex space-x-2">
                        <a href="<?php echo base_url('verifica_comprobante_completado/'.$pago['ID']); ?>"
                          class="change-status-btn bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1.5 px-3 rounded-md transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-opacity-50">
                          Completado
                        </a>
                        <a href="<?php echo base_url('verifica_comprobante_fallido/'.$pago['ID']); ?>"
                          class="change-status-btn bg-red-500 hover:bg-red-600 text-white font-bold py-1.5 px-3 rounded-md transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                          Fallido
                        </a>
                      </div>
                    <?php elseif ($pago['Estado'] == 'COMPLETADO'): ?>
                      <span
                        class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        <svg class="mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                          <circle cx="4" cy="4" r="3" />
                        </svg>
                        Completado
                      </span>
                    <?php elseif ($pago['Estado'] == 'FALLIDO'): ?>
                      <span
                        class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-red-100 text-red-800">
                        <svg class="mr-1.5 h-2 w-2 text-red-400" fill="currentColor" viewBox="0 0 8 8">
                          <circle cx="4" cy="4" r="3" />
                        </svg>
                        Fallido
                      </span>
                    <?php endif; ?>
                  </td>
                  <td class="px-4 py-3 text-sm"><?php echo esc($pago['cliente']['Nombre']); ?></td>
                  <td class="px-4 py-3 text-sm"><?php echo esc($pago['compra']['Fecha']); ?></td>
                  <td class="px-4 py-3 text-sm">
                    <ul>
                      <?php foreach ($pago['detalle_compra'] as $detalle): ?>
                        <li><?php echo esc($detalle['producto']['Nombre']); ?> (Cantidad:
                          <?php echo esc($detalle['Cantidad']); ?>)
                        </li>
                      <?php endforeach; ?>
                      <li>Bs.<?php echo number_format($pago['compra']['Total'], 2); ?></li>
                    </ul>
                  </td>

                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>

      </div>
    </div>
  </div>
</main>

<script>
  document.querySelectorAll('.openModalButton').forEach(button => {
    button.addEventListener('click', () => {
      const pagoId = button.getAttribute('data-pago-id');
      document.getElement
        .querySelector(`#modal-${pagoId}`).classList.remove('hidden');
    });
  });

  document.querySelectorAll('.closeModalButton').forEach(button => {
    button.addEventListener('click', () => {
      const pagoId = button.getAttribute('data-pago-id');
      document.querySelector(`#modal-${pagoId}`).classList.add('hidden');
    });
  });
</script>