<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MigrationCreateCursosLicoesTipos extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 10,
                'auto_increment' => true,
            ],
            'icone' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'tipo' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('cursos_licoes_tipos', true);
    }

    public function down()
    {
        $this->forge->dropTable('cursos_licoes_tipos', true);
    }
}
