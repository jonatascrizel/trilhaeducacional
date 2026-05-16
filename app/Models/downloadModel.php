<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class downloadModel extends Model
{
  protected $table = '';
  protected $primaryKey = 'id';
  protected $returnType = 'object';

  protected $allowedFields = ['nome','imagem','titulo','frase_apoio','link'];
}
