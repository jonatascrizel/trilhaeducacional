<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MigrationCreateCursosLicoesTipo6 extends Migration
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
            'card1_img' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'card1_alt' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'card2_img' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'card2_alt' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'card3_img' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'card3_alt' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'card4_img' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'card4_alt' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'card5_img' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'card5_alt' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'card6_img' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'card6_alt' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('cursos_licoes_tipo_6', true);
    }

    public function down()
    {
        $this->forge->dropTable('cursos_licoes_tipo_6', true);
    }
}
