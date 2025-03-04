<?php include 'header.php'; ?>

<div class="product-container max-w-screen-lg mx-auto p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-8">Productos con Valoraciones</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 lg:grid-cols-4 gap-6">
        <?php 
        $productosAgrupados = [];
        foreach ($productos as $producto) {
            $productosAgrupados[$producto['ProductoID']] = $producto;
        }

        foreach ($productosAgrupados as $producto): ?>
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <img src="<?= base_url().$producto['Imagen_URL']; ?>" alt="<?= $producto['ProductoNombre']; ?>" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-800"><?= $producto['ProductoNombre']; ?></h3>
                    <p class="text-gray-600 text-sm mt-2"><?= $producto['ProductoDescripcion']; ?></p>
                    
                    <div class="mt-4 flex items-center justify-between">
                        <span class="text-green-600 font-bold text-lg">Bs. <?= number_format($producto['Precio'], 2); ?></span>
                        <span class="text-gray-500 text-sm"><?= $producto['Stock'] > 0 ? 'En Stock' : 'Agotado'; ?></span>
                    </div>
                    
                    <button 
                        class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600"
                        onclick="openModal('modal-<?= $producto['ProductoID']; ?>')">
                        Ver Valoraciones
                    </button>
                </div>
            </div>
            
            <!-- Modal -->
            <div 
                id="modal-<?= $producto['ProductoID']; ?>" 
                class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
                
                <div class="bg-white rounded-lg w-11/12 max-w-lg p-6 relative">
                    <button 
                        class="absolute top-2 right-2 text-gray-600 hover:text-gray-800"
                        onclick="closeModal('modal-<?= $producto['ProductoID']; ?>')">
                        ✖
                    </button>
                    <h3 class="text-xl font-bold mb-4"><?= $producto['ProductoNombre']; ?> - Valoraciones</h3>
                    
                    <div class="space-y-4">
                        <?php foreach ($productos as $valoracion): ?>
                            <?php if ($valoracion['ProductoID'] == $producto['ProductoID']): ?>
                                <div class="border-b pb-2">
                                    <div class="text-yellow-500">
                                        <?php for ($i = 0; $i < $valoracion['Puntuacion']; $i++): ?>
                                            ★
                                        <?php endfor; ?>
                                        <?php for ($i = $valoracion['Puntuacion']; $i < 5; $i++): ?>
                                            ☆
                                        <?php endfor; ?>
                                    </div>
                                    <p class="text-gray-600 mt-2"><?= $valoracion['ValoracionComentario']; ?></p>
                                    <p class="text-gray-400 text-xs"><?= date('d M Y', strtotime($valoracion['FechaValoracion'])); ?></p>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }
    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }
</script>

</body>
</html>
