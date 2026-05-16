<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class manualModel extends Model
{
  protected $table = 'menus';
  protected $primaryKey = 'id';
  protected $returnType = 'object';

  protected $allowedFields = ['manual'];
}
