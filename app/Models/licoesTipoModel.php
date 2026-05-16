<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class licoesTipoModel extends Model
{
  protected $table = 'cursos_licoes_tipos';
  protected $primaryKey = 'id';
  protected $returnType = 'object';

  protected $allowedFields = ['id','icone','tipo'];
}
