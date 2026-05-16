<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class cursosModel extends Model
{
  protected $table = 'cursos';
  protected $primaryKey = 'id';
  protected $returnType = 'object';

  protected $allowedFields = ['id','nome','descricao'];
}
