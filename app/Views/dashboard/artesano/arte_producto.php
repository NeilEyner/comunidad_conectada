<?php include 'header.php'; ?>
<main class="h-full overflow-y-auto">
  <div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">PRODUCTOS DE ARTESANOS</h2>
    <div>
      <button @click="openModal"
        class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
        Agregar </button>
    </div>
    <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">LISTA</h4>

    <div class="w-full overflow-hidden rounded-lg shadow-xs">
      <div class="w-full overflow-x-auto">
        <table class="w-full">
          <thead>
            <tr
              class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
              <th class="px-4 py-3">Nombre</th>
              <th class="px-4 py-3">Descripcion</th>
              <th class="px-4 py-3">Precio</th>
              <th class="px-4 py-3">Stock</th>
              <th class="px-4 py-3">Disponibilidad</th>
              <th class="px-4 py-3">Acciones</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
            <?php if (!empty($productos)): ?>
              <?php foreach ($productos as $producto): ?>
                <tr class="text-gray-700 dark:text-gray-400">
                  <td class="px-4 py-3 text-sm">
                    <div class="flex items-center text-sm">
                      <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                        <img class="object-cover w-full h-full "
                          src="<?php echo esc(base_url() . $producto['Imagen_URL']); ?>"
                          alt="<?php echo esc($producto['Nombre']); ?>" />
                        <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                      </div>
                      <div>
                        <p class="font-semibold uppercase"><?php echo esc($producto['Nombre']); ?></p>
                      </div>
                    </div>
                  </td>
                  <td class="px-4 py-3 text-sm"><?php echo esc($producto['Descripcion']); ?></td>
                  <td class="px-4 py-3 text-sm"><?php echo esc($producto['Precio']); ?></td>
                  <td class="px-4 py-3 text-sm"><?php echo esc($producto['Stock']); ?></td>
                  <td class="px-4 py-3 text-sm"><?php echo $producto['Disponibilidad'] ? 'Disponible' : 'No disponible'; ?>
                  </td>
                  <td class="px-4 py-3">
                    <div class="flex items-center space-x-4 text-sm">
                      <button
                        class="openModalButton flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                        aria-label="Edit" data-producto-id="<?php echo $producto['ID']; ?>">
                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                          <path
                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                          </path>
                        </svg>
                      </button>
                      <form
                        action="<?= base_url('artesano/eliminar_producto/' . $producto['ID_Artesano'] . '/' . $producto['ID']) ?>"
                        method="post">
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
                <!-- Modal para cada producto -->
                <div
                  class="modal hidden fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"
                  id="modal-<?php echo $producto['ID']; ?>">
                  <div
                    class="modal-content w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl"
                    role="dialog">
                    <header class="flex justify-end">
                      <button
                        class="closeModalButton inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover:text-gray-700"
                        aria-label="close" data-producto-id="<?php echo $producto['ID']; ?>">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" role="img" aria-hidden="true">
                          <path
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd" fill-rule="evenodd"></path>
                        </svg>
                      </button>
                    </header>
                    <div class="mt-4 mb-6">
                      <p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">Editar Producto</p>
                      <!-- Formulario para editar producto -->
                      <form
                        action="<?= base_url('artesano/editar_productos/' . $producto['ID_Artesano'] . '/' . $producto['ID']) ?>"
                        method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="ID" value="<?php echo $producto['ID']; ?>">

                        <div class="mb-4">
                          <label for="ID_Producto" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Producto</label>
                          <select id="ID_Producto" name="ID_Producto" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
              focus:outline-none focus:shadow-outline-purple dark:text-gray-300 form-select" required>
                            <?php foreach ($productos_list as $prod): ?>
                              <option value="<?= esc($prod['ID']); ?>" <?= ($prod['ID'] == $producto['ID_Producto']) ? 'selected' : ''; ?>>
                                <?= esc($prod['Nombre']); ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                        </div>

                        <div class="mb-4">
                          <label for="Descripcion"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-400">Descripcion</label>
                          <input type="text" name="Descripcion" id="Descripcion"
                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 form-input"
                            placeholder="Ingrese la Descripcion" value="<?php echo $producto['Descripcion']; ?>">
                        </div>

                        <div class="mb-4">
                          <label for="Precio"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-400">Precio</label>
                          <input type="text" name="Precio" id="Precio"
                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 form-input"
                            placeholder="Ingrese el precio" value="<?php echo $producto['Precio']; ?>">
                        </div>

                        <div class="mb-4">
                          <label for="Stock"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-400">Stock</label>
                          <input type="number" name="Stock" id="Stock"
                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 form-input"
                            placeholder="Ingrese el stock" value="<?php echo $producto['Stock']; ?>">
                        </div>

                        <div class="mb-4">
                          <label for="Disponibilidad"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-400">Disponibilidad</label>
                          <select name="Disponibilidad" id="Disponibilidad"
                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 form-select">
                            <option value="1" <?= ($producto['Disponibilidad'] == 1) ? 'selected' : ''; ?>>Disponible</option>
                            <option value="0" <?= ($producto['Disponibilidad'] == 0) ? 'selected' : ''; ?>>No Disponible
                            </option>
                          </select>
                        </div>

                        <div class="mb-4">
                          <label for="Imagen_URL"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-400">Imagen</label>
                          <input type="file" name="Imagen_URL" id="Imagen_URL"
                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 form-input">
                        </div>

                        <!-- Botones del formulario -->
                        <footer
                          class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800">
                          <button type="button"
                            class="closeModalButton w-full px-5 py-3 text-sm font-medium leading-5 text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto hover:border-gray-500 focus:outline-none focus:shadow-outline-gray"
                            data-producto-id="<?php echo $producto['ID_Producto']; ?>">Cancelar</button>
                          <button type="submit"
                            class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">Aceptar</button>
                        </footer>
                      </form>
                    </div>
                  </div>
                </div>

              <?php endforeach; ?> <?php else: ?>
              <tr>
                <td colspan="7" class="text-center py-4">No se encontraron productos de artesanos.</td>
              </tr> <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>



  <!-- Modal backdrop. This what you want to place close to the closing body tag -->
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
        <button
          class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700"
          aria-label="close" @click="closeModal">
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" role="img" aria-hidden="true">
            <path
              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
              clip-rule="evenodd" fill-rule="evenodd"></path>
          </svg>
        </button>
      </header>
      <!-- Modal body -->
      <form action="<?= base_url('artesano/agregar_producto') ?>" method="post" enctype="multipart/form-data">
        <div class="mb-4">
          <label for="ID_Producto" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
            Producto</label>
          <select id="ID_Producto" name="ID_Producto" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
              focus:outline-none focus:shadow-outline-purple dark:text-gray-300 form-select" required>
            <?php foreach ($productos_list as $prod): ?>
              <?php //if (!in_array($prod['Nombre'], array_column($productos, 'Nombre'))): // Compara el nombre ?>
                <option value="<?= esc($prod['ID']); ?>">
                  <?= esc($prod['Nombre']); ?>
                </option>
              <?php //endif; ?>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="mb-4">
          <label for="Descripcion"
            class="block text-sm font-medium text-gray-700 dark:text-gray-400">Descripcion</label>
          <input type="text" name="Descripcion" id="Descripcion"
            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 form-input"
            placeholder="Ingrese la Descripcion">
        </div>

        <div class="mb-4">
          <label for="Precio" class="block text-sm font-medium text-gray-700 dark:text-gray-400">Precio</label>
          <input type="text" name="Precio" id="Precio"
            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 form-input"
            placeholder="Ingrese el precio">
        </div>

        <div class="mb-4">
          <label for="Stock" class="block text-sm font-medium text-gray-700 dark:text-gray-400">Stock</label>
          <input type="number" name="Stock" id="Stock"
            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 form-input"
            placeholder="Ingrese el stock">
        </div>

        <div class="mb-4">
          <label for="Disponibilidad"
            class="block text-sm font-medium text-gray-700 dark:text-gray-400">Disponibilidad</label>
          <select name="Disponibilidad" id="Disponibilidad"
            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 form-select">
            <option value="1" selected>Disponible</option>
            <option value="0">No Disponible</option>
          </select>
        </div>

        <div class="mb-4">
          <label for="Imagen_URL" class="block text-sm font-medium text-gray-700 dark:text-gray-400">Imagen</label>
          <input type="file" name="Imagen_URL" id="Imagen_URL"
            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 form-input">
        </div>


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
  <!-- End of modal backdrop -->



</main>
<script> document.querySelectorAll('.openModalButton').forEach(button => { button.addEventListener('click', () => { const productoId = button.getAttribute('data-producto-id'); document.getElementById(`modal-${productoId}`).classList.remove('hidden'); }); }); document.querySelectorAll('.closeModalButton').forEach(button => { button.addEventListener('click', () => { const productoId = button.getAttribute('data-producto-id'); document.getElementById(`modal-${productoId}`).classList.add('hidden'); }); }); </script>
</body>

</html>