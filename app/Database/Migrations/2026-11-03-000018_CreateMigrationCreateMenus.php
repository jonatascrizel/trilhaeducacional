<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MigrationCreateMenus extends Migration
{
    public function up()
    {
        // 1. Estrutura da Tabela
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'titulo' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'slug' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'url' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'default'    => null,
            ],
            'icone' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'default'    => null,
            ],
            'ordem' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'ativo' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('ordem');
        $this->forge->addKey('ativo');

        $this->forge->createTable('menu', true);

        // 2. Dados Iniciais de Arranque
        $initialMenus = [
            [
                'id'     => 1,
                'titulo' => 'Início',
                'slug'   => 'inicio',
                'url'    => '/',
                'icone'  => 'fas fa-home',
                'ordem'  => 1,
                'ativo'  => 1,
            ],
            [
                'id'     => 2,
                'titulo' => 'Cursos',
                'slug'   => 'cursos',
                'url'    => '/cursos',
                'icone'  => 'fas fa-graduation-cap',
                'ordem'  => 2,
                'ativo'  => 1,
            ],
            [
                'id'     => 3,
                'titulo' => 'Área do Cursante',
                'slug'   => 'painel',
                'url'    => '/cursante/painel',
                'icone'  => 'fas fa-user-graduate',
                'ordem'  => 3,
                'ativo'  => 1,
            ],
            [
                'id'     => 4,
                'titulo' => 'Contacto',
                'slug'   => 'contacto',
                'url'    => '/contacto',
                'icone'  => 'fas fa-envelope',
                'ordem'  => 4,
                'ativo'  => 1,
            ],
        ];

        $this->db->table('menu')->insertBatch($initialMenus);
    }

    public function down()
    {
        $this->forge->dropTable('menu', true);
    }
}