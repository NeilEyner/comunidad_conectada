<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Artesano</title>
</head>
<body>
    <h1>Bienvenido, Artesano <?= session()->get('Nombre') ?></h1>
    <nav>
        <ul>
            <li><a href="#">Mis Productos</a></li>
            <li><a href="#">Pedidos Pendientes</a></li>
            <li><a href="#">Estadísticas de Ventas</a></li>
        </ul>
    </nav>
    <a href="<?= base_url('logout') ?>">Cerrar Sesión</a>
</body>
</html> -->


<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template


