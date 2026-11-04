<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MigrationCreateCursos extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 50,
                'auto_increment' => true,
            ],
            'nome' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'descricao' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'imagem_curso' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('cursos', true);
    }

    public function down()
    {
        $this->forge->dropTable('cursos', true);
    }
}
