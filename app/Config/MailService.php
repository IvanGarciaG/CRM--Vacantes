<?php

namespace App\Services;

use Config\Services;

class MailService
{
    public static function sendWelcomeEmail(array $data, string $plainPassword): bool
    {
        $email = Services::email();

        $email->setTo($data['email']);
        $email->setFrom('admin@demo.com', 'Soporte Técnico');
        $email->setSubject('Bienvenido a la plataforma');

        $email->setMessage("
            <p>Hola <strong>{$data['nombre']} {$data['apellidos']}</strong>,</p>
            <p>Tu cuenta ha sido creada exitosamente. Aquí están tus datos de acceso:</p>
            <ul>
                <li><strong>Correo:</strong> {$data['email']}</li>
                <li><strong>Contraseña:</strong> {$plainPassword}</li>
            </ul>
            <p>Por favor cambia tu contraseña desde la sección de Ajustes una vez inicies sesión.</p>
            <br>
            <p>Atentamente,<br>El equipo de soporte</p>
        ");

        if (! $email->send()) {
            log_message('error', 'Fallo al enviar correo a ' . $data['email']);
            log_message('error', print_r($email->printDebugger(['headers', 'body']), true));
            return false;
        }

        log_message('info', 'Correo enviado correctamente a ' . $data['email']);
        return true;
    }
}
