<?php include 'header.php'; ?>
<main class="h-full overflow-y-auto">
  <div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">ENVIOS</h2>
    
    <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">LISTA</h4>
    
    <div class="w-full overflow-hidden rounded-lg shadow-xs">
      <div class="w-full overflow-x-auto">
        <table class="w-full whitespace-no-wrap">
          <thead>
            <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
              <th class="px-4 py-3">Compra</th>
              <th class="px-4 py-3">Delivery</th>
              <th class="px-4 py-3">Transporte</th>
              <th class="px-4 py-3">Comunidad Origen</th>
              <th class="px-4 py-3">Dirección Destino</th>
              <th class="px-4 py-3">Fecha Envío</th>
              <th class="px-4 py-3">Fecha Entrega</th>
              <th class="px-4 py-3">Estado</th>
              <th class="px-4 py-3">Distancia</th>
              <th class="px-4 py-3">Costo Envío</th>
              <th class="px-4 py-3">Acciones</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
            <?php if (!empty($envios) && is_array($envios)): ?>
              <?php foreach ($envios as $envio): ?>
                <tr class="text-gray-700 dark:text-gray-400">
                  <td class="px-4 py-3 text-sm"><?php echo esc($envio['ID_Compra']); ?></td>
                  <td class="px-4 py-3 text-sm"><?php echo esc($envio['ID_Delivery']); ?></td>
                  <td class="px-4 py-3 text-sm"><?php echo esc($envio['ID_Transporte']); ?></td>
                  <td class="px-4 py-3 text-sm"><?php echo esc($envio['Comunidad_Destino']); ?></td>
                  <td class="px-4 py-3 text-sm"><?php echo esc($envio['Direccion_Destino']); ?></td>
                  <td class="px-4 py-3 text-sm"><?php echo esc($envio['Fecha_Envio']); ?></td>
                  <td class="px-4 py-3 text-sm"><?php echo esc($envio['Fecha_Entrega']); ?></td>
                  <td class="px-4 py-3 text-sm"><?php echo esc($envio['Estado']); ?></td>
                  <td class="px-4 py-3 text-sm"><?php echo esc($envio['Distancia']); ?></td>
                  <td class="px-4 py-3 text-sm"><?php echo esc($envio['Costo_envio']); ?></td>
                  <td class="px-4 py-3">
                    <div class="flex items-center space-x-4 text-sm">
                      <button class="openModalButton flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Edit" data-envio-id="<?php echo $envio['ID']; ?>">
                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                          <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                        </svg>
                      </button>
                      <button class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Delete">
                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                          <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                      </button>
                    </div>
                  </td>
                </tr>
                
                <!-- Modal único para cada envío -->
                <div class="modal hidden fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center" id="modal-<?php echo $envio['ID']; ?>">
                    <div class="modal-content w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl" role="dialog">
                        <header class="flex justify-end">
                            <button class="closeModalButton inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover:text-gray-700" aria-label="close" data-envio-id="<?php echo $envio['ID']; ?>">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" role="img" aria-hidden="true">
                                <path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" fill-rule="evenodd"></path>
                            </svg>
                            </button>
                        </header>
                        <div class="mt-4 mb-6">
                        <p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">Editar Envío</p>
                        <p class="text-sm text-gray-700 dark:text-gray-400">Envío ID: <?php echo $envio['ID']; ?></p>
                        </div>
                        <footer class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800">
                        <button class="closeModalButton w-full px-5 py-3 text-sm font-medium leading-5 text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto hover:border-gray-500 focus:outline-none focus:shadow-outline-gray" data-envio-id="<?php echo $envio['ID']; ?>">Cancelar</button>
                        <button class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">Aceptar</button>
                        </footer>
                    </div>
                </div>

              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="11">No se encontraron envíos.</td>
              </tr>
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
      const envioId = button.getAttribute('data-envio-id');
      document.getElementById(`modal-${envioId}`).classList.remove('hidden');
    });
  });

  document.querySelectorAll('.closeModalButton').forEach(button => {
    button.addEventListener('click', () => {
      const envioId = button.getAttribute('data-envio-id');
      document.getElementById(`modal-${envioId}`).classList.add('hidden');
    });
  });
</script>

</body>
</html>
