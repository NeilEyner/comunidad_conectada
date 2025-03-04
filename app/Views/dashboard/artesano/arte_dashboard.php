<?php include 'header.php'; ?>
<?php
$productos_en_stock = 0;
foreach ($productos as $product) {
  $productos_en_stock += $product['Stock'];
}

$producto_vendidos = 0;
$ganancia_vendidos = 0;
foreach ($ventas as $ven) {
  $producto_vendidos += $ven['Cantidad'];
  $ganancia_vendidos += $ven['Total_Venta'];
}
?>
<main class="h-full overflow-y-auto">
  <div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
      PANEL DE CONTROL
    </h2>
    <!-- CTA -->
    <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">


      <!-- Card: Total Products -->
      <div class="card flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
        <div
          class="icon-container p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-label="Total Products Icon">
            <path fill-rule="evenodd"
              d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
              clip-rule="evenodd"></path>
          </svg>
        </div>
        <div>
          <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">TOTAL DE PRODUCTOS</p>
          <p class="text-lg font-semibold text-gray-700 dark:text-gray-200"><?php echo count($productos); ?></p>
        </div>
      </div>

      <!-- Card: Total Purchases -->
      <div class="card flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
        <div class="icon-container p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-label="Total Purchases Icon">
            <path
              d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z">
            </path>
          </svg>
        </div>
        <div>
          <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">PRODUCTOS VENDIDOS</p>
          <p class="text-lg font-semibold text-gray-700 dark:text-gray-200"><?php echo $producto_vendidos; ?></p>
        </div>
      </div>

      <!-- Card: Total Shipments -->
      <div class="card flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
        <div class="icon-container p-3 mr-4 text-teal-500 bg-teal-100 rounded-full dark:text-teal-100 dark:bg-teal-500">
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-label="Total Shipments Icon">
            <path fill-rule="evenodd"
              d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z"
              clip-rule="evenodd"></path>
          </svg>
        </div>
        <div>
          <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">TOTAL DE GANANCIA</p>
          <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">Bs.
            <?php echo number_format($ganancia_vendidos, 2); ?></p>
        </div>
      </div>
      <!-- Card: Total Users -->
      <div class="card flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
        <div
          class="icon-container p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-label="Total Users Icon">
            <path
              d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
            </path>
          </svg>
        </div>
        <div>
          <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">PRODUCTOS EN STOCK</p>
          <p class="text-lg font-semibold text-gray-700 dark:text-gray-200"><?php echo $productos_en_stock; ?></p>
        </div>
      </div>
    </div>

    <!-- Styling improvements -->
    <style>
      .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
      }

      .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      }

      .icon-container svg {
        transition: transform 0.2s ease;
      }

      .icon-container:hover svg {
        transform: scale(1.1);
      }
    </style>

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
                      <img class="object-cover w-full h-full "
                        src="<?php echo esc(base_url() . $producto['Imagen_URL']); ?>"
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