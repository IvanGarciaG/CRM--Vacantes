<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class UserSeeder extends Seeder
{
    public function run()
    {
        $usuario = [
            'nombre'         => 'Juan',
            'apellidos'      => 'Pérez',
            'sexo'           => 'Masculino',
            'email'          => 'admin@demo.com',
            'telefono'       => '5523456789',
            'password'       => password_hash('Admin123!', PASSWORD_DEFAULT),
            'estatus'        => 'activo',
            'fecha_registro' => Time::now(),
            'created_at'     => Time::now(),
            'updated_at'     => Time::now(),
        ];

        // Insertar el usuario y obtener su ID
        $this->db->table('users')->insert($usuario);
        $userId = $this->db->insertID();

        // Insertar dirección (si usas tabla `user_addresses`)
        $direccion = [
            'user_id'       => $userId,
            'codigo_postal' => '01000',
            'colonia'       => 'Centro',
            'delegacion'    => 'Álvaro Obregón',
            'estado'        => 'CDMX'
        ];
        $this->db->table('user_addresses')->insert($direccion);

        // Asignar rol (asumiendo que el rol de Administrador es ID = 1)
        $this->db->table('role_user')->insert([
            'user_id' => $userId,
            'role_id' => 1
        ]);
    }
}
