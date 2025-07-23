<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserAddresses extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'user_id' => ['type' => 'INT', 'unsigned' => true],
            'codigo_postal' => ['type' => 'VARCHAR', 'constraint' => 10],
            'delegacion' => ['type' => 'VARCHAR', 'constraint' => 100],
            'colonia' => ['type' => 'VARCHAR', 'constraint' => 100],
            'estado' => ['type' => 'VARCHAR', 'constraint' => 100],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('user_addresses');
    }

    public function down()
    {
        $this->forge->dropTable('user_addresses');
    }
}
