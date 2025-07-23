<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registrar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Registrar Nuevo Usuario</h4>
            </div>
            <div class="card-body">

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="<?= site_url('/users/store') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="nombre" class="form-control" value="<?= old('nombre') ?>" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Apellidos</label>
                            <input type="text" name="apellidos" class="form-control" value="<?= old('apellidos') ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Sexo</label>
                        <select name="sexo" class="form-select" required>
                            <option value="">Seleccione...</option>
                            <option value="Masculino" <?= old('sexo') == 'Masculino' ? 'selected' : '' ?>>Masculino</option>
                            <option value="Femenino" <?= old('sexo') == 'Femenino' ? 'selected' : '' ?>>Femenino</option>
                            <option value="Otro" <?= old('sexo') == 'Otro' ? 'selected' : '' ?>>Otro</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Correo electrónico</label>
                            <input type="email" name="email" class="form-control" value="<?= old('email') ?>" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Teléfono</label>
                            <input type="text" name="telefono" class="form-control" value="<?= old('telefono') ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <hr class="my-4">

                    <h5 class="mb-3">Dirección</h5>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="codigo_postal" class="form-label">Código Postal</label>
                            <input type="text" class="form-control" id="codigo_postal" name="codigo_postal" value="<?= old('codigo_postal') ?>" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="delegacion" class="form-label">Delegación / Municipio</label>
                            <input type="text" class="form-control" id="delegacion" name="delegacion" value="<?= old('delegacion') ?>" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="estado" class="form-label">Estado</label>
                            <input type="text" class="form-control" id="estado" name="estado" value="<?= old('estado') ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="colonia" class="form-label">Colonia</label>
                        <input type="text" class="form-control" id="colonia" name="colonia" value="<?= old('colonia') ?>" required>
                    </div>

                    <hr class="my-4">

                    <div class="mb-3">
                        <label class="form-label">Roles</label><br>
                        <?php foreach ($roles as $rol): ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="role_list[]" value="<?= $rol['id'] ?>" id="role_<?= $rol['id'] ?>">
                                <label class="form-check-label" for="role_<?= $rol['id'] ?>">
                                    <?= esc($rol['name']) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="<?= site_url('/users') ?>" class="btn btn-secondary">Volver</a>
                        <button type="submit" class="btn btn-primary">Guardar Usuario</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        document.getElementById('codigo_postal').addEventListener('input', function() {
            const cp = this.value;

            if (cp.length === 5) {
                fetch(`https://sepomex.icalialabs.com/api/v1/zip_codes/${cp}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.zip_code) {
                            document.getElementById('estado').value = data.zip_code.d_estado;
                            document.getElementById('delegacion').value = data.zip_code.d_mnpio;

                            const colonias = data.zip_code.d_asenta;
                            const coloniaField = document.getElementById('colonia');

                            if (coloniaField.tagName === 'INPUT') {
                                const select = document.createElement('select');
                                select.className = 'form-control';
                                select.name = 'colonia';
                                select.id = 'colonia';

                                colonias.forEach(c => {
                                    const option = document.createElement('option');
                                    option.value = c;
                                    option.text = c;
                                    select.appendChild(option);
                                });

                                coloniaField.parentNode.replaceChild(select, coloniaField);
                            }
                        }
                    });
            }
        });
    </script>
</body>

</html>