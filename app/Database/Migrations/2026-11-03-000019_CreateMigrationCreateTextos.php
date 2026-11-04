<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MigrationCreateTextos extends Migration
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
            'chave' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'titulo' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'default'    => null,
            ],
            'conteudo' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'categoria' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'default'    => 'geral',
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('chave');
        $this->forge->addKey('categoria');

        $this->forge->createTable('textos', true);

        // 2. Dados Iniciais de Arranque
        $initialTextos = [
            [
                'id'        => 1,
                'chave'     => 'home_boas_vindas',
                'titulo'    => 'Boas-vindas à Trilha de Aprendizado',
                'conteudo'  => '<p>Seja bem-vindo à nossa plataforma de formação e desenvolvimento contínuo.</p>',
                'categoria' => 'institucional',
            ],
            [
                'id'        => 2,
                'chave'     => 'termos_politica_privacidade',
                'titulo'    => 'Termos e Política de Privacidade',
                'conteudo'  => '<p>Este ambiente segue as diretrizes da LGPD para proteção e privacidade dos dados de formação dos cursantes.</p>',
                'categoria' => 'legal',
            ],
            [
                'id'        => 3,
                'chave'     => 'login_instrucoes',
                'titulo'    => 'Acesso à Plataforma',
                'conteudo'  => '<p>Utilize o seu e-mail cadastrado para ter acesso às suas lições, avaliações e progresso formativo.</p>',
                'categoria' => 'autenticacao',
            ],
            [
                'id'        => 4,
                'chave'     => 'rodape_copyright',
                'titulo'    => 'Rodapé',
                'conteudo'  => '<p>&copy; Todos os direitos reservados. Trilha de Aprendizado.</p>',
                'categoria' => 'rodape',
            ],
        ];

        $this->db->table('textos')->insertBatch($initialTextos);
    }

    public function down()
    {
        $this->forge->dropTable('textos', true);
    }
}