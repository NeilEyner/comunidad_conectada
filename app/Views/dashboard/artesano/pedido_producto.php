<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Remixicon CSS -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9 p-4">
                <?php if (empty($ventas)): ?>
                    <div class="alert alert-info">
                        <i class="ri-information-line me-2"></i> Aún no tienes ventas registradas.
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>ID Venta</th>
                                    <th>Fecha</th>
                                    <th>Cliente</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($ventas as $venta): ?>
                                    <tr>
                                        <td>#<?= $venta['compra_id'] ?></td>
                                        <td><?= date('d/m/Y H:i', strtotime($venta['Fecha'])) ?></td>
                                        <td><?= $venta['cliente_nombre'] ?></td>
                                        <td><?= $venta['producto_nombre'] ?></td>
                                        <td><?= $venta['Cantidad'] ?></td>
                                        <td>$<?= number_format($venta['Total'], 2) ?></td>
                                        <td>
                                            <span class="badge <?= getEstadoClass($venta['Estado']) ?>">
                                                <?= $venta['Estado'] ?>
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" title="Ver detalles">
                                                <i class="ri-eye-line"></i>
                                            </button>
                                            <?php if ($venta['Estado'] === 'PENDIENTE'): ?>
                                                <button class="btn btn-sm btn-outline-success" title="Procesar venta">
                                                    <i class="ri-check-line"></i>
                                                </button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <?php
    function getEstadoClass($estado)
    {
        return match ($estado) {
            'PENDIENTE' => 'bg-warning',
            'EN PROCESO' => 'bg-info',
            'ENVIADO' => 'bg-primary',
            'ENTREGADO' => 'bg-success',
            'CANCELADO' => 'bg-danger',
            default => 'bg-secondary'
        };
    }
    ?>
</body>

</html>