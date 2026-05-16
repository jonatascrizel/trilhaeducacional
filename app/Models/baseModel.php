<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class baseModel extends Model
{
  public $tp_documento = [
    1 => 'CPF',
    2 => 'CNPJ',
  ];

}
