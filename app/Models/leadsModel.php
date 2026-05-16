<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class leadsModel extends Model
{
  protected $table = 'leads';
  protected $primaryKey = 'email';
  protected $useAutoIncrement = false;
  protected $returnType = 'object';
  protected $beforeInsert = ['adicionarCampoNovo'];

  protected $allowedFields = ['email', 'nome', 'wpp','cod_validacao','created_at','validado_em'];

  protected function adicionarCampoNovo(array $data)
  {
    // Este código só roda no INSERT
    $data['data']['cod_validacao'] = uniqid();
    $data['data']['created_at'] = date('Y-m-d H:i:s');
    
    return $data;
  }
}

