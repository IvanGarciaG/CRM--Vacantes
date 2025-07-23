<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Detalle del Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Detalle del Usuario</h4>
                <a href="<?= site_url('/users') ?>" class="btn btn-secondary btn-sm">Volver</a>
            </div>

            <div class="card-body">
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                <?php elseif (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Nombre:</strong> <?= esc($usuario['nombre']) ?>
                    </div>
                    <div class="col-md-6">
                        <strong>Apellidos:</strong> <?= esc($usuario['apellidos']) ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Email:</strong> <?= esc($usuario['email']) ?>
                    </div>
                    <div class="col-md-6">
                        <strong>Teléfono:</strong> <?= esc($usuario['telefono']) ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Sexo:</strong> <?= esc($usuario['sexo']) ?>
                    </div>
                    <div class="col-md-6">
                        <strong>Rol:</strong>
                        <?= $rol ? esc($rol) : '<span class="text-muted">Sin asignar</span>' ?>
                    </div>

                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Estatus:</strong>
                        <span class="badge bg-<?= $usuario['estatus'] === 'activo' ? 'success' : 'secondary' ?>">
                            <?= ucfirst($usuario['estatus']) ?>
                        </span>
                    </div>
                    <div class="col-md-6">
                        <strong>Fecha Registro:</strong>
                        <?= date('d/m/Y H:i', strtotime($usuario['fecha_registro'])) ?>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="<?= site_url('/users/edit/' . $usuario['id']) ?>" class="btn btn-warning me-2">Editar</a>
                    <a href="<?= site_url('/users/delete/' . $usuario['id']) ?>" class="btn btn-danger" onclick="return confirm('¿Deseas desactivar este usuario?')">Desactivar</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>