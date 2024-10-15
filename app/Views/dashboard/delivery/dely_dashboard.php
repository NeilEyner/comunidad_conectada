<?php include 'header.php'; ?>
<main class="h-full overflow-y-auto">
  <div class="container px-6 mx-auto">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
      Realizar Envíos
    </h2>

    <?php if (!empty($compras)): ?>
      <div class="overflow-x-auto">
        <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
          <thead>
            <tr>
              <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-200 border-b">Compra ID</th>
              <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-200 border-b">Producto</th>
              <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-200 border-b">Cantidad</th>
              <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-200 border-b">Total</th>
              <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-200 border-b">Imagen</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $currentCompraID = null;
            ?>
            <?php foreach ($compras as $index => $compra): ?>
              <?php if ($currentCompraID !== $compra->ID): ?>
                <?php $currentCompraID = $compra->ID; ?>
              <?php endif; ?>
              <tr>
                <td class="px-4 py-2 border-b"><?= $compra->ID ?></td>
                <td class="px-4 py-2 border-b"><?= $compra->Nombre ?></td>
                <td class="px-4 py-2 border-b"><?= $compra->Cantidad ?></td>
                <td class="px-4 py-2 border-b">$<?= $compra->Total ?></td>
                <td class="px-4 py-2 border-b">
                <div style="width: 96px; height: 96px;" class="mr-3">
                  <img class="object-cover w-full h-full rounded-md shadow-sm" src="<?= base_url() . $compra->Imagen_URL ?>"
                    alt="Producto">
                </div>                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <p class="text-center text-gray-500 dark:text-gray-400">No hay envíos pendientes.</p>
    <?php endif; ?>
  </div>
</main>
