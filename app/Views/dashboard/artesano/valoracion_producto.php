<?php include 'header.php'; ?>
<style>
    .product-container {
        max-width: 600px;
        margin: 0 auto;
        padding: 1rem;
    }

    .product-header {
        font-size: 1.5rem;
        font-weight: bold;
        text-align: center;
        color: #333;
        margin-bottom: 1rem;
    }

    .product-card {
        display: flex;
        align-items: center;
        padding: 0.75rem;
        margin-bottom: 0.75rem;
        border-radius: 8px;
        background-color: #fff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s;
    }

    .product-card:hover {
        transform: scale(1.02);
    }

    .product-image {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 6px;
        margin-right: 1rem;
    }

    .product-details {
        flex-grow: 1;
    }

    .product-name {
        font-size: 1rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 0.25rem;
    }

    .product-stock {
        font-size: 0.875rem;
        color: #555;
        margin-bottom: 0.25rem;
    }

    .rating {
        display: flex;
        align-items: center;
    }

    .rating-bar {
        position: relative;
        width: 80px;
        height: 8px;
        background-color: #e5e5e5;
        border-radius: 4px;
        overflow: hidden;
        margin-right: 0.5rem;
    }

    .rating-text {
        font-size: 0.875rem;
        color: #666;
    }
</style>

<main class="bg-gray-100">
    <div class="product-container">
        <h2 class="product-header">Productos Mejor Puntuados</h2>

        <?php foreach ($productos as $producto): ?>
            <div class="product-card">
                <img src="<?= esc(base_url() . $producto['Imagen_URL']); ?>" alt="<?= esc($producto['Descripcion']); ?>"
                    class="product-image">
                <div class="product-details">
                    <div class="product-name"><?= esc($producto['Descripcion']); ?></div>
                    <div class="product-stock">Stock: <?= esc($producto['Stock']); ?></div>
                    <div class="rating">
                        <style>
                            .rating-fill {
                                height: 100%;
                                background-color: #fbbf24;
                                width: calc(20% *
                                        <?= esc($producto['Puntuacion']); ?>
                                    );
                            }
                        </style>
                        <div class="rating-bar">
                            <div class="rating-fill" style="width: <?= esc($producto['Puntuacion']) * 20; ?>%;"></div>
                        </div>
                        <span class="rating-text"><?= esc($producto['Puntuacion']); ?>/5</span>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

</body>

</html>