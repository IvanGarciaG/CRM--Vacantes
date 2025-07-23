<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'nombre'         => ['type' => 'VARCHAR', 'constraint' => 100],
            'apellidos'      => ['type' => 'VARCHAR', 'constraint' => 150],
            'sexo'           => ['type' => 'ENUM', 'constraint' => ['Masculino', 'Femenino']],
            'email'          => ['type' => 'VARCHAR', 'constraint' => 100, 'unique' => true],
            'telefono'       => ['type' => 'VARCHAR', 'constraint' => 15],
            'password'       => ['type' => 'VARCHAR', 'constraint' => 255],
            'estatus'        => ['type' => 'ENUM', 'constraint' => ['activo', 'inactivo'], 'default' => 'activo'],
            'fecha_registro' => ['type' => 'DATETIME', 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
