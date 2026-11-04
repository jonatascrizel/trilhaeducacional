<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MigrationCreateCursanteLicoes extends Migration
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
                'null' => true,
            ],
            'id_licao' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => true,
            ],
            'feita_em' => [
                'type' => 'TIMESTAMP',
                'default' => 'current_timestamp()',
            ],
            'resposta' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('cursante_licoes', true);
    }

    public function down()
    {
        $this->forge->dropTable('cursante_licoes', true);
    }
}
