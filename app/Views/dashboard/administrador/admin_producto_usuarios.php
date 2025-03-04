<?php include 'header_admin.php'; ?>
<main class="h-full overflow-y-auto">
  <div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">PRODUCTOS ARTESANO</h2>
    <div class="w-full overflow-hidden rounded-lg shadow-xs">
      <div class="w-full overflow-x-auto">
        <table class="w-full ">
          <thead>
            <tr
              class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">

              <th class="px-4 py-3">Nombre Producto</th>
              <th class="px-4 py-3">Descripción</th>
              <th class="px-4 py-3">Stock</th>
              <th class="px-4 py-3">Precio</th>
              <th class="px-4 py-3">Disponibilidad</th>
              <th class="px-4 py-3">Acciones</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
            <?php if (!empty($productos) && is_array($productos)): ?>
              <?php foreach ($productos as $producto): ?>
                <tr class="text-gray-700 dark:text-gray-400">

                  <td class="px-4 py-3">
                    <div class="flex items-center text-sm">
                      <div class="relative hidden w-12 h-12 mr-3 rounded-full md:block">
                        <img class="object-cover w-full h-full rounded-full"
                          src="<?php echo esc(base_url() . $producto['Imagen_URL']); ?>"
                          alt="<?php echo esc($producto['Producto']); ?>" />
                        <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                      </div>
                      <div>
                        <p class="font-semibold uppercase"><?php echo esc($producto['Producto']); ?></p>

                        <p class="text-xs text-gray-600 dark:text-gray-400"><?php echo esc($producto['Artesano']); ?></p>
                      </div>
                    </div>
                  </td>



                  <td class="px-4 py-3 text-sm"><?php echo esc($producto['Descripcion']); ?></td>
                  <td class="px-4 py-3 text-xl"><?php echo esc($producto['Stock']); ?></td>
                  <td class="px-4 py-3 text-sm">Bs. <?php echo esc($producto['Precio']); ?> </td>
                  <td class="px-12 py-3 text-sm items-center flex space-x-4">
                    <?php if ($producto['Disponibilidad'] == 1) { ?>
                      <span class="text-green-500 font-semibold">Disponible</span>
                      <form action="<?= base_url('admin/disponible_producto_artesano/' . $producto['ID']) ?>" method="POST"
                        class="inline-flex">
                        <input type="hidden" name="disponibilidad" value="0">
                        <button type="submit"
                          class="bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">Deshabilitar</button>
                      </form>
                    <?php } else { ?>
                      <span class="text-red-500 font-semibold">No Disponible</span>
                      <form action="<?= base_url('admin/disponible_producto_artesano/' . $producto['ID']) ?>" method="POST"
                        class="inline-flex">
                        <input type="hidden" name="disponibilidad" value="1">
                        <button type="submit"
                          class="bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">Habilitar</button>
                      </form>
                    <?php } ?>
                  </td>
                  <td class="px-4 py-3">
                    <div class="flex items-center space-x-4 text-sm">
                      <form action="<?= base_url('admin/eliminar_producto_artesano/' . $producto['ID']) ?>" method="post">
                        <button type="submit"
                          class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-red-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                          aria-label="Delete">
                          <svg class="w-8 h-8" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
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
                  id="modal-<?php echo $producto['ID_Artesano'] . $producto['ID_Producto']; ?>">
                  <div
                    class="modal-content w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl"
                    role="dialog">
                    <header class="flex justify-end">
                      <button
                        class="closeModalButton inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover:text-gray-700"
                        aria-label="close"
                        data-producto-id="<?php echo $producto['ID_Artesano'] . $producto['ID_Producto']; ?>">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" role="img" aria-hidden="true">
                          <path
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd" fill-rule="evenodd"></path>
                        </svg>
                      </button>
                    </header>
                    <div class="mt-4 mb-6">
                      <p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">Editar Producto</p>
                      <p class="text-sm text-gray-700 dark:text-gray-400">Producto ID:
                        <?php echo $producto['ID_Artesano'] . $producto['ID_Producto']; ?>
                      </p>

                      <!-- Formulario para editar producto -->
                      <form
                        action="<?= base_url('admin/editar_producto/' . $producto['ID_Artesano'] . $producto['ID_Producto']) ?>"
                        method="post">
                        <!-- ID del producto (oculto) -->
                        <input type="hidden" name="ID_Artesano"
                          value="<?php echo isset($producto['ID_Artesano']) ? $producto['ID_Artesano'] : ''; ?>">
                        <input type="hidden" name="ID_Producto"
                          value="<?php echo isset($producto['ID_Producto']) ? $producto['ID_Producto'] : ''; ?>">

                        <div class="mb-4">
                          <label for="Nombre"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-400">Nombre</label>
                          <input type="text" name="Nombre" id="Nombre"
                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 form-input"
                            value="<?php echo isset($producto['Nombre']) ? $producto['Nombre'] : ''; ?>"
                            placeholder="Ingrese el nombre del producto" required>
                        </div>

                        <div class="mb-4">
                          <label for="Descripcion"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-400">Descripción</label>
                          <textarea name="Descripcion" id="Descripcion"
                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 form-textarea"
                            placeholder="Ingrese la descripción del producto"><?php echo isset($producto['Descripcion']) ? $producto['Descripcion'] : ''; ?></textarea>
                        </div>

                        <!-- Botones del formulario -->
                        <footer
                          class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800">
                          <button type="button"
                            class="closeModalButton w-full px-5 py-3 text-sm font-medium leading-5 text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto hover:border-gray-500 focus:outline-none focus:shadow-outline-gray"
                            data-producto-id="<?php echo isset($producto['ID_Artesano']) ? $producto['ID_Artesano'] : ''; ?>">Cancelar</button>
                          <button type="submit"
                            class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">Aceptar</button>
                        </footer>
                      </form>

                    </div>
                  </div>
                </div>

              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="5">No se encontraron productos.</td>
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
      const productoId = button.getAttribute('data-producto-id');
      document.getElementById(`modal-${productoId}`).classList.remove('hidden');
    });
  });

  document.querySelectorAll('.closeModalButton').forEach(button => {
    button.addEventListener('click', () => {
      const productoId = button.getAttribute('data-producto-id');
      document.getElementById(`modal-${productoId}`).classList.add('hidden');
    });
  });
</script>

</body>

</html>