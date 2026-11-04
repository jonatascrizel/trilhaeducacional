<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MigrationCreateCursante extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'nome' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'apelido' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'telefone' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'senha' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'troca_senha' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
            ],
            'notfica_progressao_eml' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
            ],
            'notfica_progressao_wpp' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
            ],
            'perfil_publico' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('cursante', true);
    }

    public function down()
    {
        $this->forge->dropTable('cursante', true);
    }
}
