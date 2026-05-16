<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class cursanteModel extends Model
{
  protected $table = 'cursante';
  protected $primaryKey = 'id';
  protected $useAutoIncrement = false; // Essencial para UUID
  protected $returnType = 'object';

  protected $allowedFields = ['id','nome','apelido','email','telefone','senha','troca_senha','notfica_progressao_eml','notfica_progressao_wpp','perfil_publico'];
}
