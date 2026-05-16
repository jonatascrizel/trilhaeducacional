<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class unidadesModel extends Model
{
  protected $table = 'cursos_unidades';
  protected $primaryKey = 'id';
  protected $returnType = 'object';

  protected $allowedFields = ['id','id_curso','unidade','numero','descricao'];
}
