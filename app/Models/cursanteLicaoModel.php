<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class cursanteLicaoModel extends Model
{
  protected $table = 'cursante_licoes';
  protected $primaryKey = 'id';
  protected $useAutoIncrement = false;
  protected $returnType = 'object';
  protected $beforeInsert = ['adicionarCampoNovo'];

  protected $allowedFields = ['id','id_cursante','id_licao','feita_em','resposta'];

  protected function adicionarCampoNovo(array $data){
    // Este código só roda no INSERT
    $data['data']['id'] = uniqid();  
    return $data;
  }

  public function getRespostas($id_curso, $id_cursante = null, $id_unidade = null){
      $sql = 'SELECT
                cs.nome as curso,
                c.nome,
                cu.numero,
                cu.unidade,
                cl.ordem,
                CASE
                  WHEN cl.id_cursos_licoes_tipo = 1 THEN clt1.pergunta
                  WHEN cl.id_cursos_licoes_tipo = 5 THEN clt5.pergunta_desc
                  WHEN cl.id_cursos_licoes_tipo = 7 THEN clt7.enunciado
                  WHEN cl.id_cursos_licoes_tipo = 8 THEN clt8.vouf_pergunta
                END AS questao,
                CASE
                  WHEN cl.id_cursos_licoes_tipo = 1 THEN clt1.resposta_certa
                  WHEN cl.id_cursos_licoes_tipo = 5 THEN ""
                  WHEN cl.id_cursos_licoes_tipo = 7 THEN CONCAT_WS(",", clt7.colB1, clt7.colB2, clt7.colB3, clt7.colB4, clt7.colB5)
                  WHEN cl.id_cursos_licoes_tipo = 8 THEN clt8.vouf
                END AS resposta_certa,
                cul.feita_em,
                cul.resposta
              FROM
                cursante_licoes cul,
                cursante c,
                cursos cs,
                cursos_unidades cu,
                cursos_licoes cl
                LEFT JOIN cursos_licoes_tipo_1 clt1 ON clt1.id_cursos_licoes = cl.id
                LEFT JOIN cursos_licoes_tipo_5 clt5 ON clt5.id_cursos_licoes = cl.id
                LEFT JOIN cursos_licoes_tipo_7 clt7 ON clt7.id_cursos_licoes = cl.id
                LEFT JOIN cursos_licoes_tipo_8 clt8 ON clt8.id_cursos_licoes = cl.id
              WHERE
                cs.id = '.$id_curso.'
                AND cu.id_curso = cs.id
                AND cu.id = cl.id_cursos_unidades
                AND cl.id_cursos_licoes_tipo IN (1,5,7,8)
                AND cul.id_licao = cl.id
                AND cul.id_cursante = c.id
              ';
    
    if($id_cursante != null) {
      $sql .= 'AND c.id = "'.$id_cursante.'" ';
    }
    
    if($id_unidade != null) {
      $sql .= 'AND cu.id = "'.$id_unidade.'" ';
    }
    
    $sql .= ' ORDER BY
                c.nome ASC,
                cu.numero ASC,
                cl.ordem ASC';


    //echo '<pre>'; print_r($sql); die;
    $query = $this->db->query($sql)->getResult();

    return $query;
  }
}
