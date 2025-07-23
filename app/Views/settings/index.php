<?= $this->extend('layouts/master') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h3>Configuración de Usuario</h3>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif ?>

    <form method="post" action="<?= site_url('/settings/update') ?>">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" value="<?= esc($usuario['nombre']) ?>" class="form-control">
        </div>
        <div class="mb-3">
            <label>Apellidos</label>
            <input type="text" name="apellidos" value="<?= esc($usuario['apellidos']) ?>" class="form-control">
        </div>
        <div class="mb-3">
            <label>Teléfono</label>
            <input type="text" name="telefono" value="<?= esc($usuario['telefono']) ?>" class="form-control">
        </div>
        <div class="mb-3">
            <label>Sexo</label>
            <select name="sexo" class="form-control">
                <option value="Masculino" <?= $usuario['sexo'] == 'Masculino' ? 'selected' : '' ?>>Masculino</option>
                <option value="Femenino" <?= $usuario['sexo'] == 'Femenino' ? 'selected' : '' ?>>Femenino</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Nueva Contraseña (opcional)</label>
            <input type="password" name="password" class="form-control">
        </div>
        <button class="btn btn-success">Actualizar</button>
    </form>
</div>

<?= $this->endSection() ?>