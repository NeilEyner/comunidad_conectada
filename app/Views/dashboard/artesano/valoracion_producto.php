<?php include 'header.php'; ?>
<main class="bg-gray-50 p-4">
    <div class="container mx-auto mt-8 p-4 bg-white rounded-lg shadow">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-4">Productos Mejor Puntuados</h2>

        <table class="min-w-full border-collapse">
            <thead class="bg-gray-200 text-gray-800">
                <tr>
                    <th class="p-3 text-left">Imagen</th>
                    <th class="p-3 text-left">Descripción</th>
                    <th class="p-3 text-left">Stock</th>
                    <th class="p-3 text-left">Puntuación</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                    <tr class="hover:bg-gray-100 transition-colors border-b">
                        <td class="p-3">
                            <img src="<?= esc(base_url().$producto['Imagen_URL']); ?>" alt="<?= esc($producto['Descripcion']); ?>" class="h-16 w-auto object-cover rounded-md">
                        </td>
                        <td class="p-3 text-gray-800"><?= esc($producto['Descripcion']); ?></td>
                        <td class="p-3 text-gray-800"><?= esc($producto['Stock']); ?></td>
                        <td class="p-3">
                            <ul class="flex space-x-1">
                                <?php 
                                $puntuacion = round($producto['Puntuacion']);
                                for ($i = 1; $i <= 5; $i++): ?>
                                    <li>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 <?= $i <= $puntuacion ? 'text-yellow-500' : 'text-gray-300'; ?>" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 .587l3.668 7.431 8.243 1.191-5.95 5.787 1.407 8.228L12 18.896l-7.368 3.867 1.407-8.228-5.95-5.787 8.243-1.191z"/>
                                        </svg>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

</body>
</html>
