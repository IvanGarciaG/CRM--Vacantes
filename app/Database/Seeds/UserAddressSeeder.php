<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserAddressSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'user_id' => 1,
                'codigo_postal' => '07010',
                'delegacion'    => 'Gustavo A. Madero',
                'colonia'       => 'San Juan de Aragón',
                'estado'        => 'CDMX'
            ],
            [
                'user_id' => 2,
                'codigo_postal' => '44100',
                'delegacion'    => 'Guadalajara',
                'colonia'       => 'Centro',
                'estado'        => 'Jalisco'
            ],
        ];

       
        $this->db->table('user_addresses')->insertBatch($data);
    }
}
