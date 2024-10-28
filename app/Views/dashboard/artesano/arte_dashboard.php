<?php include 'header.php'; ?>
<main class="h-full overflow-y-auto">
  <div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
      Dashboard
    </h2>
    <!-- CTA -->


    <!-- New Table -->
    <div class="w-full overflow-hidden rounded-lg shadow-xs">
      <div class="w-full overflow-x-auto">
        <table class="w-full">
          <thead>
            <tr
              class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
              <th class="px-4 py-3">Producto</th>
              <th class="px-4 py-3">Descripción</th>
              <th class="px-4 py-3">Precio</th>
              <th class="px-4 py-3">Stock</th>
              <th class="px-4 py-3">Disponibilidad</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
            <?php foreach ($productos as $producto): ?>
              <tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3 text-sm">
                  <div class="flex items-center text-sm">
                    <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                      <img class="object-cover w-full h-full " src="<?php echo esc(base_url().$producto['Imagen_URL']); ?>"
                        alt="<?php echo esc($producto['Nombre']); ?>" />
                      <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                    </div>
                    <div>
                      <p class="font-semibold"><?php echo esc($producto['Nombre']); ?></p>
                      <!-- <p class="text-xs text-gray-600 dark:text-gray-400"><?php echo esc($producto['Nombre']); ?></p> -->
                    </div>
                  </div>

                </td>
                <td class="px-4 py-3 text-sm"><?= $producto['Descripcion'] ?></td>
                <td class="px-4 py-3 text-sm">Bs. <?= number_format($producto['Precio'], 2) ?></td>
                <td class="px-4 py-3 text-sm"><?= $producto['Stock'] ?></td>
                <td class="px-4 py-3 text-xs">
                  <?php if ($producto['Disponibilidad']): ?>
                    <span
                      class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">Disponible</span>
                  <?php else: ?>
                    <span
                      class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">No
                      disponible</span>
                  <?php endif; ?>
                </td>

              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</main>
</div>
</div>
</body>

</html>