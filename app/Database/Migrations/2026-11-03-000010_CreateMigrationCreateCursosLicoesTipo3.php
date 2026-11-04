<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MigrationCreateCursosLicoesTipo3 extends Migration
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
                'constraint' => 255,
            ],
            'recomendacao_txt' => [
                'type' => 'TEXT',
            ],
            'recomendacao_img' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('cursos_licoes_tipo_3', true);
    }

    public function down()
    {
        $this->forge->dropTable('cursos_licoes_tipo_3', true);
    }
}
