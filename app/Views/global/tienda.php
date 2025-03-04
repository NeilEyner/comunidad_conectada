<style>
    /* Estilos adicionales para los modales y elementos nuevos */
    .shadow-hover:hover {
        transform: scale(1.03);
        transition: transform 0.3s ease;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12), 0 4px 8px rgba(0, 0, 0, 0.06);
    }

    .card-img-top-container {
        height: 250px;
        overflow: hidden;
    }

    .card-img-top {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .card-img-top:hover {
        transform: scale(1.1);
    }

    /* Estilo para las estrellas de calificación */
    #calificacionDetalleProducto {
        color: #ffc107;
        font-size: 1.2rem;
    }

    /* Estilos adicionales personalizados */
    .sidebar {
        height: 200vh;
        border-right: 1px solid #e3e3e3;
    }

    .categoria-filter {
        color: #6c757d;
        transition: all 0.3s ease;
    }

    .categoria-filter:hover,
    .categoria-filter.active {
        color: #007bff;
        background-color: rgba(0, 123, 255, 0.1);
    }

    /* Vista de lista */
    #productos-container.list-view .producto-item {
        width: 100%;
    }

    #productos-container.list-view .card {
        flex-direction: row;
    }

    #productos-container.list-view .card-img-top {
        width: 200px;
        height: 200px;
        object-fit: cover;
    }

    /* Custom CSS for enhanced modals */
    .modal-custom-header {
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        color: white;
        padding: 1rem;
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
    }

    .product-image {
        max-height: 300px;
        object-fit: cover;
        border-radius: 15px;
        transition: transform 0.3s ease;
    }

    .product-image:hover {
        transform: scale(1.05);
    }

    .star-rating {
        cursor: pointer;
        color: #ddd;
        font-size: 2rem;
        transition: color 0.2s;
    }

    .star-rating.active {
        color: #ffc107;
    }

    .modal-details {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 15px;
    }
</style>
<!-- global/tienda.php -->
<div class="container-fluid px-4 py-4">
    <div class="row">
        <!-- Sidebar Categories - Igual que antes -->
        <div class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
            <div class="position-sticky pt-1">
                <h5 class="sidebar-heading px-3 mt-4 mb-3 text-muted">
                    <i class="bi bi-archive me-2"></i>Categorías
                </h5>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link categoria-filter active" href="#" data-categoria="all">
                            <i class="bi bi-grid-fill me-2"></i>Todos los Productos
                        </a>
                    </li>
                    <?php foreach ($categorias as $categoria): ?>
                        <li class="nav-item">
                            <a class="nav-link categoria-filter" href="#" data-categoria="<?= $categoria['Nombre'] ?>">
                                <?= $categoria['Nombre'] ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <!-- Main Product Grid -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Tienda Artesanal</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="grid-view">
                            <i class="bi bi-grid-3x3-gap"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="list-view">
                            <i class="bi bi-list-ul"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="row" id="productos-container">
                <?php
                $productosPorPagina = 8;
                $paginaActual = $_GET['pagina'] ?? 1;
                $inicio = ($paginaActual - 1) * $productosPorPagina;
                $productosPagina = array_slice($productos, $inicio, $productosPorPagina);
                ?>

                <?php foreach ($productosPagina as $producto): ?>
                    <div class="col-md-3 producto-item mb-4"
                        data-categorias="<?= str_replace(',', ' ', $producto['Categorias']) ?>"
                        data-nombre="<?= $producto['ProductoNombre'] ?>">
                        <div class="card h-100 shadow-hover">
                            <div class="card-img-top-container">
                                <img src="<?= $producto['Imagen_URL'] ?>" class="card-img-top producto-imagen"
                                    alt="<?= $producto['ProductoNombre'] ?>">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title text-truncate"><?= $producto['ProductoNombre'] ?></h5>
                                <p class="card-text">
                                    <span class="badge bg-primary mb-2"><?= $producto['ArtesanoNombre'] ?></span>
                                    <span class="badge bg-secondary mb-2"><?= $producto['ArtesanoComunidad'] ?></span>
                                    <br>
                                    <strong class="text-success">Bs. <?= number_format($producto['Precio'], 2) ?></strong>
                                </p>
                                <div class="d-flex justify-content-between x">
                                    <button
                                        class="btn btn-outline-info btn-sm rounded me-2 <?= !isset($_SESSION['ID']) ? 'w-100' : '' ?>"
                                        data-bs-toggle="modal" data-bs-target="#modalDetalles<?= $producto['ID'] ?>">
                                        <i class="bi bi-eye"></i> Detalles
                                    </button>

                                    <?php if (isset($_SESSION['ID'])): ?>
                                        <button class="btn btn-outline-warning btn-sm rounded me-2" data-bs-toggle="modal"
                                            data-bs-target="#modalPuntuacion<?= $producto['ID'] ?>">
                                            <i class="bi bi-star"></i> Calificar
                                        </button>
                                        <button class="btn btn-outline-primary btn-sm rounded" data-bs-toggle="modal"
                                            data-bs-target="#modalCarrito<?= $producto['ID'] ?>">
                                            <i class="bi bi-cart-plus"></i> Añadir
                                        </button>
                                    <?php endif; ?>
                                </div>

                                <div class="text-center mt-2">
                                    <small class="text-muted">
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <?= $producto['PuntuacionPromedio'] ?> |
                                        Stock: <?= $producto['Stock'] ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Detalles Modal -->
                    <div class="modal fade" id="modalDetalles<?= $producto['ID'] ?>" tabindex="-1">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content shadow-lg">
                                <div class="modal-custom-header d-flex justify-content-between align-items-center">
                                    <h5 class="modal-title"><?= $producto['ProductoNombre'] ?></h5>
                                    <button type="button" class="btn-close btn-close-white"
                                        data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <img src="<?= $producto['Imagen_URL'] ?>" class="img-fluid product-image mb-3"
                                                alt="Imagen del Producto">
                                        </div>

                                        <div class="col-md-9 modal-details">
                                            <p><strong>Descripción:</strong> <?= $producto['Descripcion'] ?></p>
                                            <p><strong>Precio:</strong> Bs. <?= number_format($producto['Precio'], 2) ?></p>
                                            <p><strong>Stock Disponible:</strong> <?= $producto['Stock'] ?></p>
                                            <p><strong>Artesano:</strong> <?= $producto['ArtesanoNombre'] ?>
                                                (<?= $producto['ArtesanoComunidad'] ?>)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Calificación Modal -->
                    <div class="modal fade" id="modalPuntuacion<?= $producto['ID'] ?>" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-custom-header">
                                    <h5 class="modal-title">Califica el Producto</h5>
                                </div>
                                <form action="<?= base_url('calificacion/producto/') . $producto['ID'] ?>" method="post"
                                    id="ratingForm<?= $producto['ID'] ?>">
                                    <div class="modal-body text-center">
                                        <input type="hidden" name="producto_id" value="<?= $producto['ID'] ?>">
                                        <img src="<?= $producto['Imagen_URL'] ?>" class="img-fluid rounded mb-3"
                                            style="max-height: 150px;" alt="Producto">
                                        <h4><?= $producto['ProductoNombre'] ?></h4>
                                        <div class="star-rating-container mb-3">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <span class="star-rating" data-rating="<?= $i ?>">★</span>
                                            <?php endfor; ?>
                                            <input type="hidden" name="puntuacion" id="ratingInput<?= $producto['ID'] ?>"
                                                value="3">
                                        </div>

                                        <div class="mb-3">
                                            <textarea name="comentarios" class="form-control" rows="4"
                                                placeholder="Deja tu comentario (opcional)"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-primary">Enviar Calificación</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Carrito Modal -->
                    <div class="modal fade" id="modalCarrito<?= $producto['ID'] ?>" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-custom-header">
                                    <h5 class="modal-title">Añadir al Carrito</h5>
                                </div>
                                <form action="<?= base_url('cliente/producto/') . $producto['ID'] ?>" method="POST">
                                    <div class="modal-body text-center">
                                        <input type="hidden" name="producto_id" value="<?= $producto['ID'] ?>">
                                        <img src="<?= $producto['Imagen_URL'] ?>" class="img-fluid rounded-circle mb-3"
                                            style="max-height: 150px;" alt="Producto">
                                        <h4><?= $producto['ProductoNombre'] ?></h4>
                                        <div class="mb-3">
                                            <label for="cantidad<?= $producto['ID'] ?>" class="form-label">Cantidad:</label>
                                            <div class="input-group justify-content-center">
                                                <button class="btn btn-outline-secondary" type="button"
                                                    onclick="decreaseQuantity(<?= $producto['ID'] ?>)">-</button>
                                                <input type="number" name="cantidad" id="cantidad<?= $producto['ID'] ?>"
                                                    class="form-control text-center" min="1" max="<?= $producto['Stock'] ?>"
                                                    value="1" style="max-width: 100px;">
                                                <button class="btn btn-outline-secondary" type="button"
                                                    onclick="increaseQuantity(<?= $producto['ID'] ?>)">+</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-primary">Añadir al Carrito</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <nav aria-label="Navegación de productos" class="mt-4">
                <ul class="pagination justify-content-center">
                    <?php
                    $totalPaginas = ceil(count($productos) / $productosPorPagina);
                    for ($i = 1; $i <= $totalPaginas; $i++): ?>
                        <li class="page-item ">
                            <a class="page-link" style="<?= $i == $paginaActual ? 'background:green; color:white;' : '' ?>"
                                href="?pagina=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        </main>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Filtro de categorías
        const categoriaLinks = document.querySelectorAll('.categoria-filter');
        categoriaLinks.forEach(link => {
            link.addEventListener('click', function (e) {
                const categoriaSel = this.getAttribute('data-categoria');
                categoriaLinks.forEach(l => l.classList.remove('active'));
                this.classList.add('active');
                const productos = document.querySelectorAll('.producto-item');
                productos.forEach(producto => {
                    if (categoriaSel === 'all' ||
                        producto.getAttribute('data-categorias').includes(categoriaSel)) {
                        producto.style.display = 'block';
                    } else {
                        producto.style.display = 'none';
                    }
                });
            });
        });
        const gridView = document.getElementById('grid-view');
        const listView = document.getElementById('list-view');
        const productosContainer = document.getElementById('productos-container');

        gridView.addEventListener('click', () => {
            productosContainer.classList.remove('list-view');
            productosContainer.classList.add('grid-view');
        });

        listView.addEventListener('click', () => {
            productosContainer.classList.remove('grid-view');
            productosContainer.classList.add('list-view');
        });
    });
</script>

<script>
    // Star Rating Interaction
    document.querySelectorAll('.star-rating-container').forEach(container => {
        const productId = container.closest('form').querySelector('input[name="producto_id"]').value;
        const stars = container.querySelectorAll('.star-rating');
        const ratingInput = document.getElementById(`ratingInput${productId}`);

        stars.forEach(star => {
            star.addEventListener('mouseover', () => {
                const rating = star.getAttribute('data-rating');
                stars.forEach((s, index) => {
                    s.classList.toggle('active', index < rating);
                });
            });

            star.addEventListener('click', () => {
                const rating = star.getAttribute('data-rating');
                ratingInput.value = rating;
            });
        });

        container.addEventListener('mouseleave', () => {
            const currentRating = ratingInput.value;
            stars.forEach((s, index) => {
                s.classList.toggle('active', index < currentRating);
            });
        });
    });

    // Quantity Control Functions
    // Quantity Control Functions
    function decreaseQuantity(productId) {
        const input = document.getElementById(`cantidad${productId}`);
        let currentValue = parseInt(input.value);
        if (currentValue > 1) {
            input.value = currentValue - 1;
        }
    }

    function increaseQuantity(productId) {
        const input = document.getElementById(`cantidad${productId}`);
        const max = parseInt(input.getAttribute('max'));
        let currentValue = parseInt(input.value);
        if (currentValue < max) {
            input.value = currentValue + 1;
        }
    }

</script>