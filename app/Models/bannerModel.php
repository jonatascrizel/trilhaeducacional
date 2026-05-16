<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class bannerModel extends Model
{
  protected $table = 'banners';
  protected $primaryKey = 'id';
  protected $returnType = 'object';

  protected $allowedFields = ['nome','imagem','titulo','frase_apoio','link'];
}
