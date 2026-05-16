<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class textosModel extends Model
{
  protected $table = 'textos';
  protected $primaryKey = 'id';
  protected $useAutoIncrement = true;
  protected $returnType = 'object';

  protected $allowedFields = ['nome', 'assunto', 'subheading', 'conteudo', 'coringas'];
}
