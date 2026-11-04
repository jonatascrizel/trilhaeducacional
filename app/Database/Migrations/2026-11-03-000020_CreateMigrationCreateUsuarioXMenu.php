<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MigrationCreateUsuarioXMenu extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'constraint' => 200,
                'auto_increment' => true,
            ],
            'id_usuario' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_menu' => [
                'type' => 'INT',
                'constraint' => 200,
                'auto_increment' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('id_usuario', true);
        $this->forge->addKey('id_menu', true);
        $this->forge->createTable('usuario_x_menu', true);
    }

    public function down()
    {
        $this->forge->dropTable('usuario_x_menu', true);
    }
}
