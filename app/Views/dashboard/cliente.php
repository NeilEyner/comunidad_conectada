<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Cliente</title>
</head>
<body>
    <h1>Bienvenido, Cliente <?= session()->get('Nombre') ?></h1>
    <nav>
        <ul>
            <li><a href="#">Catálogo de Productos</a></li>
            <li><a href="#">Mis Pedidos</a></li>
            <li><a href="#">Mi Perfil</a></li>
        </ul>
    </nav>
    <a href="<?= base_url('logout') ?>">Cerrar Sesión</a>
</body>
</html>