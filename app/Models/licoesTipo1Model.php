<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class licoesTipo1Model extends Model
{
  protected $table = 'cursos_licoes_tipo_1';
  protected $primaryKey = 'id';
  protected $useAutoIncrement = false; // Essencial para UUID
  protected $returnType = 'object';

  protected $allowedFields = [
    'id',
    'id_cursos_licoes',
    'pergunta',
    'resposta1',
    'resposta2',
    'resposta3',
    'resposta4',
    'resposta5',
    'resposta_certa',
  ];
}
