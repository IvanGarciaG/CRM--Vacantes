<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'Administrador', 'slug' => 'admin'],
            ['name' => 'Operador Administrativo', 'slug' => 'admin_operativo'],
            ['name' => 'Operador', 'slug' => 'operativo'],
        ];

        foreach ($data as $role) {
            // Check if the role already exists
            $exists = $this->db->table('roles')->getWhere(['slug' => $role['slug']])->getRow();

            if (! $exists) {
                $this->db->table('roles')->insert($role);
            }
        }
    }
}
