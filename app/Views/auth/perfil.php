<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <!-- Reemplazamos Google Maps por Leaflet -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>
    <!-- Añadimos el plugin de búsqueda para Leaflet -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet-search/3.0.9/leaflet-search.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-search/3.0.9/leaflet-search.min.js"></script>
    <style>
        .profile-header {
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            padding: 2rem 0;
            margin-bottom: 2rem;
        }

        .profile-picture {
            position: relative;
            width: 150px;
            height: 150px;
            margin: 0 auto;
        }

        .profile-picture img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 4px solid white;
            object-fit: cover;
        }

        .profile-picture .edit-icon {
            position: absolute;
            bottom: 0;
            right: 0;
            background: #fff;
            border-radius: 50%;
            padding: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }

        #map {
            height: 300px;
            width: 100%;
            border-radius: 8px;
        }

        .form-floating {
            margin-bottom: 1rem;
        }

        .community-selector {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .community-card {
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .community-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .community-card.selected {
            border-color: #6366f1;
        }

        .community-image {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 4px;
        }

        #map {
            height: 300px;
            width: 100%;
            border-radius: 8px;
            z-index: 1;
            /* Asegura que el mapa esté por debajo de los elementos flotantes */
        }

        .location-search {
            margin-bottom: 10px;
        }

        .coordinates-display {
            font-size: 0.8rem;
            color: #666;
            margin-top: 5px;
        }
    </style>
</head>

<body>

    <div class="profile-header text-white text-center">
        <div class="container">
            <div class="profile-picture mb-3">
                <img src="<?= base_url() . $usuario['Imagen_URL'] ?? '/images/default-avatar.png' ?>" alt="Foto de perfil"
                    id="profileImage">

            </div>
            <h2><?= $usuario['Nombre'] ?></h2>
            <p class="mb-0"><i class="ri-mail-line me-2"></i><?= $usuario['Correo_electronico'] ?></p>
        </div>
    </div>

    <div class="container pb-5">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title mb-4">
                            <i class="ri-user-settings-line me-2"></i>
                            Editar Perfil
                        </h4>

                        <form action="<?= base_url('update_perfil/' . $usuario['ID']) ?>" method="POST"
                            enctype="multipart/form-data" id="profileForm">

                            <!-- Campos básicos -->
                            <div class="form-floating">
                                <input type="text" class="form-control" id="nombre" name="Nombre" placeholder="Nombre"
                                    value="<?= $usuario['Nombre'] ?>">
                                <label for="nombre">Nombre completo</label>
                            </div>

                            <div class="form-floating">
                                <input type="email" class="form-control" id="email" name="Correo_electronico"
                                    placeholder="Email" value="<?= $usuario['Correo_electronico'] ?>">
                                <label for="email">Correo electrónico</label>
                            </div>

                            <div class="form-floating">
                                <input type="tel" class="form-control" id="telefono" name="Telefono"
                                    placeholder="Teléfono" value="<?= $usuario['Telefono'] ?>">
                                <label for="telefono">Teléfono</label>
                            </div>
                            <!-- Campo de Género -->
                            <div class="form-floating">
                                <select class="form-control" id="genero" name="Genero">
                                    <option value="MASCULINO" <?= $usuario['Genero'] == 'masculino' ? 'selected' : '' ?>>
                                        Masculino</option>
                                    <option value="FEMENINO" <?= $usuario['Genero'] == 'femenino' ? 'selected' : '' ?>>
                                        Femenino</option>
                                    <option value="OTRO" <?= $usuario['Genero'] == 'otro' ? 'selected' : '' ?>>Otro
                                    </option>
                                </select>
                                <label for="genero">Género</label>
                            </div>

                            <!-- Campo de Fecha de Nacimiento -->
                            <div class="form-floating">
                                <input type="date" class="form-control" id="fecha_nacimiento" name="Fecha_nacimiento"
                                    placeholder="Fecha de Nacimiento" value="<?= $usuario['Fecha_nacimiento'] ?>">
                                <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                            </div>
                            <!-- Selector de Comunidad -->
                            <div class="community-selector">
                                <h5 class="mb-3">
                                    <i class="ri-community-line me-2"></i>
                                    Selecciona tu Comunidad
                                </h5>
                                <div class="mb-3">
                                    <select class="form-select" name="ID_Comunidad" id="selectedCommunity">
                                        <option value="">Seleccione una comunidad</option>
                                        <?php foreach ($comunidades as $comunidad): ?>
                                            <option value="<?= $comunidad['ID'] ?>"
                                                <?= $usuario['ID_Comunidad'] == $comunidad['ID'] ? 'selected' : '' ?>>
                                                <?= $comunidad['Nombre'] ?> - <?= $comunidad['Ubicacion'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <!-- Ubicación -->
                            <!-- Sección del mapa modificada -->
                            <div class="mb-3">

                                <div id="map" class="mb-2"></div>
                                <div class="coordinates-display" id="coordinatesDisplay">
                                    Latitud: <span id="latDisplay">-</span>, Longitud: <span id="lngDisplay">-</span>
                                </div>
                                <input type="hidden" name="Latitud" id="lat" value="<?= $usuario['Latitud'] ?>">
                                <input type="hidden" name="Longitud" id="lng" value="<?= $usuario['Longitud'] ?>">
                                <textarea class="form-control mt-2" name="Direccion" id="direccion" rows="2"
                                    placeholder="Dirección detallada"><?= $usuario['Direccion'] ?></textarea>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="password" name="Contrasena"
                                    placeholder="Contraseña">
                                <label for="password">Nueva contraseña (dejar en blanco para mantener la actual)</label>
                            </div>
                            <!-- Profile Image -->
                            <label class="form-floating mb-3">
                                <span class="text-gray-700 dark:text-gray-400">Imagen de Perfil</span>
                                <input
                                    class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-purple-600 file:text-white hover:file:bg-purple-700 focus:border-purple-400"
                                    type="file" name="Imagen_URL" id="Imagen_URL" />

                            </label>

                            <button type="submit" class="btn btn-primary w-100">
                                <i class="ri-save-line me-2"></i>Guardar cambios
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let map, marker;

        function initMap() {
            // Coordenadas iniciales (usar las del usuario o coordenadas por defecto)
            const lat = parseFloat(document.getElementById('lat').value) || -33.4489;
            const lng = parseFloat(document.getElementById('lng').value) || -70.6693;

            // Inicializar el mapa
            map = L.map('map').setView([lat, lng], 13);

            // Añadir capa de OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Añadir marcador arrastrable
            marker = L.marker([lat, lng], {
                draggable: true
            }).addTo(map);

            // Actualizar coordenadas cuando se arrastra el marcador
            marker.on('dragend', function (e) {
                const position = marker.getLatLng();
                updateCoordinates(position.lat, position.lng);
                reverseGeocode(position.lat, position.lng);
            });

            // Click en el mapa para mover el marcador
            map.on('click', function (e) {
                marker.setLatLng(e.latlng);
                updateCoordinates(e.latlng.lat, e.latlng.lng);
                reverseGeocode(e.latlng.lat, e.latlng.lng);
            });

            // Inicializar búsqueda
            initializeSearch();
        }

        function updateCoordinates(lat, lng) {
            document.getElementById('lat').value = lat;
            document.getElementById('lng').value = lng;
            document.getElementById('latDisplay').textContent = lat.toFixed(6);
            document.getElementById('lngDisplay').textContent = lng.toFixed(6);
        }

        function initializeSearch() {
            const searchInput = document.getElementById('searchLocation');
            const searchButton = document.getElementById('searchButton');

            searchButton.addEventListener('click', function () {
                const query = searchInput.value;
                if (query) {
                    searchLocation(query);
                }
            });

            searchInput.addEventListener('keypress', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const query = this.value;
                    if (query) {
                        searchLocation(query);
                    }
                }
            });
        }

        function searchLocation(query) {
            // Usar Nominatim API para buscar ubicaciones
            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        const location = data[0];
                        const lat = parseFloat(location.lat);
                        const lng = parseFloat(location.lon);

                        map.setView([lat, lng], 16);
                        marker.setLatLng([lat, lng]);
                        updateCoordinates(lat, lng);
                        document.getElementById('direccion').value = location.display_name;
                    } else {
                        alert('No se encontraron resultados para esta búsqueda.');
                    }
                })
                .catch(error => {
                    console.error('Error en la búsqueda:', error);
                    alert('Error al realizar la búsqueda. Por favor, intente nuevamente.');
                });
        }

        function reverseGeocode(lat, lng) {
            // Obtener dirección desde coordenadas
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                .then(response => response.json())
                .then(data => {
                    if (data.display_name) {
                        document.getElementById('direccion').value = data.display_name;
                    }
                })
                .catch(error => console.error('Error en geocodificación inversa:', error));
        }

        document.addEventListener('DOMContentLoaded', function () {
            initMap();
            loadCommunities();
        });

        // Cargar comunidades
        async function loadCommunities() {
            try {
                // Realizamos la petición a la API
                const response = await fetch('<?= base_url('api/comunidades') ?>');
                const communities = await response.json();

                const container = document.getElementById('communitiesContainer');
                const selectedCommunityId = document.getElementById('selectedCommunity').value;

                communities.forEach(community => {
                    // Crear la tarjeta de comunidad
                    const card = document.createElement('div');
                    card.className = 'col-md-6 col-lg-2';

                    // Construcción del HTML con variables (con seguridad y uso de fallback para la imagen)
                    const imageUrl = community.Imagen ? `<?= base_url() ?>${community.Imagen}` : '/images/default-community.jpg';
                    const isSelected = community.ID === selectedCommunityId ? 'selected' : '';

                    // Usamos `textContent` o `createElement` para evitar posibles inyecciones de HTML
                    card.innerHTML = `
                <div class="card community-card ${isSelected}" data-community-id="${community.ID}">
                    <img src="${imageUrl}" class="community-image" alt="${community.Nombre}">
                    <div class="card-body">
                        <h6 class="card-title">${community.Nombre || 'Nombre no disponible'}</h6>
                        <p class="card-text small text-muted">${community.Ubicacion || 'Ubicación no disponible'}</p>
                    </div>
                </div>
            `;

                    // Agregar el evento al hacer clic en la tarjeta
                    card.querySelector('.community-card').addEventListener('click', function () {
                        // Remover la selección anterior
                        document.querySelectorAll('.community-card').forEach(c => c.classList.remove('selected'));

                        // Seleccionar la nueva comunidad
                        this.classList.add('selected');
                        document.getElementById('selectedCommunity').value = this.dataset.communityId;

                        // Centrar el mapa en la ubicación de la comunidad seleccionada
                        const newLocation = {
                            lat: parseFloat(community.Latitud),
                            lng: parseFloat(community.Longitud)
                        };

                        if (!isNaN(newLocation.lat) && !isNaN(newLocation.lng)) {
                            map.setCenter(newLocation); // Aseguramos que las coordenadas sean válidas
                            marker.setPosition(newLocation);
                            document.getElementById('lat').value = community.Latitud;
                            document.getElementById('lng').value = community.Longitud;
                            document.getElementById('direccion').value = community.Ubicacion;
                        } else {
                            console.warn('Coordenadas no válidas:', community.Latitud, community.Longitud);
                        }
                    });

                    // Agregar la tarjeta al contenedor
                    container.appendChild(card);
                });
            } catch (error) {
                console.error('Error cargando comunidades:', error);
            }
        }


        // Preview de imagen
        document.getElementById('imageInput').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('profileImage').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });

        // Validación del formulario
        document.getElementById('profileForm').addEventListener('submit', function (e) {
            e.preventDefault();

            // Validar campos requeridos
            const nombre = document.getElementById('nombre').value.trim();
            const email = document.getElementById('email').value.trim();
            const comunidad = document.getElementById('selectedCommunity').value;

            if (!nombre) {
                alert('Por favor, ingrese su nombre');
                return;
            }

            if (!email) {
                alert('Por favor, ingrese su correo electrónico');
                return;
            }

            if (!comunidad) {
                alert('Por favor, seleccione una comunidad');
                return;
            }

            // Si todo está bien, enviar el formulario
            this.submit();
        });

        // Inicializar mapa y cargar comunidades cuando se carga la página
        window.initMap = initMap;
        document.addEventListener('DOMContentLoaded', loadCommunities);
    </script>

    <script>
        // Script para manejar la selección de comunidad
        document.addEventListener('DOMContentLoaded', function () {
            const communityButtons = document.querySelectorAll('.community-option');
            const selectedCommunityInput = document.getElementById('selectedCommunity');

            communityButtons.forEach(button => {
                button.addEventListener('click', function () {
                    // Asignamos el valor del ID de la comunidad seleccionada al input oculto
                    selectedCommunityInput.value = this.getAttribute('data-id');

                    // Opcional: Puedes agregar una clase activa para mostrar la selección visualmente
                    communityButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        });
    </script>