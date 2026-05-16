<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class licoesTipo7Model extends Model
{
  protected $table = 'cursos_licoes_tipo_7';
  protected $primaryKey = 'id';
  protected $useAutoIncrement = false; // Essencial para UUID
  protected $returnType = 'object';

  protected $allowedFields = [
    'id',
    'id_cursos_licoes',
    'enunciado',
    'colA1',
    'colA2',
    'colA3',
    'colA4',
    'colA5',
    'colB1',
    'colB2',
    'colB3',
    'colB4',
    'colB5',
  ];
}
