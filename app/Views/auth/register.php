<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registro de Usuario - E-Commerce Comunidades</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="<?=base_url()?>assets_dash/css/tailwind.output.css" />
    <script
      src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"
      defer
    ></script>
    <script src="<?=base_url()?>assets_dash/js/init-alpine.js"></script>
  </head>
  <body>
    <div class="flex items-center min-h-screen p-6 bg-gray-50 dark:bg-gray-900">
      <div
        class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800"
      >
        <div class="flex flex-col overflow-y-auto md:flex-row">
          <div class="h-32 md:h-auto md:w-1/2">
            <img
              aria-hidden="true"
              class="w-full h-full dark:hidden"
              src="<?=base_url()?>assets_dash/img/logos/Logo_03.png"
              alt="Office"
            />
            <img
              aria-hidden="true"
              class="hidden object-cover w-full h-full dark:block"
              src="<?=base_url()?>assets_dash/img/logos/Logo_03.png"
              alt="Office"
            />
          </div>
          <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
            <div class="w-full">
              <h2 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200 text-center">
                Registro de Usuario
              </h2>

              <!-- Mostrar errores -->
              <?php if(session()->getFlashdata('errors')): ?>
                <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800">
                    <ul>
                    <?php foreach(session()->getFlashdata('errors') as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                    </ul>
                </div>
              <?php endif; ?>

              <form action="<?= base_url('register') ?>" method="post">
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
                    required
                  >
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

                <button
                  type="submit"
                  class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                >
                  Registrarse
                </button>
              </form>

              <p class="mt-4 text-center">
                <a
                  class="text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline"
                  href="<?= base_url('login') ?>"
                >
                  ¿Ya tienes una cuenta? Inicia sesión aquí
                </a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
