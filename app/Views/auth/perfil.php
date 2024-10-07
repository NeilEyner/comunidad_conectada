<!DOCTYPE html>
<html lang="en" :class="{ 'theme-dark': dark }" x-data="data()">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Editar Perfil - E-Commerce Comunidades</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="<?= base_url() ?>assets_dash/css/tailwind.output.css" />
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="<?= base_url() ?>assets_dash/js/init-alpine.js"></script>
</head>

<body>
    <div class="flex items-center min-h-screen p-6 bg-gray-50 dark:bg-gray-900">
        <div class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800">
            <div class="flex flex-col overflow-y-auto ">

                <!-- Profile Image Section --> <!-- Form Section -->
                <div class="flex items-center justify-center p-6 sm:p-12">
                    <div class="w-full">
                        <h1 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200">Editar Perfil</h1>

                        <form action="<?= base_url('update_perfil/' . session()->get('ID')) ?>" method="post"
                            enctype="multipart/form-data" class="space-y-4">
                            <?= csrf_field() ?>

                            <!-- Name -->
                            <label class="block text-sm">
                                <span class="text-gray-700 dark:text-gray-400">Nombre</span>
                                <input
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                    type="text" name="Nombre" id="Nombre" value="<?= esc($usuario['Nombre']) ?>"
                                    required />
                            </label>

                            <!-- Email -->
                            <label class="block text-sm">
                                <span class="text-gray-700 dark:text-gray-400">Correo Electrónico</span>
                                <input
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                    type="email" name="Correo_electronico" id="Correo_electronico"
                                    value="<?= esc($usuario['Correo_electronico']) ?>" required />
                            </label>

                            <!-- Phone -->
                            <label class="block text-sm">
                                <span class="text-gray-700 dark:text-gray-400">Teléfono</span>
                                <input
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                    type="text" name="Telefono" id="Telefono"
                                    value="<?= esc($usuario['Telefono']) ?>" />
                            </label>

                            <!-- Password -->
                            <label class="block text-sm">
                                <span class="text-gray-700 dark:text-gray-400">Contraseña</span>
                                <input
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                    type="password" name="Contrasena" id="Contrasena"
                                    placeholder="Dejar en blanco para mantener la contraseña actual" />
                                <small class="text-gray-500 dark:text-gray-400">Deje en blanco si no desea cambiar la
                                    contraseña</small>
                            </label>

                            <!-- Address -->
                            <label class="block text-sm">
                                <span class="text-gray-700 dark:text-gray-400">Dirección</span>
                                <textarea
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                    name="Direccion" id="Direccion"><?= esc($usuario['Direccion']) ?></textarea>
                            </label>
                            <div class="flex justify-center h-32 md:h-auto rounded-lg">
                                <img aria-hidden="true" class="object-cover w-32 h-32 py-3  "
                                    src="<?= $usuario['Imagen_URL'] ?>" alt="Profile Edit Image" />
                            </div>
                            <!-- Profile Image -->
                            <label class="block text-sm">
                                <span class="text-gray-700 dark:text-gray-400">Imagen de Perfil</span>
                                <input
                                    class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-purple-600 file:text-white hover:file:bg-purple-700 focus:border-purple-400"
                                    type="file" name="Imagen_URL" id="Imagen_URL" />

                            </label>

                            <!-- Save Button -->
                            <div class="flex justify-center mt-6">
                                <button
                                    class="w-full px-4 py-2 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                    Guardar Cambios
                                </button>
                            </div>
                        </form>
                        <div class="flex justify-center mt-6">
                            <a href="<?php echo base_url(); ?>"
                                class="w-full px-4 py-2 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                volver
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>