<?php include 'header.php'; ?>
<main class="h-full overflow-y-auto">
    <div class="container mx-auto mt-8">
        <h2 class="text-2xl font-bold mb-4">Productos Vendidos</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            $productos_agrupados = [];

            foreach ($productos as $producto) {
                $descripcion = esc($producto['Descripcion']);
                if (!isset($productos_agrupados[$descripcion])) {
                    $productos_agrupados[$descripcion] = $producto;
                } else {
                    $productos_agrupados[$descripcion]['Cantidad'] += $producto['Cantidad'];
                }
            }

            if (count($productos_agrupados) > 0): ?>
                <?php foreach ($productos_agrupados as $producto): ?>
                    <div class="bg-white rounded-lg shadow-lg p-6 transition-transform transform hover:scale-105">
                        <img src="<?= esc($producto['Imagen_URL']); ?>" alt="<?= esc($producto['Descripcion']); ?>" class="h-48 w-full object-cover mb-4 rounded-lg">
                        <h3 class="text-lg font-bold"><?= esc($producto['Descripcion']); ?></h3>
                        <p class="text-gray-600">Cantidad vendida: <?= esc($producto['Cantidad']); ?></p>
                        <p class="text-gray-800 font-bold">Precio: <?= esc($producto['Precio']); ?> $</p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-gray-500">No se encontraron productos vendidos para este artesano.</p>
            <?php endif; ?>
        </div>
    </div>
</main>
</body>
</html>
