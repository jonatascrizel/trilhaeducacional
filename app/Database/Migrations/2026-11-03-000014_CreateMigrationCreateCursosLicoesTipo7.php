<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MigrationCreateCursosLicoesTipo7 extends Migration
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
            'enunciado' => [
                'type' => 'TEXT',
            ],
            'colA1' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'colA2' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'colA3' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'colA4' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'colA5' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'colB1' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'colB2' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'colB3' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'colB4' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'colB5' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('cursos_licoes_tipo_7', true);
    }

    public function down()
    {
        $this->forge->dropTable('cursos_licoes_tipo_7', true);
    }
}
