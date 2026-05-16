<?php

function limitaTxt($txt, $limite = 10, $complemento = '...')
{
  return mb_strimwidth($txt, 0, $limite, $complemento, 'utf-8');
}

function slugify($string, $slug = '-')
{
  $string = preg_replace('/[\t\n]/', ' ', $string);
  $string = preg_replace('/\s{2,}/', ' ', $string);
  $list = array(
    'Š' => 'S',
    'š' => 's',
    'Đ' => 'Dj',
    'đ' => 'dj',
    'Ž' => 'Z',
    'ž' => 'z',
    'Č' => 'C',
    'č' => 'c',
    'Ć' => 'C',
    'ć' => 'c',
    'À' => 'A',
    'Á' => 'A',
    'Â' => 'A',
    'Ã' => 'A',
    'Ä' => 'A',
    'Å' => 'A',
    'Æ' => 'A',
    'Ç' => 'C',
    'È' => 'E',
    'É' => 'E',
    'Ê' => 'E',
    'Ë' => 'E',
    'Ì' => 'I',
    'Í' => 'I',
    'Î' => 'I',
    'Ï' => 'I',
    'Ñ' => 'N',
    'Ò' => 'O',
    'Ó' => 'O',
    'Ô' => 'O',
    'Õ' => 'O',
    'Ö' => 'O',
    'Ø' => 'O',
    'Ù' => 'U',
    'Ú' => 'U',
    'Û' => 'U',
    'Ü' => 'U',
    'Ý' => 'Y',
    'Þ' => 'B',
    'ß' => 'Ss',
    'à' => 'a',
    'á' => 'a',
    'â' => 'a',
    'ã' => 'a',
    'ä' => 'a',
    'å' => 'a',
    'æ' => 'a',
    'ç' => 'c',
    'è' => 'e',
    'é' => 'e',
    'ê' => 'e',
    'ë' => 'e',
    'ì' => 'i',
    'í' => 'i',
    'î' => 'i',
    'ï' => 'i',
    'ð' => 'o',
    'ñ' => 'n',
    'ò' => 'o',
    'ó' => 'o',
    'ô' => 'o',
    'õ' => 'o',
    'ö' => 'o',
    'ø' => 'o',
    'ù' => 'u',
    'ú' => 'u',
    'û' => 'u',
    'ý' => 'y',
    'ý' => 'y',
    'þ' => 'b',
    'ÿ' => 'y',
    'Ŕ' => 'R',
    'ŕ' => 'r',
    '/' => '-',
    ' ' => '-',
    '.' => '-',
    ',' => '-',
    ';' => '-',
    ':' => '-',
    '\\' => '-',
    '*' => '-',
    '(' => '-',
    ')' => '-',
    ']' => '-',
    '[' => '-',
    '?' => '-',
    '!' => '-',
    '@' => '-',
    '#' => '-',
  );

  $string = strtr($string, $list);
  $string = preg_replace('/-{2,}/', $slug, $string);
  $string = strtolower($string);

  return $string;
}

function gerarSenha($tamanho = 8, $maiusculas = false, $numeros = true, $simbolos = false)
{
  // Caracteres de cada tipo 
  $lmin = 'abcdefghijklmnopqrstuvwxyz';
  $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $num = '1234567890';
  $simb = '!@#$%*-';

  // Variáveis internas 
  $retorno = '';
  $caracteres = '';

  // Agrupamos todos os caracteres que poderão ser utilizados 
  $caracteres .= $lmin;
  if ($maiusculas)
    $caracteres .= $lmai;
  if ($numeros)
    $caracteres .= $num;
  if ($simbolos)
    $caracteres .= $simb;

  // Calculamos o total de caracteres possíveis 
  $len = strlen($caracteres);
  for ($n = 1; $n <= $tamanho; $n++) {
    // Criamos um número aleatório de 1 até $len para pegar um dos caracteres 
    $rand = mt_rand(1, $len);

    // Concatenamos um dos caracteres na variável $retorno 
    $retorno .= $caracteres[$rand - 1];
  }
  return $retorno;
}

function formatCnpjCpf($value) {
  $CPF_LENGTH = 11;
  $cnpj_cpf = preg_replace("/\D/", '', $value);
  
  if (strlen($cnpj_cpf) === $CPF_LENGTH) {
    return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);
  } 
  
  return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
}

function formataCEP($value){
  $value = preg_replace("/\D/", '', $value);
  return preg_replace("/(\d{5})(\d{3})/", "\$1-\$2", $value);
}

function limpaCnpjCpf($value){
  $remover = ['.','-','/'];

  return str_replace($remover,'',$value);
}

function formataTempo($tempo){
  if($tempo < 60){ // menos que uma hora
    return number_format($tempo,0).' minutos';
  }elseif($tempo >= 60 && $tempo < 1440){//entre uma hora completa e 24 horas
    return floor($tempo/60).' horas '.number_format(floor($tempo%60),0).' minutos';
  }else{ // mais de um dia
    return number_format(floor($tempo/1440),0).' dias '.number_format(floor(($tempo%1440)/60),0).' horas '.number_format($tempo%60,0).' minutos';
  }
}

function formataTempoDias($tempo){
  return number_format(ceil($tempo/1440),0);
}

//validação do reCaptcha enterprise
function verificarEnterprise($token, $reCaptchaKey, $gApiKey, $projectID)  {
  // Se alguma chave estiver vazia, ele lança a exceção que você viu
  if (!$reCaptchaKey || !$gApiKey || !$projectID) {
      throw new \Exception("O reCaptcha não está configurado. Verifique as chaves no .env");
  }

  if (empty($token)) {
      return false; // Token não veio do front-end
  }

  // URL do endpoint Enterprise
  $url = "https://recaptchaenterprise.googleapis.com/v1/projects/{$projectID}/assessments?key={$gApiKey}";

  //$client = \Config\Services::httpclient();
  $client = \Config\Services::curlrequest();

  try {
      $response = $client->setJSON([
          'event' => [
              'token'    => $token,
              'siteKey'  => $reCaptchaKey,
              'expectedAction' => 'USER_ACTION' // Opcional
          ]
      ])->post($url);

      $result = json_decode($response->getBody());

      // Validação robusta: 
      // 1. O token deve ser válido
      // 2. A pontuação de risco deve ser aceitável (maior ou igual a 0.5)
      if (isset($result->tokenProperties->valid) && $result->tokenProperties->valid === true) {
          $score = $result->riskAnalysis->score ?? 0;
          return $score >= 0.5;
      }

      return false;
  } catch (\Exception $e) {
      log_message('error', '[reCAPTCHA Erro]: ' . $e->getMessage());
      return false;
  }
}

function gerarUUID() {
    $data = random_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // Define a versão 4
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // Define a variante
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}