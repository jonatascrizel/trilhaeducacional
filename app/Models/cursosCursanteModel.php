<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class cursosCursanteModel extends Model
{
  protected $table = 'cursante_cursos';
  protected $primaryKey = 'id';
  protected $useAutoIncrement = false;
  protected $returnType = 'object';
  protected $beforeInsert = ['adicionarCampoNovo'];

  protected $allowedFields = ['id','id_cursante','id_cursos','ultimo_acesso'];

  protected function adicionarCampoNovo(array $data){
    // Este código só roda no INSERT
    $data['data']['id'] = uniqid();  
    return $data;
  }
}
