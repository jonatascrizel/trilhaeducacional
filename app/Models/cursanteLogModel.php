<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class cursanteLogModel extends Model
{
  protected $table = 'cursante_log';
  protected $primaryKey = 'id';
  protected $useAutoIncrement = false;
  protected $returnType = 'object';
  protected $beforeInsert = ['adicionarCampoNovo'];

  protected $allowedFields = ['id','id_cursante','registro','dataHora'];

  protected function adicionarCampoNovo(array $data){
    // Este código só roda no INSERT
    $data['data']['id'] = uniqid();  
    $data['data']['dataHora'] = date('Y-m-d H:i:s');
    return $data;
  }
}
