<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('search', 'Home::search');
$routes->post('search', 'Home::search');

// Gerador de Senhas
$routes->match(['GET', 'POST'], 'password-generator', 'PasswordGenerator::index');
$routes->post('password-generator/generate', 'PasswordGenerator::generate');

// Gerador de Lorem Ipsum
$routes->match(['GET', 'POST'], 'gerador-lorem-ipsum', 'LoremIpsumGenerator::index');
$routes->post('gerador-lorem-ipsum/generate', 'LoremIpsumGenerator::generate');

// Gerador de CPF
$routes->match(['GET', 'POST'], 'gerador-cpf', 'CpfGenerator::index');
$routes->post('gerador-cpf/generate', 'CpfGenerator::generate');

// Gerador de CNPJ
$routes->match(['GET', 'POST'], 'gerador-cnpj', 'CnpjGenerator::index');
$routes->post('gerador-cnpj/generate', 'CnpjGenerator::generate');

// Validador de Documentos
$routes->match(['GET', 'POST'], 'validador-documentos', 'DocumentValidator::index');
$routes->post('validador-documentos/validate', 'DocumentValidator::docValidate');

// Números por Extenso
$routes->match(['GET', 'POST'], 'numero-por-extenso', 'NumberToWords::index');

// Ordenador de Texto
$routes->match(['GET', 'POST'], 'ordenador-texto', 'TextSorter::index');
$routes->post('ordenador-texto/sort', 'TextSorter::sort');

// Gerador de Cartão de Crédito
$routes->match(['GET', 'POST'], 'gerador-cartao', 'CreditCardGenerator::index');
$routes->post('gerador-cartao/generate', 'CreditCardGenerator::generate');

// Gerador de String Aleatória
$routes->match(['GET', 'POST'], 'gerador-string', 'RandomStringGenerator::index');
$routes->post('gerador-string/generate', 'RandomStringGenerator::generate');

// Conversor de Texto
$routes->match(['GET', 'POST'], 'conversor-texto', 'TextConverter::index');
$routes->post('conversor-texto/convert', 'TextConverter::convert');

// Consulta de Banco
$routes->match(['GET', 'POST'], 'consulta-banco', 'BankLookup::index');
$routes->post('consulta-banco/search', 'BankLookup::search');

// Inversor de Texto
$routes->match(['GET', 'POST'], 'inverter-texto', 'TextInverter::index');
$routes->post('inverter-texto/reverse', 'TextInverter::reverse');

// Contador de Caracteres
$routes->match(['GET', 'POST'], 'contador-caracteres', 'CharacterCounter::index');
$routes->post('contador-caracteres/analyze', 'CharacterCounter::analyze');

// Contador de Palavras
$routes->match(['GET', 'POST'], 'contador-palavras', 'WordCounter::index');
$routes->post('contador-palavras/count', 'WordCounter::count');

// Gerador de Meta Tags
$routes->match(['GET', 'POST'], 'gerador-meta-tags', 'MetaTagsGenerator::index');

// Sitemap
$routes->get('sitemap.xml', 'Sitemap::index');
$routes->get('gerar-sitemap', 'Sitemap::generate');

// Conversor de Temperatura
$routes->match(['GET', 'POST'], 'conversor-temperatura', 'TemperatureConverter::index');
$routes->post('conversor-temperatura/convert', 'TemperatureConverter::convert');

// Conversor de Tempo
$routes->match(['GET', 'POST'], 'conversor-tempo', 'TimeConverter::index');
$routes->post('conversor-tempo/convert', 'TimeConverter::convert');

// Conversor de Peso
$routes->match(['GET', 'POST'], 'conversor-peso', 'WeightConverter::index');
$routes->post('conversor-peso/convert', 'WeightConverter::convert');

// Conversor de Comprimento
$routes->match(['GET', 'POST'], 'conversor-comprimento', 'LengthConverter::index');
$routes->post('conversor-comprimento/convert', 'LengthConverter::convert');

// Conversor de Área
$routes->match(['GET', 'POST'], 'conversor-area', 'AreaConverter::index');
$routes->post('conversor-area/convert', 'AreaConverter::convert');

// Conversor de Volume
$routes->match(['GET', 'POST'], 'conversor-volume', 'VolumeConverter::index');
$routes->post('conversor-volume/convert', 'VolumeConverter::convert');

// Conversor de Velocidade
$routes->match(['GET', 'POST'], 'conversor-velocidade', 'SpeedConverter::index');
$routes->post('conversor-velocidade/convert', 'SpeedConverter::convert');

// Conversor de Ângulos
$routes->match(['GET', 'POST'], 'conversor-angulos', 'AngleConverter::index');
$routes->post('conversor-angulos/convert', 'AngleConverter::convert');

// Rotas para as ferramentas de desenvolvedor
$routes->match(['GET', 'POST'], 'texto-para-html', 'HtmlConverter::index');
$routes->match(['GET', 'POST'], 'informacoes-caractere', 'CharInfo::index');
$routes->match(['GET', 'POST'], 'removedor-acentos', 'AcentoRemover::index');
$routes->post('removedor-acentos/remover', 'AcentoRemover::removerAcentos');
$routes->match(['GET', 'POST'], 'base64', 'Base64Converter::index');
$routes->post('base64/process', 'Base64Converter::process');

// Rotas para o codificador MD5
$routes->match(['GET', 'POST'], 'md5', 'MD5Encoder::index');
$routes->post('md5/encode', 'MD5Encoder::encode');

// Rotas para o codificador SHA1
$routes->match(['GET', 'POST'], 'sha1', 'SHA1Encoder::index');
$routes->post('sha1/encode', 'SHA1Encoder::encode');

// Rotas para o gerador de QR Code
$routes->match(['GET', 'POST'], 'qrcode', 'QRCodeGenerator::index');
$routes->post('qrcode/download', 'QRCodeGenerator::download');

// Rotas para Subtrair Dias
$routes->match(['GET', 'POST'], 'subtrair-dias', 'DateSubtractor::index');
$routes->post('date-subtractor/calculate', 'DateSubtractor::calculate');

// Rotas para Adicionar Dias
$routes->match(['GET', 'POST'], 'adicionar-dias', 'DateAdder::index');
$routes->post('date-adder/calculate', 'DateAdder::calculate');

// Rotas para Unix Timestamp
$routes->match(['GET', 'POST'], 'unix-timestamp', 'UnixTimestamp::index');
$routes->post('unix-timestamp/convert', 'UnixTimestamp::convert');

// Rotas para o Gerador de Favicon
$routes->match(['GET', 'POST'], 'favicon-generator', 'FaviconGenerator::index');
$routes->post('favicon-generator/generate', 'FaviconGenerator::generate');
$routes->get('favicon-generator/download/(:segment)', 'FaviconGenerator::download/$1');

// Rotas para o Conversor de Unidades CSS
$routes->match(['GET', 'POST'], 'conversor-unidades', 'UnitConverter::index');
$routes->post('unit-converter/convert', 'UnitConverter::convert');

// Gerador de Gradientes
$routes->match(['GET', 'POST'], 'gerador-gradientes', 'GradientGenerator::index');
$routes->post('gerador-gradientes/generate', 'GradientGenerator::generate');

// Seletor de Cores
$routes->match(['GET', 'POST'], 'color-picker', 'ColorPicker::index');

// Tabela ASCII
$routes->match(['GET', 'POST'], 'tabela-ascii', 'AsciiTable::index');

// Conversor de Números Romanos
$routes->match(['GET', 'POST'], 'romanos', 'RomanConverter::index');
$routes->post('romanos/convert', 'RomanConverter::convert');

// Cálculo da Área do Círculo
$routes->match(['GET', 'POST'], 'area-circulo', 'CircleArea::index');
$routes->post('area-circulo/calcular', 'CircleArea::calculate');

// Cálculo da Área do Quadrado/Retângulo
$routes->match(['GET', 'POST'], 'area-retangulo', 'RectangleArea::index');
$routes->post('area-retangulo/calcular', 'RectangleArea::calculate');

// Cálculo da Área do Triângulo
$routes->match(['GET', 'POST'], 'area-triangulo', 'TriangleArea::index');
$routes->post('area-triangulo/calcular', 'TriangleArea::calculate');

// Cálculo da Área do Losango
$routes->match(['GET', 'POST'], 'area-losango', 'RhombusArea::index');
$routes->post('area-losango/calcular', 'RhombusArea::calculate');

// Cálculo da Área do Trapézio
$routes->match(['GET', 'POST'], 'area-trapezio', 'TrapezoidArea::index');
$routes->post('area-trapezio/calcular', 'TrapezoidArea::calculate');

// Cálculo da Área do Paralelogramo
$routes->match(['GET', 'POST'], 'area-paralelogramo', 'ParallelogramArea::index');
$routes->post('area-paralelogramo/calcular', 'ParallelogramArea::calculate');

// Cálculo da Área do Setor Circular
$routes->match(['GET', 'POST'], 'area-setor-circular', 'CircularSectorArea::index');
$routes->post('area-setor-circular/calcular', 'CircularSectorArea::calculate');

// Gerador de Gradientes
$routes->match(['GET', 'POST'], 'gerador-gradientes', 'GradientGenerator::index');
$routes->post('gerador-gradientes/gerar', 'GradientGenerator::generate');

// Contador entre Datas
$routes->match(['GET', 'POST'], 'contador-datas', 'DateDifference::index');
$routes->post('contador-datas/calcular', 'DateDifference::calculate');


// Cálculo da Área de Polígonos Regulares
$routes->match(['GET', 'POST'], 'area-poligono-regular', 'RegularPolygonArea::index');
$routes->post('area-poligono-regular/calcular', 'RegularPolygonArea::calculate');

// Rotas para o conversor Binário/Hexadecimal
$routes->match(['GET', 'POST'], 'binhex', 'BinHexConverter::index');
$routes->post('binhex/convert', 'BinHexConverter::convert');

// Rotas para o codificador/decodificador de URL
$routes->match(['GET', 'POST'], 'urlencode', 'UrlEncoder::index');
$routes->post('urlencode/process', 'UrlEncoder::process');
