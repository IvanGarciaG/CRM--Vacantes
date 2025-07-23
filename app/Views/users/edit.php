<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-warning text-dark">
                <h4>Editar Usuario</h4>
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

                <form action="<?= site_url('/users/update/' . $usuario['id']) ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" value="<?= esc($usuario['nombre']) ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Apellidos</label>
                        <input type="text" name="apellidos" class="form-control" value="<?= esc($usuario['apellidos']) ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Sexo</label>
                        <select name="sexo" class="form-select">
                            <option value="Masculino" <?= $usuario['sexo'] === 'Masculino' ? 'selected' : '' ?>>Masculino</option>
                            <option value="Femenino" <?= $usuario['sexo'] === 'Femenino' ? 'selected' : '' ?>>Femenino</option>
                            <option value="Otro" <?= $usuario['sexo'] === 'Otro' ? 'selected' : '' ?>>Otro</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Correo electrónico</label>
                        <input type="email" name="email" class="form-control" value="<?= esc($usuario['email']) ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Teléfono</label>
                        <input type="text" name="telefono" class="form-control" value="<?= esc($usuario['telefono']) ?>">
                    </div>

                    <hr>
                    <h5>Dirección</h5>

                    <div class="mb-3">
                        <label class="form-label">Código Postal</label>
                        <input type="text" name="codigo_postal" class="form-control" value="<?= esc($direccion['codigo_postal'] ?? '') ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Colonia</label>
                        <input type="text" name="colonia" class="form-control" value="<?= esc($direccion['colonia'] ?? '') ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Delegación / Municipio</label>
                        <input type="text" name="delegacion" class="form-control" value="<?= esc($direccion['delegacion'] ?? '') ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Estado</label>
                        <input type="text" name="estado" class="form-control" value="<?= esc($direccion['estado'] ?? '') ?>">
                    </div>

                    <hr>
                    <h5>Rol</h5>
                    <div class="mb-3">
                        <select name="rol_id" class="form-select">
                            <option value="">Selecciona un rol</option>
                            <?php foreach ($roles as $rol): ?>
                                <option value="<?= $rol['id'] ?>" <?= ($rol['id'] == $rol_id) ? 'selected' : '' ?>>
                                    <?= esc($rol['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>


                    <div class="d-flex justify-content-between">
                        <a href="<?= site_url('/users') ?>" class="btn btn-secondary">Volver</a>
                        <button type="submit" class="btn btn-warning">Actualizar Usuario</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</body>

</html>