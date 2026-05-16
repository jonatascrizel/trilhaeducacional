<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class licoesModel extends Model
{
  protected $table = 'cursos_licoes';
  protected $primaryKey = 'id';
  protected $useAutoIncrement = false; // Essencial para UUID
  protected $returnType = 'object';
  protected $useSoftDeletes = true;
  protected $dateFormat = 'datetime';

  protected $allowedFields = ['id','id_cursos_unidades','ordem','id_cursos_licoes_tipo','titulo','pergunta','resposta1','resposta2','resposta3','resposta4','resposta5','resposta_certa','leitura','recomendacao_txt','recomendacao_img','video','pergunta_desc','card1_img','card1_alt','card2_img','card2_alt','card3_img','card3_alt','card4_img','card4_alt','card5_img','card5_alt','card6_img','card6_alt','deleted_at'];
}
