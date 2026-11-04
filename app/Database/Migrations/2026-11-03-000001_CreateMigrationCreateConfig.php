<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MigrationCreateConfig extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 200,
                'auto_increment' => true,
            ],
            'configName' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'configValue' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'configType' => [
                'type' => 'TINYINT',
                'constraint' => 10,
            ],
            'configOption' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'descricao' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('config', true);

        $initialData = [
            [
                'id'          => 1,
                'configName'  => 'SENDER_NAME',
                'configValue' => '',
                'configType'  => 0,
                'configOption'=> null,
                'descricao'   => 'Nome que aparecerá nos e-mails enviados a partir do site/sistema.',
            ],
            [
                'id'          => 2,
                'configName'  => 'SENDER_MAIL',
                'configValue' => '',
                'configType'  => 0,
                'configOption'=> null,
                'descricao'   => 'E-mail que será o remetende dos e-mails enviados a partir do site/sistema.',
            ],
            [
                'id'          => 5,
                'configName'  => 'emlContato',
                'configValue' => '',
                'configType'  => 0,
                'configOption'=> null,
                'descricao'   => 'E-mail que recebe as notificações do site/sistema.',
            ],
            [
                'id'          => 6,
                'configName'  => 'API_USER_ID',
                'configValue' => '',
                'configType'  => 0,
                'configOption'=> null,
                'descricao'   => 'USER ID da plataforma SendPulse',
            ],
            [
                'id'          => 7,
                'configName'  => 'API_SECRET',
                'configValue' => '',
                'configType'  => 0,
                'configOption'=> null,
                'descricao'   => 'Chave secreta da plataforma SendPulse',
            ],
            [
                'id'          => 9,
                'configName'  => 'email_type',
                'configValue' => '',
                'configType'  => 0,
                'configOption'=> null,
                'descricao'   => "Método de envio de e-mail:\r\nemail: envio através da autenticação de um e-mail\r\nsendpulse: envio através de um SMTP transacional com a API da Sendpulse",
            ],
            [
                'id'          => 10,
                'configName'  => 'email_SMTPHost',
                'configValue' => '',
                'configType'  => 0,
                'configOption'=> null,
                'descricao'   => "Quando o email_type está setado como email é necessário preencher essa informação.\r\nEste é o endereço de SMTP do servidor de e-mail.",
            ],
            [
                'id'          => 11,
                'configName'  => 'email_SMTPUser',
                'configValue' => '',
                'configType'  => 0,
                'configOption'=> null,
                'descricao'   => "Quando o email_type está setado como email é necessário preencher essa informação.\r\nEsse é o usuário que autentica no SMTP",
            ],
            [
                'id'          => 12,
                'configName'  => 'email_SMTPPass',
                'configValue' => '',
                'configType'  => 0,
                'configOption'=> null,
                'descricao'   => "Quando o email_type está setado como email é necessário preencher essa informação.\r\nEssa é a senha do SMTP",
            ],
            [
                'id'          => 13,
                'configName'  => 'email_SMTPCrypto',
                'configValue' => 'SSL',
                'configType'  => 0,
                'configOption'=> null,
                'descricao'   => "Quando o email_type está setado como email é necessário preencher essa informação.\r\nEssa é a criptografia do SMTP",
            ],
            [
                'id'          => 14,
                'configName'  => 'email_SMTPPort',
                'configValue' => '465',
                'configType'  => 0,
                'configOption'=> null,
                'descricao'   => "Quando o email_type está setado como email é necessário preencher essa informação.\r\nEssa é a porta que o servidor de SMTP utiliza.",
            ],
            [
                'id'          => 15,
                'configName'  => 'email_CC',
                'configValue' => '',
                'configType'  => 0,
                'configOption'=> null,
                'descricao'   => 'Email que é sempre copiado, em todas as comiunicações do sistema.',
            ],
            [
                'id'          => 16,
                'configName'  => 'SEO_title',
                'configValue' => 'Trilha de aprendizado',
                'configType'  => 0,
                'configOption'=> null,
                'descricao'   => null,
            ],
            [
                'id'          => 17,
                'configName'  => 'SEO_description',
                'configValue' => '',
                'configType'  => 0,
                'configOption'=> null,
                'descricao'   => null,
            ],
            [
                'id'          => 18,
                'configName'  => 'SEO_keywords',
                'configValue' => '',
                'configType'  => 0,
                'configOption'=> null,
                'descricao'   => null,
            ],
            [
                'id'          => 19,
                'configName'  => 'cnpj',
                'configValue' => '',
                'configType'  => 0,
                'configOption'=> null,
                'descricao'   => null,
            ],
            [
                'id'          => 20,
                'configName'  => 'telefone',
                'configValue' => '',
                'configType'  => 0,
                'configOption'=> null,
                'descricao'   => null,
            ],
            [
                'id'          => 21,
                'configName'  => 'endereco',
                'configValue' => '',
                'configType'  => 0,
                'configOption'=> null,
                'descricao'   => null,
            ],
            [
                'id'          => 34,
                'configName'  => 'reCaptchaKey',
                'configValue' => '',
                'configType'  => 0,
                'configOption'=> null,
                'descricao'   => null,
            ],
            [
                'id'          => 35,
                'configName'  => 'gApiKey',
                'configValue' => '',
                'configType'  => 0,
                'configOption'=> null,
                'descricao'   => null,
            ],
            [
                'id'          => 36,
                'configName'  => 'gProjectID',
                'configValue' => '',
                'configType'  => 0,
                'configOption'=> null,
                'descricao'   => null,
            ],
            [
                'id'          => 37,
                'configName'  => 'gIdClient',
                'configValue' => '',
                'configType'  => 0,
                'configOption'=> null,
                'descricao'   => null,
            ],
            [
                'id'          => 38,
                'configName'  => 'gSecretKey',
                'configValue' => '',
                'configType'  => 0,
                'configOption'=> null,
                'descricao'   => null,
            ],
        ];

        $this->db->table('config')->insertBatch($initialData);
    }

    public function down()
    {
        $this->forge->dropTable('config', true);
    }
}
