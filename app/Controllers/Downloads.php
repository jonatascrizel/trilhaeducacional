<?php

namespace App\Controllers;

require('../vendor/autoload.php');

use App\Models\cursanteLicaoModel;

class downloads extends BaseController
{

    public function __construct() {
        $this->cursanteLicaoModel = new cursanteLicaoModel();
    }

    public function index(){
        return redirect()->to(base_url('/'));
    }

    public function aVerRespostasCursante($id_cursante, $id_curso){
      helper('xmlwriter');

      $respostas = $this->cursanteLicaoModel->getRespostas($id_curso, $id_cursante);
      $dados = [];
      foreach($respostas as $r){
        $dados[] = [
          'curso' => $r->curso,
          'nome' => $r->nome,
          'unidade' => $r->numero.' '.$r->unidade,
          'questao' => $r->questao,
          'resposta_certa' => $r->resposta_certa,
          'resposta' => $r->resposta,
          'feita_em' => $r->feita_em,
        ];
      }
      //echo '<pre>'; print_r($dados); die;


      $header = [
        'Curso'=>'string',
        'Nome'=>'string',
        'Unidade'=>'string',
        'Questão'=>'string',
        'Resposta certa'=>'string',
        'Resposta'=>'string',
        'Respondido em'=>'string',
        ];
      
      //echo '<pre>'; print_r($header); die;

      gravaXLS($dados, slugify('respostas-individual') . '.xlsx', $header);
    }

    public function aVerRespostas($id_curso){
      helper('xmlwriter');

      $respostas = $this->cursanteLicaoModel->getRespostas($id_curso);
      $dados = [];
      foreach($respostas as $r){
        $dados[] = [
          'curso' => $r->curso,
          'nome' => $r->nome,
          'unidade' => $r->numero.' '.$r->unidade,
          'questao' => $r->questao,
          'resposta_certa' => $r->resposta_certa,
          'resposta' => $r->resposta,
          'feita_em' => $r->feita_em,
        ];
      }
      //echo '<pre>'; print_r($dados); die;


      $header = [
        'Curso'=>'string',
        'Nome'=>'string',
        'Unidade'=>'string',
        'Questão'=>'string',
        'Resposta certa'=>'string',
        'Resposta'=>'string',
        'Respondido em'=>'string',
        ];
      
      //echo '<pre>'; print_r($header); die;

      gravaXLS($dados, slugify('respostas-curso') . '.xlsx', $header);
    }

}
