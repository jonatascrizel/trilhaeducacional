<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class licoesTipo8Model extends Model
{
  protected $table = 'cursos_licoes_tipo_8';
  protected $primaryKey = 'id';
  protected $useAutoIncrement = false; // Essencial para UUID
  protected $returnType = 'object';

  protected $allowedFields = [
    'id',
    'id_cursos_licoes',
    'vouf_pergunta',
    'vouf',
  ];
}
