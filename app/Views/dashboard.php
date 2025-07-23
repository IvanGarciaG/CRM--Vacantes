<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Panel de Control</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 240px;
            background-color: #343a40;
            color: white;
        }

        .sidebar a {
            color: white;
            display: block;
            padding: 12px 20px;
            text-decoration: none;
        }

        .sidebar a:hover {
            background-color: #495057;
        }

        .content {
            flex-grow: 1;
            padding: 20px;
        }

        .sidebar-header {
            padding: 15px 20px;
            font-size: 1.2rem;
            background-color: #23272b;
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <div class="sidebar-header">
            Dashboard
        </div>
        <a href="<?= site_url('/dashboard') ?>">Inicio</a>
        <a href="<?= site_url('/users') ?>">Usuarios</a>
        <a href="<?= site_url('/report/users') ?>">Reportes</a>
        <a href="<?= site_url('/settings') ?>">Configuración</a>
        <a href="<?= site_url('/logout') ?>">Cerrar sesión</a>
    </div>

    <div class="content">
        <h1>Bienvenido al Panel de Control</h1>
        <p>Desde aquí puedes gestionar tu aplicación.</p>
    </div>

</body>

</html>