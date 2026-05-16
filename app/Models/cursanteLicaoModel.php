<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class cursanteLicaoModel extends Model
{
  protected $table = 'cursante_licoes';
  protected $primaryKey = 'id';
  protected $useAutoIncrement = false;
  protected $returnType = 'object';
  protected $beforeInsert = ['adicionarCampoNovo'];

  protected $allowedFields = ['id','id_cursante','id_licao','feita_em','resposta'];

  protected function adicionarCampoNovo(array $data){
    // Este código só roda no INSERT
    $data['data']['id'] = uniqid();  
    return $data;
  }
}
