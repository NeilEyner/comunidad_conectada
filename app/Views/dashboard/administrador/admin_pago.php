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
              <!-- <th class="px-4 py-3">Fecha de Pago</th> -->
              <!-- <th class="px-4 py-3">Método de Pago</th> -->
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
                      <img src="<?php echo $pago['IMG_Comprobante']; ?>" alt="Comprobante de Pago" class="w-48 cursor-pointer"
                        onclick="openModal('<?php echo $pago['IMG_Comprobante']; ?>')">
                      <p><?php echo esc($pago['Metodo_pago']); ?></p>
                    <?php else: ?>
                      <p>No disponible</p>
                    <?php endif; ?>
                  </td>

                  <!-- Modal -->
                  <div id="myModal"
                    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-75 hidden z-50"
                    onclick="closeModal()">
                    <div class="relative">
                      <span class="absolute top-0 right-0 p-2 text-white cursor-pointer"
                        onclick="closeModal()">&times;</span>
                      <img class="max-w-full max-h-screen" id="modalImg" src="">
                    </div>
                  </div>


                  <script>
                    function openModal(imgSrc) {
                      document.getElementById("myModal").classList.remove("hidden");
                      document.getElementById("modalImg").src = imgSrc;
                    }

                    function closeModal() {
                      document.getElementById("myModal").classList.add("hidden");
                    }
                  </script>

                  <!-- <td class="px-4 py-3 text-sm"><?php echo esc($pago['Fecha']); ?></td>
                  <td class="px-4 py-3 text-sm"><?php echo esc($pago['Metodo_pago']); ?></td> -->

                  <td class="px-4 py-3 text-sm">
                    <div class="flex items-center space-x-2">
                      <!-- <div class="font-bold">
                        <?php echo $pago['Estado']; ?>
                      </div> -->

                      <?php if ($pago['Estado'] == 'PENDIENTE'): ?>
                        <div class="flex space-x-2">
                          <a href="<?php echo base_url('verifica_comprobante_completado/' . $pago['ID']); ?>"
                            class="change-status-btn bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1.5 px-3 rounded-md transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-opacity-50"
                            onclick="return confirm('¿Estás seguro de que deseas marcar este pago como completado?');">
                            Completado
                          </a>
                          <a href="<?php echo base_url('verifica_comprobante_fallido/' . $pago['ID']); ?>"
                            class="change-status-btn bg-red-500 hover:bg-red-600 text-white font-bold py-1.5 px-3 rounded-md transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50"
                            onclick="return confirm('¿Estás seguro de que deseas marcar este pago como fallido?');">
                            Fallido
                          </a>
                        </div>
                      <?php elseif ($pago['Estado'] == 'COMPLETADO'): ?>
                        <span
                          class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-green-100 text-green-800">
                          Completado
                        </span>
                      <?php elseif ($pago['Estado'] == 'FALLIDO'): ?>
                        <span
                          class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-red-100 text-red-800">
                          Fallido
                        </span>
                      <?php endif; ?>
                    </div>
                  </td>

                  <td class="px-4 py-3 text-sm"><?php echo esc($pago['cliente']['Nombre']); ?></td>
                  <td class="px-4 py-3 text-sm"><?php echo esc($pago['compra']['Fecha']); ?></td>
                  <td class="px-4 py-3 text-sm">
                    <ul class="list-disc pl-5">
                      <?php foreach ($pago['detalle_compra'] as $detalle): ?>
                        <li class="mb-2">
                          <span class="font-bold"><?php echo esc($detalle['producto']['Nombre']); ?></span>
                          <span class="text-gray-600">(Cantidad: <?php echo esc($detalle['Cantidad']); ?>)</span>
                        </li>
                      <?php endforeach; ?>
                    </ul>
                    <div class="mt-4 font-semibold text-lg">
                      Total: <span class="text-green-600">Bs.
                        <?php echo number_format($pago['compra']['Total'], 2); ?></span>
                    </div>
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