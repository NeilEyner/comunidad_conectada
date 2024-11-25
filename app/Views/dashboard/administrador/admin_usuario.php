<?php include 'header_admin.php'; ?>
<main class="h-full overflow-y-auto">
  <div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">USUARIOS REGISTRADOS</h2>
    <div>
      <button @click="openModal" 
      class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple" >
      Agregar  </button>
    </div>
    <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">LISTA</h4>
    <div class="w-full overflow-hidden rounded-lg shadow-xs">
      <div class="w-full overflow-x-auto">
        <table class="w-full whitespace-no-wrap">
          <thead>
            <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
              <th class="px-4 py-3">Nombre</th>
              <th class="px-4 py-3">Correo</th>
              <th class="px-4 py-3">Estado</th>
              <th class="px-4 py-3">Última Conexión</th>
              <th class="px-4 py-3">Acciones</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
            <?php if (!empty($usuarios) && is_array($usuarios)): ?>
              <?php foreach ($usuarios as $usuario): ?>
                <tr class="text-gray-700 dark:text-gray-400">
                  <td class="px-4 py-3">
                    <div class="flex items-center text-sm">
                      <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                        <img class="object-cover w-full h-full rounded-full"
                          src="<?php echo esc(base_url().$usuario['Imagen_URL']); ?>" alt="<?php echo esc($usuario['Nombre']); ?>" />
                        <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                      </div>
                      <div>
                        <p class="font-semibold"><?php echo esc($usuario['Nombre']); ?></p>
                        <p class="text-xs text-gray-600 dark:text-gray-400"><?php echo esc($usuario['Telefono']); ?></p>
                      </div>
                    </div>
                  </td>
                  <td class="px-4 py-3 text-sm"><?php echo esc($usuario['Correo_electronico']); ?></td>
                  <td class="px-4 py-3 text-xs">
                    <span
                      class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100"><?php echo esc($usuario['Estado']); ?></span>
                  </td>
                  <td class="px-4 py-3 text-sm"><?php echo esc($usuario['Ultima_conexion']); ?></td>
                  <td class="px-4 py-3">
                    <div class="flex items-center space-x-4 text-sm">
                      <button
                        class="openModalButton flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                        aria-label="Edit" data-user-id="<?php echo $usuario['ID']; ?>">
                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                          <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                          </path>
                        </svg>
                      </button>
                      <form action="<?= base_url('administrador/eliminar_usuario/' . $usuario['ID']) ?>" method="post">
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

                <!-- Modal para editar usuario -->
                <div
                  class="modal hidden fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"
                  id="modal-<?php echo $usuario['ID']; ?>">
                  <div
                    class="modal-content w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl"
                    role="dialog">
                    <header class="flex justify-end">
                      <button
                        class="closeModalButton inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover:text-gray-700"
                        aria-label="close" data-user-id="<?php echo $usuario['ID']; ?>">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" role="img" aria-hidden="true">
                          <path
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd" fill-rule="evenodd"></path>
                        </svg>
                      </button>
                    </header>
                    <form action="<?= base_url('administrador/editar_usuario/' . $usuario['ID']) ?>" method="post"
                      enctype="multipart/form-data">
                      <div class="mt-4 mb-6">
                        <p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">Editar Usuario</p>

                        <!-- Campo para el nombre -->
                        <div class="mb-3">
                          <label for="Nombre" class="block text-sm text-gray-700 dark:text-gray-400">Nombre</label>
                          <input type="text" id="Nombre" name="Nombre" value="<?= esc($usuario['Nombre']); ?>" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
             focus:outline-none focus:shadow-outline-purple dark:text-gray-300 form-input" required>
                        </div>

                        <!-- Campo para el correo electrónico -->
                        <div class="mb-3">
                          <label for="Correo_electronico" class="block text-sm text-gray-700 dark:text-gray-400">Correo
                            Electrónico</label>
                          <input type="email" id="Correo_electronico" name="Correo_electronico"
                            value="<?= esc($usuario['Correo_electronico']); ?>" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
             focus:outline-none focus:shadow-outline-purple dark:text-gray-300 form-input" required>
                        </div>

                        <!-- Campo para el teléfono -->
                        <div class="mb-3">
                          <label for="Telefono" class="block text-sm text-gray-700 dark:text-gray-400">Teléfono</label>
                          <input type="text" id="Telefono" name="Telefono" value="<?= esc($usuario['Telefono']); ?>" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400
focus:outline-none focus:shadow-outline-purple dark:text-gray-300 form-input">
                        </div>

                        <!-- Campo para la contraseña -->
                        <div class="mb-3">
                          <label for="Contrasena" class="block text-sm text-gray-700 dark:text-gray-400">Contraseña (dejar
                            en blanco para mantener la misma)</label>
                          <input type="password" id="Contrasena" name="Contrasena" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
             focus:outline-none focus:shadow-outline-purple dark:text-gray-300 form-input">
                        </div>

                        <!-- Campo para el rol -->
                        <div class="mb-3">
                          <label for="ID_Rol" class="block text-sm text-gray-700 dark:text-gray-400">Rol</label>
                          <select id="ID_Rol" name="ID_Rol" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
              focus:outline-none focus:shadow-outline-purple dark:text-gray-300 form-select" required>
                            <?php foreach ($roles as $rol): ?>
                              <option value="<?= esc($rol['ID']); ?>" <?= ($rol['ID'] == $usuario['ID_Rol']) ? 'selected' : ''; ?>>
                                <?= esc($rol['Nombre']); ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                        </div>

                        <!-- Campo para la comunidad -->
                        <div class="mb-3">
                          <label for="ID_Comunidad" class="block text-sm text-gray-700 dark:text-gray-400">Comunidad</label>
                          <select id="ID_Comunidad" name="ID_Comunidad" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
              focus:outline-none focus:shadow-outline-purple dark:text-gray-300 form-select">
                            <option value="">Seleccionar comunidad</option>
                            <?php foreach ($comunidades as $comunidad): ?>
                              <option value="<?= esc($comunidad['ID']); ?>" <?= ($comunidad['ID'] == $usuario['ID_Comunidad']) ? 'selected' : ''; ?>>
                                <?= esc($comunidad['Nombre']); ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                        </div>

                        <!-- Campo para la imagen -->
                        <div class="mb-3">
                          <label for="Imagen_URL" class="block text-sm text-gray-700 dark:text-gray-400">Subir
                            Imagen</label>
                          <input type="file" id="Imagen_URL" name="Imagen_URL" accept="image/*" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
             focus:outline-none focus:shadow-outline-purple dark:text-gray-300 form-input">
                          <?php if (!empty($usuario['Imagen_URL'])): ?>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Imagen actual: <a
                                href="<?= base_url($usuario['Imagen_URL']); ?>" target="_blank">Ver Imagen</a></p>
                          <?php endif; ?>
                        </div>

                        <!-- Campo para el estado -->
                        <div class="mb-3">
                          <label for="Estado" class="block text-sm text-gray-700 dark:text-gray-400">Estado</label>
                          <select id="Estado" name="Estado" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 
              focus:outline-none focus:shadow-outline-purple dark:text-gray-300 form-select" required>
                            <option value="ACTIVO" <?= ($usuario['Estado'] == 'ACTIVO') ? 'selected' : ''; ?>>Activo</option>
                            <option value="INACTIVO" <?= ($usuario['Estado'] == 'INACTIVO') ? 'selected' : ''; ?>>Inactivo
                            </option>
                            <option value="SUSPENDIDO" <?= ($usuario['Estado'] == 'SUSPENDIDO') ? 'selected' : ''; ?>>
                              Suspendido</option>
                          </select>
                        </div>
                      </div>

                      <!-- Botones de acción -->
                      <footer class="flex justify-end px-6 py-3 bg-gray-50 dark:bg-gray-800">
                        <button type="button" class="closeModalButton w-full px-5 py-3 text-sm font-medium text-gray-700 border border-gray-300 
            rounded-lg dark:text-gray-400 sm:w-auto sm:px-4 sm:py-2" data-user-id="<?= esc($usuario['ID']); ?>">
                          Cancelar
                        </button>
                        <button type="submit" class="w-full px-5 py-3 text-sm font-medium text-white bg-purple-600 rounded-lg 
            sm:w-auto sm:px-4 sm:py-2 hover:bg-purple-700 focus:outline-none">
                          Actualizar
                        </button>
                      </footer>
                    </form>
                  </div>
                </div>

              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="5">No se encontraron usuarios.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

<!-- Modal backdrop. This what you want to place close to the closing body tag -->
<div
      x-show="isModalOpen"
      x-transition:enter="transition ease-out duration-150"
      x-transition:enter-start="opacity-0"
      x-transition:enter-end="opacity-100"
      x-transition:leave="transition ease-in duration-150"
      x-transition:leave-start="opacity-100"
      x-transition:leave-end="opacity-0"
      class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"
    >
      <!-- Modal -->
      <div
        x-show="isModalOpen"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 transform translate-y-1/2"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0  transform translate-y-1/2"
        @click.away="closeModal"
        @keydown.escape="closeModal"
        class="w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl"
        role="dialog"
        id="modal"
      >
        <!-- Remove header if you don't want a close icon. Use modal body to place modal tile. -->
        <header class="flex justify-end">
          <button
            class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700"
            aria-label="close"
            @click="closeModal"
          >
            <svg
              class="w-4 h-4"
              fill="currentColor"
              viewBox="0 0 20 20"
              role="img"
              aria-hidden="true"
            >
              <path
                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                clip-rule="evenodd"
                fill-rule="evenodd"
              ></path>
            </svg>
          </button>
        </header>
        <!-- Modal body -->
        <form action="<?= base_url('administrador/agregar_usuario') ?>" method="post" enctype="multipart/form-data">
                <label class="block text-sm">
                  <span class="text-gray-700 dark:text-gray-400">Nombre</span>
                  <input
                    type="text"
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    id="Nombre"
                    name="Nombre"
                    value="<?= old('Nombre') ?>"
                    required
                  />
                </label>

                <label class="block mt-4 text-sm">
                  <span class="text-gray-700 dark:text-gray-400">Correo electrónico</span>
                  <input
                    type="email"
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    id="Correo_electronico"
                    name="Correo_electronico"
                    value="<?= old('Correo_electronico') ?>"
                    required
                  />
                </label>

                <label class="block mt-4 text-sm">
                  <span class="text-gray-700 dark:text-gray-400">Teléfono</span>
                  <input
                    type="tel"
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    id="Telefono"
                    name="Telefono"
                    value="<?= old('Telefono') ?>"
                    required
                  />
                </label>

                <label class="block mt-4 text-sm">
                  <span class="text-gray-700 dark:text-gray-400">Contraseña</span>
                  <input
                    type="password"
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    id="Contrasena"
                    name="Contrasena"
                    required
                  />
                </label>

                <label class="block mt-4 text-sm">
                  <span class="text-gray-700 dark:text-gray-400">Rol</span>
                  <select
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    id="ID_Rol"
                    name="ID_Rol"
                    required >
                    <option value="">Seleccione un rol</option>
                    <?php foreach($roles as $rol): ?>
                        <option value="<?= $rol['ID'] ?>" <?= old('ID_Rol') == $rol['ID'] ? 'selected' : '' ?>><?= $rol['Nombre'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </label>

                <label class="block mt-4 text-sm">
                  <span class="text-gray-700 dark:text-gray-400">Dirección</span>
                  <textarea
                  
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    id="Direccion"
                    name="Direccion"
                    required
                  ><?= old('Direccion') ?></textarea>
                </label>

                <label class="block mt-4 text-sm">
                  <span class="text-gray-700 dark:text-gray-400">Comunidad</span>
                  <select
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    id="ID_Comunidad"
                    name="ID_Comunidad"
                    required
                  >
                    <option value="">Seleccione una comunidad</option>
                    <?php foreach($comunidades as $comunidad): ?>
                        <option value="<?= $comunidad['ID'] ?>" <?= old('ID_Comunidad') == $comunidad['ID'] ? 'selected' : '' ?>><?= $comunidad['Nombre'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </label>

                <label class="block mt-4 text-sm">
                  <span class="text-gray-700 dark:text-gray-400">Foto de Perfil</span>
                  <input
                    type="file"
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    id="imagen"
                    name="imagen"
                    accept=".jpg,.jpeg,.png" >
                </label>

                <button type="submit" class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                  Registrarse
                </button>
              </form>
        <footer
          class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800"
        >
          <button
            @click="closeModal"
            class="w-full px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray"
          >
            Cancel
          </button>

        </footer>
      </div>
</div>
<!-- End of modal backdrop -->



</main>

<script>
  document.querySelectorAll('.openModalButton').forEach(button => {
    button.addEventListener('click', () => {
      const userId = button.getAttribute('data-user-id');
      document.getElementById(`modal-${userId}`).classList.remove('hidden');
    });
  });

  document.querySelectorAll('.closeModalButton').forEach(button => {
    button.addEventListener('click', () => {
      const userId = button.getAttribute('data-user-id');
      document.getElementById(`modal-${userId}`).classList.add('hidden');
    });
  });
</script>

</body>

</html>