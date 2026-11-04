<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class DbToMigrations extends BaseCommand
{
    protected $group       = 'Database';
    protected $name        = 'db:generate-migrations';
    protected $description = 'Lê o banco de dados configurado e gera os arquivos de migration no app/Database/Migrations.';

    public function run(array $params)
    {
        $db = \Config\Database::connect();
        $tables = $db->listTables();

        if (empty($tables)) {
            CLI::error('Nenhuma tabela encontrada no banco configurado.');
            return;
        }

        $migrationPath = APPPATH . 'Database/Migrations/';
        $prefixIndex = 1;

        foreach ($tables as $table) {
            // Ignora a tabela de controle de migrações do próprio CI
            if ($table === 'migrations') {
                continue;
            }

            $fields = $db->getFieldData($table);
            $className = 'MigrationCreate' . str_replace(' ', '', ucwords(str_replace('_', ' ', $table)));
            $timestamp = date('Y-m-d') . '-' . str_pad($prefixIndex, 6, '0', STR_PAD_LEFT);
            $filename = "{$migrationPath}{$timestamp}_Create{$className}.php";

            $fieldDefinitions = [];
            $primaryKeys = [];

            foreach ($fields as $field) {
                $type = strtoupper($field->type);
                $def = "            '{$field->name}' => [\n";
                $def .= "                'type' => '{$type}',\n";

                if ($field->max_length) {
                    $def .= "                'constraint' => {$field->max_length},\n";
                }

                if ($field->primary_key) {
                    $primaryKeys[] = $field->name;
                    if (str_contains($type, 'INT')) {
                        $def .= "                'auto_increment' => true,\n";
                    }
                }

                if ($field->nullable) {
                    $def .= "                'null' => true,\n";
                }

                if ($field->default !== null) {
                    $defaultVal = is_numeric($field->default) ? $field->default : "'{$field->default}'";
                    $def .= "                'default' => {$defaultVal},\n";
                }

                $def .= "            ],";
                $fieldDefinitions[] = $def;
            }

            $fieldsCode = implode("\n", $fieldDefinitions);
            $keysCode = '';
            foreach ($primaryKeys as $pk) {
                $keysCode .= "        \$this->forge->addKey('{$pk}', true);\n";
            }

            $template = "<?php\n\nnamespace App\\Database\\Migrations;\n\nuse CodeIgniter\\Database\\Migration;\n\nclass {$className} extends Migration\n{\n    public function up()\n    {\n        \$this->forge->addField([\n{$fieldsCode}\n        ]);\n{$keysCode}        \$this->forge->createTable('{$table}', true);\n    }\n\n    public function down()\n    {\n        \$this->forge->dropTable('{$table}', true);\n    }\n}\n";

            file_put_contents($filename, $template);
            CLI::write("Migration gerada: " . CLI::color(basename($filename), 'green'));
            $prefixIndex++;
        }

        CLI::write("Todas as migrations foram geradas com sucesso em {$migrationPath}", 'yellow');
    }
}