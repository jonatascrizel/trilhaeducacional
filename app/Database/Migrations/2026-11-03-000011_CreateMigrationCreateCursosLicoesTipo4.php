<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MigrationCreateCursosLicoesTipo4 extends Migration
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
            'video' => [
                'type' => 'TEXT',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('cursos_licoes_tipo_4', true);
    }

    public function down()
    {
        $this->forge->dropTable('cursos_licoes_tipo_4', true);
    }
}
