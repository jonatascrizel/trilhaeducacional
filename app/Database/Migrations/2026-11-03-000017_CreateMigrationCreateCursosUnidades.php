<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MigrationCreateCursosUnidades extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'constraint' => 200,
                'auto_increment' => true,
            ],
            'id_curso' => [
                'type' => 'INT',
                'constraint' => 50,
                'null' => true,
            ],
            'unidade' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'numero' => [
                'type' => 'INT',
                'constraint' => 10,
            ],
            'descricao' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'st' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('cursos_unidades', true);
    }

    public function down()
    {
        $this->forge->dropTable('cursos_unidades', true);
    }
}
