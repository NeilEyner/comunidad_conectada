<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Iniciar Sesión</h2>

                <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>

                <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                <?php endif; ?>

                <form method="post" action="<?= base_url('login') ?>" >
                    <div class="form-group">
                        <label for="Correo_electronico">Correo electrónico</label>
                        <input type="email" class="form-control" id="Correo_electronico" name="Correo_electronico"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="Contrasena">Contraseña</label>
                        <input type="password" class="form-control" id="Contrasena" name="Contrasena" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
                </form>
                <p class="text-center mt-3">¿No tienes una cuenta? <a href="<?= base_url('register') ?>">Regístrate
                        aquí</a></p>
            </div>
        </div>
    </div>
</body>

</html>