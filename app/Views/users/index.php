<?= $this->extend('layouts/master') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Listado de Usuarios</h3>
        <a href="<?= site_url('/users/create') ?>" class="btn btn-primary">+ Nuevo Usuario</a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php elseif (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <table id="usuarios" class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre Completo</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Sexo</th>
                <th>Estatus</th>
                <th>Fecha Registro</th>
                <th>Acciones</th>
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
                    <td>
                        <a href="<?= site_url('/users/show/' . $usuario['id']) ?>" class="btn btn-sm btn-info">Ver</a>
                        <a href="<?= site_url('/users/edit/' . $usuario['id']) ?>" class="btn btn-sm btn-warning">Editar</a>
                        <a href="<?= site_url('/users/delete/' . $usuario['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que deseas desactivar este usuario?')">Desactivar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Scripts para DataTables -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#usuarios').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            }
        });
    });
</script>
<?= $this->endSection() ?>