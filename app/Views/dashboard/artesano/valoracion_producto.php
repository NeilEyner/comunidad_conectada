<?php include 'header.php'; ?>

<div class="product-container max-w-screen-lg mx-auto p-4">
    <h2 class="text-xl font-semibold text-gray-800 mb-6">Productos Puntuados</h2>

    <?php foreach ($productos as $producto): ?>
        <div class="product-card bg-white shadow-md rounded-lg mb-6 p-6 flex flex-col items-center">
            <!-- Imagen del producto -->
            <img src="<?= esc(base_url() . $producto['Imagen_URL']); ?>" alt="<?= esc($producto['Descripcion']); ?>" class="w-48 h-48 object-cover rounded-md mb-6">

            <!-- Nombre o descripción del producto -->
            <div class="product-name text-lg font-semibold text-gray-900 mb-2"><?= esc($producto['Descripcion']); ?></div>

            <!-- Mostrar la mejor puntuación con estrellas -->
            <div class="rating flex items-center mb-4">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 <?= ($i <= $producto['MejorPuntuacion']) ? 'text-yellow-400' : 'text-gray-300' ?>" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M12 17.75l5.55 3.25-1.45-6.35L22 9.25h-6.5L12 2 8.5 9.25H2l4.9 5.65-1.45 6.35z"/>
                    </svg>
                <?php endfor; ?>
            </div>

            <!-- Mostrar el promedio de puntuaciones -->
            <div class="average-rating text-sm text-gray-600 mb-4">
                Promedio: <?= number_format(esc($producto['PromedioPuntuacion']), 2); ?>/5
            </div>

            <!-- Mostrar el total de puntuaciones -->
            <div class="total-rating text-sm text-gray-600">
                <?= esc($producto['TotalPuntuaciones']); ?> valoraciones
            </div>
        </div>
    <?php endforeach; ?>
</div>



</body>

</html>