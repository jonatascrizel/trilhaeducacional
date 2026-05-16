<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class licoesTipo6Model extends Model
{
  protected $table = 'cursos_licoes_tipo_6';
  protected $primaryKey = 'id';
  protected $useAutoIncrement = false; // Essencial para UUID
  protected $returnType = 'object';

  protected $allowedFields = [
    'id',
    'id_cursos_licoes',
    'card1_img',
    'card1_alt',
    'card2_img',
    'card2_alt',
    'card3_img',
    'card3_alt',
    'card4_img',
    'card4_alt',
    'card5_img',
    'card5_alt',
    'card6_img',
    'card6_alt'
  ];
}
