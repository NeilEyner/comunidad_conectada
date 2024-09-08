<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="text-center mb-4">Registro de Usuario</h2>
                
                <?php if(session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger">
                        <ul>
                        <?php foreach(session()->getFlashdata('errors') as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('register') ?>" method="post">
                    <div class="form-group">
                        <label for="Nombre">Nombre</label>
                        <input type="text" class="form-control" id="Nombre" name="Nombre" value="<?= old('Nombre') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="Correo_electronico">Correo electrónico</label>
                        <input type="email" class="form-control" id="Correo_electronico" name="Correo_electronico" value="<?= old('Correo_electronico') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="Telefono">Teléfono</label>
                        <input type="tel" class="form-control" id="Telefono" name="Telefono" value="<?= old('Telefono') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="Contrasena">Contraseña</label>
                        <input type="password" class="form-control" id="Contrasena" name="Contrasena" required>
                    </div>
                    <div class="form-group">
                        <label for="ID_Rol">Rol</label>
                        <select class="form-control" id="ID_Rol" name="ID_Rol" required>
                            <option value="">Seleccione un rol</option>
                            <?php foreach($roles as $rol): ?>
                                <option value="<?= $rol['ID'] ?>" <?= old('ID_Rol') == $rol['ID'] ? 'selected' : '' ?>><?= $rol['Nombre'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Direccion">Dirección</label>
                        <textarea class="form-control" id="Direccion" name="Direccion" required><?= old('Direccion') ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="ID_Comunidad">Comunidad</label>
                        <select class="form-control" id="ID_Comunidad" name="ID_Comunidad" required>
                            <option value="">Seleccione una comunidad</option>
                            <?php foreach($comunidades as $comunidad): ?>
                                <option value="<?= $comunidad['ID'] ?>" <?= old('ID_Comunidad') == $comunidad['ID'] ? 'selected' : '' ?>><?= $comunidad['Nombre'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Registrarse</button>
                </form>
                <p class="text-center mt-3">¿Ya tienes una cuenta? <a href="<?= base_url('login') ?>">Inicia sesión aquí</a></p>
            </div>
        </div>
    </div>
</body>
</html>