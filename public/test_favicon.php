<?php
// Teste para verificar permissões e funcionalidade do Favicon Generator

// Inclui o arquivo de inicialização do CodeIgniter
require_once __DIR__ . '/../app/Config/Constants.php';
require_once __DIR__ . '/../vendor/autoload.php';

use CodeIgniter\CodeIgniter;

// Define o ambiente
$app = new CodeIgniter();
$app->initialize();

// Caminho para o diretório de uploads
$uploadPath = WRITEPATH . 'uploads/favicon_generator/';

// Verifica se o diretório existe e tem permissões de escrita
echo "Verificando diretório de uploads...\n";
if (!is_dir($uploadPath)) {
    echo "Criando diretório de uploads...\n";
    if (!mkdir($uploadPath, 0777, true)) {
        die("Erro ao criar diretório de uploads. Verifique as permissões.\n");
    }
    echo "Diretório criado com sucesso!\n";
} else {
    echo "Diretório de uploads já existe.\n";
}

// Verifica permissões de escrita
echo "Verificando permissões de escrita...\n";
$testFile = $uploadPath . 'test_write.txt';
if (file_put_contents($testFile, 'test') === false) {
    die("Erro: Não foi possível escrever no diretório de uploads. Verifique as permissões.\n");
} else {
    echo "Permissões de escrita verificadas com sucesso!\n";
    unlink($testFile); // Remove o arquivo de teste
}

// Verifica se a extensão GD está instalada
echo "Verificando extensão GD...\n";
if (!extension_loaded('gd')) {
    die("Erro: A extensão GD não está instalada. É necessária para redimensionar imagens.\n");
} else {
    echo "Extensão GD está instalada.\n";
    $gdInfo = gd_info();
    echo "Versão GD: " . $gdInfo['GD Version'] . "\n";
}

// Verifica se a extensão ZIP está instalada
echo "Verificando extensão ZIP...\n";
if (!extension_loaded('zip')) {
    die("Erro: A extensão ZIP não está instalada. É necessária para criar o pacote de download.\n");
} else {
    echo "Extensão ZIP está instalada.\n";
}

echo "\nTeste concluído com sucesso! O Favicon Generator deve funcionar corretamente.\n";
?>
