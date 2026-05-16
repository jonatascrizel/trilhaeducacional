<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class configModel extends Model
{
  protected $table = 'config';
  protected $primaryKey = 'id';
  protected $useAutoIncrement = true;
  protected $returnType = 'object';

  protected $allowedFields = ['configName', 'configValue', 'descricao'];
}
