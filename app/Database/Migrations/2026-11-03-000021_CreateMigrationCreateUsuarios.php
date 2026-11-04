<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MigrationCreateUsuarios extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'user_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'user_email' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'user_password' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => true,
            ],
            'user_created_at' => [
                'type' => 'TIMESTAMP',
                'default' => 'current_timestamp()',
            ],
            'ativo' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
            ],
            'troca_senha' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => true,
            ],
            'telefone' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('usuarios', true);
    }

    public function down()
    {
        $this->forge->dropTable('usuarios', true);
    }
}
