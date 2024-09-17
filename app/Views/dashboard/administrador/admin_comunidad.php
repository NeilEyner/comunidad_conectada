<?php include 'header_admin.php'; ?>
<main class="h-full overflow-y-auto">
  <div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">COMUNIDADES</h2>
    <div>
      <button @click="openModal"
        class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
        Agregar </button>
    </div>
    <?php if (session()->getFlashdata('errors')): ?>
      <div class="alert alert-danger">
        <?= session()->getFlashdata('errors') ?>
      </div>
    <?php endif; ?>
    <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">LISTA</h4>
    <div class="w-full overflow-hidden rounded-lg shadow-xs">
      <div class="w-full overflow-x-auto">
        <table class="w-full table-fixed">
          <thead>
            <tr
              class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
              <th class="px-4 py-3">Nombre</th>
              <th class="px-4 py-3">Descripción</th>
              <th class="px-4 py-3">Fecha de Registro</th>
              <th class="px-4 py-3">Ubicación</th>
              <th class="px-4 py-3">Acciones</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
            <?php if (!empty($comunidades) && is_array($comunidades)): ?>
              <?php foreach ($comunidades as $comunidad): ?>
                <tr class="text-gray-700 dark:text-gray-400">
                  <td class="px-4 py-3">
                    <div class="flex items-center text-sm">
                      <div>
                        <p class="font-semibold"><?php echo esc($comunidad['Nombre']); ?></p>
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          <?php echo esc($comunidad['Latitud']); ?>     <?php echo esc($comunidad['Longitud']); ?>
                        </p>
                      </div>
                    </div>
                  </td>
                  <td class="px-4 py-3 text-xs ">
                    <?php echo esc($comunidad['Descripcion']); ?>
                  </td>
                  <td class="px-4 py-3 text-xs">

                    <?php echo esc($comunidad['Fecha_registro']); ?>
                    </span>
                  </td>
                  <td class="px-4 py-3 text-sm">
                    <?php echo esc($comunidad['Ubicacion']); ?>
                  </td>

                  <td>
                    <div class="flex items-center space-x-4 text-sm">
                      <button
                        class="openModalButton flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                        aria-label="Edit" data-comunidad-id="<?php echo $comunidad['ID']; ?>">
                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                          <path
                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                          </path>
                        </svg>
                      </button>
                      <form action="<?= base_url('administrador/eliminar_comunidad/' . $comunidad['ID']) ?>" method="post">
                        <button type="submit"
                          class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-red-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                          aria-label="Delete">
                          <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                              d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                              clip-rule="evenodd"></path>
                          </svg>
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>

                <!-- Modal único para cada comunidad -->
                <div
                  class="modal hidden fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"
                  id="modal-<?php echo $comunidad['ID']; ?>">
                  <div
                    class="modal-content w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl"
                    role="dialog">
                    <header class="flex justify-end">
                      <button
                        class="closeModalButton inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover:text-gray-700"
                        aria-label="close" data-comunidad-id="<?php echo $comunidad['ID']; ?>">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" role="img" aria-hidden="true">
                          <path
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd" fill-rule="evenodd"></path>
                        </svg>
                      </button>
                    </header>
                    <div class="mt-4 mb-6">
                      <p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">Editar Comunidad</p>
                    </div>

                    <form action="<?= base_url('administrador/editar_comunidad/' . $comunidad['ID']) ?>" method="post">
                      <div class="mt-4 mb-6">
                        <div class="mb-3">
                          <label for="Nombre" class="block text-sm text-gray-700 dark:text-gray-400">Nombre</label>
                          <input type="text" id="Nombre" name="Nombre" value="<?= esc($comunidad['Nombre']); ?>"
                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 form-input"
                            required>
                        </div>
                        <div class="mb-3">
                          <label for="Descripcion"
                            class="block text-sm text-gray-700 dark:text-gray-400">Descripcion</label>
                          <input type="text" id="Descripcion" name="Descripcion"
                            value="<?= esc($comunidad['Descripcion']); ?>"
                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 form-input"
                            required>
                        </div>
                        <div class="mb-3">
                          <label for="Ubicacion" class="block text-sm text-gray-700 dark:text-gray-400">Ubicacion</label>
                          <input type="text" id="Ubicacion" name="Ubicacion" value="<?= esc($comunidad['Ubicacion']); ?>"
                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 form-input"
                            required>
                        </div>
                        <div class="mb-3">
                          <label for="Latitud" class="block text-sm text-gray-700 dark:text-gray-400">Latitud</label>
                          <input type="text" id="Latitud" name="Latitud" value="<?= esc($comunidad['Latitud']); ?>"
                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 form-input">
                        </div>
                        <div class="mb-3">
                          <label for="Longitud" class="block text-sm text-gray-700 dark:text-gray-400">Longitud</label>
                          <input type="text" id="Longitud" name="Longitud" value="<?= esc($comunidad['Longitud']); ?>"
                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 form-input">
                        </div>

                        <footer class="flex justify-end px-6 py-3 bg-gray-50 dark:bg-gray-800">
                          <button type="submit"
                            class="w-full px-5 py-3 text-sm font-medium text-white bg-purple-600 rounded-lg sm:w-auto sm:px-4 sm:py-2 hover:bg-purple-700 focus:outline-none">
                            Actualizar
                          </button>
                        </footer>
                      </div>
                    </form>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="7">No se encontraron comunidades.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div x-show="isModalOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center">
    <!-- Modal -->
    <div x-show="isModalOpen" x-transition:enter="transition ease-out duration-150"
      x-transition:enter-start="opacity-0 transform translate-y-1/2" x-transition:enter-end="opacity-100"
      x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
      x-transition:leave-end="opacity-0  transform translate-y-1/2" @click.away="closeModal"
      @keydown.escape="closeModal"
      class="w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl"
      role="dialog" id="modal">
      <!-- Remove header if you don't want a close icon. Use modal body to place modal tile. -->
      <header class="flex justify-end">
        <button class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700"
          aria-label="close" @click="closeModal">
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" role="img" aria-hidden="true">
            <path
              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
              clip-rule="evenodd" fill-rule="evenodd"></path>
          </svg>
        </button>
      </header>
      <!-- Modal body -->
      <form action="<?= base_url('administrador/agregar_comunidad') ?>" method="post" enctype="multipart/form-data">
        <label class="block text-sm">
          <span class="text-gray-700 dark:text-gray-400">Nombre</span>
          <input type="text"
            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
            id="Nombre" name="Nombre" value="<?= old('Nombre') ?>" required />
        </label>

        <label class="block mt-4 text-sm">
          <span class="text-gray-700 dark:text-gray-400">Descripcion</span>
          <input type="text"
            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
            id="Descripcion" name="Descripcion" value="<?= old('Descripcion') ?>" required />
        </label>

        <label class="block mt-4 text-sm">
          <span class="text-gray-700 dark:text-gray-400">Latitud</span>
          <input type="number" step="0.01"
            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
            id="Latitud" name="Latitud" value="<?= old('Latitud') ?>" required />
        </label>

        <label class="block mt-4 text-sm">
          <span class="text-gray-700 dark:text-gray-400">Longitud</span>
          <input type="number" step="0.01"
            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
            id="Longitud" name="Longitud" value="<?= old('Longitud') ?>" required />
        </label>

        <label class="block mt-4 text-sm">
          <span class="text-gray-700 dark:text-gray-400">Ubicacion</span>
          <input type="text"
            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
            id="Ubicacion" name="Ubicacion" value="<?= old('Ubicacion') ?>" required />
        </label>

        <button type="submit"
          class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
          Registrarse
        </button>
      </form>
      <footer
        class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800">
        <button @click="closeModal"
          class="w-full px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray">
          Cancel
        </button>
      </footer>
    </div>
  </div>


</main>

<script>
  document.querySelectorAll('.openModalButton').forEach(button => {
    button.addEventListener('click', () => {
      const comunidadId = button.getAttribute('data-comunidad-id');
      document.getElementById(`modal-${comunidadId}`).classList.remove('hidden');
    });
  });

  document.querySelectorAll('.closeModalButton').forEach(button => {
    button.addEventListener('click', () => {
      const comunidadId = button.getAttribute('data-comunidad-id');
      document.getElementById(`modal-${comunidadId}`).classList.add('hidden');
    });
  });
</script>

</body>

</html>