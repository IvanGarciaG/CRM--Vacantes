<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-success text-white text-center">
                        <h4>Registro de Usuario</h4>
                    </div>
                    <div class="card-body">
                        <?php if (session()->getFlashdata('errors')): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                        <li><?= $error ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form method="post" action="<?= site_url('/register') ?>">
                            <?= csrf_field() ?>

                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" name="nombre" value="<?= old('nombre') ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="apellidos" class="form-label">Apellidos</label>
                                <input type="text" class="form-control" name="apellidos" value="<?= old('apellidos') ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control" name="email" value="<?= old('email') ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" name="telefono" value="<?= old('telefono') ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="sexo" class="form-label">Sexo</label>
                                <select name="sexo" class="form-select" required>
                                    <option value="">Seleccione...</option>
                                    <option value="Masculino" <?= old('sexo') == 'Masculino' ? 'selected' : '' ?>>Masculino</option>
                                    <option value="Femenino" <?= old('sexo') == 'Femenino' ? 'selected' : '' ?>>Femenino</option>
                                    <option value="Otro" <?= old('sexo') == 'Otro' ? 'selected' : '' ?>>Otro</option>
                                </select>
                            </div>


                            <button type="submit" class="btn btn-success w-100">Registrarse</button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        ¿Ya tienes cuenta? <a href="<?= site_url('/login') ?>">Iniciar sesión</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>