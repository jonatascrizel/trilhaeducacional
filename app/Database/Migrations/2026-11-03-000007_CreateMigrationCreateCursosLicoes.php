<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MigrationCreateCursosLicoes extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
            ],
            'id_cursos_unidades' => [
                'type' => 'BIGINT',
                'constraint' => 200,
            ],
            'ordem' => [
                'type' => 'INT',
                'constraint' => 10,
            ],
            'titulo' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'id_cursos_licoes_tipo' => [
                'type' => 'INT',
                'constraint' => 10,
            ],
            'st' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('cursos_licoes', true);
    }

    public function down()
    {
        $this->forge->dropTable('cursos_licoes', true);
    }
}
