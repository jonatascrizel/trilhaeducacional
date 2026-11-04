<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MigrationCreateCursanteLog extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'id_cursante' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'registro' => [
                'type' => 'TEXT',
            ],
            'dataHora' => [
                'type' => 'TIMESTAMP',
                'default' => 'current_timestamp()',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('cursante_log', true);
    }

    public function down()
    {
        $this->forge->dropTable('cursante_log', true);
    }
}
