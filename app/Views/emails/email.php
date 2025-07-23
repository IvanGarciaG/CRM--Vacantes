<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Bienvenido</title>
    <style>
        .container {
            font-family: Arial, sans-serif;
            padding: 20px;
            max-width: 600px;
            margin: auto;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .password-box {
            background-color: #f5f5f5;
            padding: 12px;
            border-radius: 5px;
            font-family: monospace;
            font-size: 16px;
            display: inline-block;
            margin-bottom: 10px;
        }

        .note {
            font-size: 14px;
            color: #777;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 10px;
            font-size: 14px;
            background-color: #007bff;
            color: white;
            border-radius: 4px;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="title">Hola <?= esc($nombre) ?>,</div>
        <p>Tu cuenta ha sido creada exitosamente. A continuación encontrarás tu contraseña generada:</p>

        <div class="password-box" id="password-box"><?= esc($password) ?></div>

        <p class="note">Por favor cámbiala desde la sección de ajustes lo antes posible.</p>

        <p style="margin-top: 30px;">Saludos,<br>El equipo de soporte</p>
    </div>
</body>

</html>