<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MigrationCreateCursosLicoesTipo1 extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
            ],
            'id_cursos_licoes' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
            ],
            'pergunta' => [
                'type' => 'TEXT',
            ],
            'resposta1' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'resposta2' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'resposta3' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'resposta4' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'resposta5' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'resposta_certa' => [
                'type' => 'INT',
                'constraint' => 1,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('cursos_licoes_tipo_1', true);
    }

    public function down()
    {
        $this->forge->dropTable('cursos_licoes_tipo_1', true);
    }
}
