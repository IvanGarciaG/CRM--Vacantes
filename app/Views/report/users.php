<?= $this->extend('layouts/master') ?>
<?= $this->section('content') ?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Reporte de Usuarios</h3>
        <a href="<?= site_url('/report/users/export') ?>" class="btn btn-success">Exportar a Excel</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre Completo</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Sexo</th>
                <th>Estatus</th>
                <th>Fecha Registro</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?= esc($usuario['id']) ?></td>
                    <td><?= esc($usuario['nombre']) . ' ' . esc($usuario['apellidos']) ?></td>
                    <td><?= esc($usuario['email']) ?></td>
                    <td><?= esc($usuario['telefono']) ?></td>
                    <td><?= esc($usuario['sexo']) ?></td>
                    <td>
                        <span class="badge bg-<?= $usuario['estatus'] === 'activo' ? 'success' : 'secondary' ?>">
                            <?= ucfirst($usuario['estatus']) ?>
                        </span>
                    </td>
                    <td><?= date('d/m/Y', strtotime($usuario['fecha_registro'])) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>