<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Iniciar Sesión</title>
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
              class="w-full object-cover h-full dark:hidden"
              src="<?=base_url()?>assets_dash/img/portadaimagen.png"
              alt="Office"
            />
            <img
              aria-hidden="true"
              class="hidden object-cover w-full h-full dark:block"
              src="<?=base_url()?>assets_dash/img/portadaimagen.png"
              alt="Office"
            />
          </div>
          <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
            <div class="w-full">
              <h1
                class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200"
              >
                Iniciar Sesión
              </h1>

              <!-- Flash messages -->
              <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
              <?php endif; ?>

              <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
              <?php endif; ?>

              <!-- Formulario de inicio de sesión -->
              <form method="post" action="<?= base_url('login') ?>">
                <div class="form-group">
                  <label class="block text-sm" for="Correo_electronico">
                    <span class="text-gray-700 dark:text-gray-400">Correo electrónico</span>
                    <input
                      type="email"
                      class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                      id="Correo_electronico"
                      name="Correo_electronico"
                      required
                    />
                  </label>
                </div>
                <div class="form-group mt-4">
                  <label class="block text-sm" for="Contrasena">
                    <span class="text-gray-700 dark:text-gray-400">Contraseña</span>
                    <input
                      type="password"
                      class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                      id="Contrasena"
                      name="Contrasena"
                      required
                    />
                  </label>
                </div>
                <button
                  type="submit"
                  class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                >
                  Iniciar Sesión
                </button>
              </form>

              <hr class="my-8" />

              <p class="text-center mt-3">
                ¿No tienes una cuenta? 
                <a
                  class="text-sm font-medium text-gr-600 dark:text-purple-400 hover:underline"
                  href="<?= base_url('register') ?>"
                >
                  Regístrate aquí
                </a>
              </p>
              
             
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
