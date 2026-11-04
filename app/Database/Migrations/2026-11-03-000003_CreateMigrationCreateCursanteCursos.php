<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MigrationCreateCursanteCursos extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
            ],
            'id_cursante' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'id_cursos' => [
                'type' => 'INT',
                'constraint' => 50,
            ],
            'aceito_em' => [
                'type' => 'TIMESTAMP',
                'default' => 'current_timestamp()',
            ],
            'ultimo_acesso' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('cursante_cursos', true);
    }

    public function down()
    {
        $this->forge->dropTable('cursante_cursos', true);
    }
}
