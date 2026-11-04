<?php

namespace App\Controllers;

require('../vendor/autoload.php');

use App\Models\unidadesModel;
use App\Models\licoesModel;
use App\Models\licoesTipoModel;
use App\Models\manualModel;

use App\Models\licoesTipo1Model;
use App\Models\licoesTipo2Model;
use App\Models\licoesTipo3Model;
use App\Models\licoesTipo4Model;
use App\Models\licoesTipo5Model;
use App\Models\licoesTipo6Model;
use App\Models\licoesTipo7Model;
use App\Models\licoesTipo8Model;


class Licoes extends BaseController
{
  public function __construct() {
    check_menu_access(52);
    //parent::__construct();
    $this->licoesModel = new licoesModel();
    $this->licoesTipoModel = new licoesTipoModel();
    $this->licoesTipo1Model = new licoesTipo1Model();
    $this->licoesTipo2Model = new licoesTipo2Model();
    $this->licoesTipo3Model = new licoesTipo3Model();
    $this->licoesTipo4Model = new licoesTipo4Model();
    $this->licoesTipo5Model = new licoesTipo5Model();
    $this->licoesTipo6Model = new licoesTipo6Model();
    $this->licoesTipo7Model = new licoesTipo7Model();
    $this->licoesTipo8Model = new licoesTipo8Model();
    
    $this->manualModel = new manualModel();
    $this->manual = $this->manualModel->where('id', 52)->first()->manual;
  }

  public function index() {
    return redirect()->to(base_url('cursos'));
  }

  public function ver($id) {
    $txt = $this->licoesModel
                ->join('cursos_licoes_tipos', 'id_cursos_licoes_tipo = cursos_licoes_tipos.id')
                ->where('id_cursos_unidades', $id)
                ->orderBy('ordem', 'asc')
                ->findAll();

    $html = '<div class="row">';
    foreach($txt as $t){
      $html .= '
        <div class="col-4 mb-1 border-bottom">Unidade ' . $t->titulo . '</div>
        <div class="col-8 mb-1 border-bottom">' . $t->tipo . '</div>
      ';
    }

    $html .= '</div>
    ';
    return $html;
  }

  public function add($id) {
    $data['id_cursos_unidades'] = $id;    
    $data['tipos'] = $this->licoesTipoModel->findAll();
    $data['manual'] = $this->manual;

    return view('licoes_add', $data);
  }

  public function edit($id) {
    $data['id'] = $id;

    $licao = $this->licoesModel->where('id', $id)->first();
    $breadcumb = $this->db->query('SELECT
                                      c.id AS id_curso,
                                      c.nome AS curso,
                                      u.id AS id_unidade,
                                      u.unidade
                                    FROM
                                      cursos c,
                                      cursos_unidades u
                                    WHERE
                                      u.id_curso = c.id
                                      AND u.id = '.$licao->id_cursos_unidades)->getResult();
    

    if($licao->id_cursos_licoes_tipo == 1){
      $conteudo = $this->licoesTipo1Model->where('id_cursos_licoes', $id)->first();
    }elseif($licao->id_cursos_licoes_tipo == 2){
      $conteudo = $this->licoesTipo2Model->where('id_cursos_licoes', $id)->first();
    }elseif($licao->id_cursos_licoes_tipo == 3){
      $conteudo = $this->licoesTipo3Model->where('id_cursos_licoes', $id)->first();
    }elseif($licao->id_cursos_licoes_tipo == 4){
      $conteudo = $this->licoesTipo4Model->where('id_cursos_licoes', $id)->first();
    }elseif($licao->id_cursos_licoes_tipo == 5){
      $conteudo = $this->licoesTipo5Model->where('id_cursos_licoes', $id)->first();
    }elseif($licao->id_cursos_licoes_tipo == 6){
      $conteudo = $this->licoesTipo6Model->where('id_cursos_licoes', $id)->first();
    }elseif($licao->id_cursos_licoes_tipo == 7){
      $conteudo = $this->licoesTipo7Model->where('id_cursos_licoes', $id)->first();
    }elseif($licao->id_cursos_licoes_tipo == 8){
      $conteudo = $this->licoesTipo8Model->where('id_cursos_licoes', $id)->first();
    }

    //echo '<pre>'; var_dump($conteudo); die;
    $data['txt'] = $licao;
    $data['conteudo'] = $conteudo;
    $data['breadcumb'] = $breadcumb[0];
    
    $data['tipos'] = $this->licoesTipoModel->findAll();
    $data['manual'] = $this->manual;

    return view('licoes_edit', $data);
  }

  public function update() {
    log_message('info', 'O usuário '.$this->session->get('user_name').' editou a lição '.$this->request->getVar('titulo'));

    $data = [
      'id' => $this->request->getVar('id'),
      'id_cursos_unidades' => $this->request->getVar('id_cursos_unidades'),
      'ordem' => $this->request->getVar('ordem'),
      'id_cursos_licoes_tipo' => $this->request->getVar('id_cursos_licoes_tipo'),
      'titulo' => $this->request->getVar('titulo'),
    ];

    if($this->request->getVar('id') == ''){
      $data['id'] = gerarUUID();
      $id = $this->licoesModel->insert($data);
    } else {
      $id = $this->request->getVar('id');
      $this->licoesModel->update($id, $data);
    }

    $save = $this->licoesModel->save($data);
    //echo '<pre>'; var_dump($save); die;

    switch($this->request->getVar('id_cursos_licoes_tipo')){
      case 1:
        $data2 = [
                'id_cursos_licoes' => $id,
                'pergunta' => $this->request->getVar('pergunta'),
                'resposta1' => $this->request->getVar('resposta1'),
                'resposta2' => $this->request->getVar('resposta2'),
                'resposta3' => $this->request->getVar('resposta3'),
                'resposta4' => $this->request->getVar('resposta4'),
                'resposta5' => $this->request->getVar('resposta5'),
                'resposta_certa' => $this->request->getVar('resposta_certa'),
        ];
        if($this->request->getVar('id_conteudo') == ''){
          $data2['id'] = gerarUUID();
          $id = $this->licoesTipo1Model->insert($data2);
        } else {
          $id = $this->request->getVar('id_conteudo');
          $this->licoesTipo1Model->update($id, $data2);
        }
        break;
      case 2:
        $data2 = [
                'id_cursos_licoes' => $id,
                'leitura' => $this->request->getVar('leitura'),
          ];
        if($this->request->getVar('id_conteudo') == ''){
          $data2['id'] = gerarUUID();
          $id = $this->licoesTipo2Model->insert($data2);
        } else {
          $id = $this->request->getVar('id_conteudo');
          $this->licoesTipo2Model->update($id, $data2);
        }
        break;
      case 3:
        $data2 = [
                'id_cursos_licoes' => $id,
                'recomendacao_txt' => $this->request->getVar('recomendacao_txt'),
          ];
        $img = $this->request->getFile('recomendacao_img');
        if ($img && $img->isValid()) {
          $nome_img = slugify($this->request->getVar('titulo')).'.'.$img->getClientExtension();
          //die($nome_img);
          $path = $img->move(FCPATH .'uploads/', $nome_img, true);

          $data2['recomendacao_img'] = $nome_img;
        }
        if($this->request->getVar('id_conteudo') == ''){
          $data2['id'] = gerarUUID();
          $id = $this->licoesTipo3Model->insert($data2);
        } else {
          $id = $this->request->getVar('id_conteudo');
          $this->licoesTipo3Model->update($id, $data2);
        }
        break;
      case 4:
        $data2 = [
                'id_cursos_licoes' => $id,
                'video' => $this->request->getVar('video'),
          ];
        if($this->request->getVar('id_conteudo') == ''){
          $data2['id'] = gerarUUID();
          $id = $this->licoesTipo4Model->insert($data2);
        } else {
          $id = $this->request->getVar('id_conteudo');
          $this->licoesTipo4Model->update($id, $data2);
        }
        break;
      case 5:
        $data2 = [
                'id_cursos_licoes' => $id,
                'pergunta_desc' => $this->request->getVar('pergunta_desc'),
          ];
        if($this->request->getVar('id_conteudo') == ''){
          $data2['id'] = gerarUUID();
          $id = $this->licoesTipo5Model->insert($data2);
        } else {
          $id = $this->request->getVar('id_conteudo');
          $this->licoesTipo5Model->update($id, $data2);
        }
        break;
      case 6:
        $data2 = [
                'id_cursos_licoes' => $id,
                'card1_img' => $this->request->getVar('card1_img'),
                'card1_alt' => $this->request->getVar('card1_alt'),
                'card2_img' => $this->request->getVar('card2_img'),
                'card2_alt' => $this->request->getVar('card2_alt'),
                'card3_img' => $this->request->getVar('card3_img'),
                'card3_alt' => $this->request->getVar('card3_alt'),
                'card4_img' => $this->request->getVar('card4_img'),
                'card4_alt' => $this->request->getVar('card4_alt'),
                'card5_img' => $this->request->getVar('card5_img'),
                'card5_alt' => $this->request->getVar('card5_alt'),
                'card6_img' => $this->request->getVar('card6_img'),
                'card6_alt' => $this->request->getVar('card6_alt'),
          ];
        $img = $this->request->getFile('card1_img');
        if ($img && $img->isValid()) {
          $nome_img = slugify($this->request->getVar('titulo')).'01.'.$img->getClientExtension();
          $path = $img->move(ROOTPATH.'/public/uploads/', $nome_img, true);

          $data2['card1_img'] = $nome_img;
        }

        $img = $this->request->getFile('card2_img');
        if ($img && $img->isValid()) {
          $nome_img = slugify($this->request->getVar('titulo')).'02.'.$img->getClientExtension();
          $path = $img->move(ROOTPATH.'/public/uploads/', $nome_img, true);

          $data2['card2_img'] = $nome_img;
        }

        $img = $this->request->getFile('card3_img');
        if ($img && $img->isValid()) {
          $nome_img = slugify($this->request->getVar('titulo')).'03.'.$img->getClientExtension();
          $path = $img->move(ROOTPATH.'/public/uploads/', $nome_img, true);

          $data2['card3_img'] = $nome_img;
        }

        $img = $this->request->getFile('card4_img');
        if ($img && $img->isValid()) {
          $nome_img = slugify($this->request->getVar('titulo')).'04.'.$img->getClientExtension();
          $path = $img->move(ROOTPATH.'/public/uploads/', $nome_img, true);

          $data2['card4_img'] = $nome_img;
        }

        $img = $this->request->getFile('card5_img');
        if ($img && $img->isValid()) {
          $nome_img = slugify($this->request->getVar('titulo')).'05.'.$img->getClientExtension();
          $path = $img->move(ROOTPATH.'/public/uploads/', $nome_img, true);

          $data2['card5_img'] = $nome_img;
        }

        $img = $this->request->getFile('card6_img');
        if ($img && $img->isValid()) {
          $nome_img = slugify($this->request->getVar('titulo')).'06.'.$img->getClientExtension();
          $path = $img->move(ROOTPATH.'/public/uploads/', $nome_img, true);

          $data2['card6_img'] = $nome_img;
        }
        if($this->request->getVar('id_conteudo') == ''){
          $data2['id'] = gerarUUID();
          $id = $this->licoesTipo6Model->insert($data2);
        } else {
          $id = $this->request->getVar('id_conteudo');
          $this->licoesTipo6Model->update($id, $data2);
        }
        break;
      case 7:
        $data2 = [
                'id_cursos_licoes' => $id,
                'enunciado' => $this->request->getVar('enunciado'),
                'colA1' => $this->request->getVar('colA1'),
                'colA2' => $this->request->getVar('colA2'),
                'colA3' => $this->request->getVar('colA3'),
                'colA4' => $this->request->getVar('colA4'),
                'colA5' => $this->request->getVar('colA5'),
                'colB1' => $this->request->getVar('colB1'),
                'colB2' => $this->request->getVar('colB2'),
                'colB3' => $this->request->getVar('colB3'),
                'colB4' => $this->request->getVar('colB4'),
                'colB5' => $this->request->getVar('colB5'),
          ];
        if($this->request->getVar('id_conteudo') == ''){
          $data2['id'] = gerarUUID();
          $id = $this->licoesTipo7Model->insert($data2);
        } else {
          $id = $this->request->getVar('id_conteudo');
          $this->licoesTipo7Model->update($id, $data2);
        }
        break;
      case 8:
        $data2 = [
                'id_cursos_licoes' => $id,
                'vouf_pergunta' => $this->request->getVar('vouf_pergunta'),
                'vouf' => $this->request->getVar('vouf'),
          ];
        if($this->request->getVar('id_conteudo') == ''){
          $data2['id'] = gerarUUID();
          $id = $this->licoesTipo8Model->insert($data2);
        } else {
          $id = $this->request->getVar('id_conteudo');
          $this->licoesTipo8Model->update($id, $data2);
        }
        break;
    }
      

    return redirect()->to(base_url('unidades/edit/'.$this->request->getVar('id_cursos_unidades').'?aba=licoes'));
  }

  public function aCard($id){
    $item = $this->licoesModel->where('id', $id)->first();

    if($item->id_cursos_licoes_tipo == 1){
      $card = $this->licoesTipo1Model->where('id_cursos_licoes', $item->id)->first();
      $html = '<p>'.$card->pergunta.'</p>

              <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                <label class="form-check-label" for="flexRadioDefault1">
                  '.$card->resposta1.'
                </label>
              </div>

              <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                <label class="form-check-label" for="flexRadioDefault2">
                  '.$card->resposta2.'
                </label>
              </div>

              <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault3">
                <label class="form-check-label" for="flexRadioDefault3">
                  '.$card->resposta3.'
                </label>
              </div>

              <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault4">
                <label class="form-check-label" for="flexRadioDefault4">
                  '.$card->resposta4.'
                </label>
              </div>

              <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault5">
                <label class="form-check-label" for="flexRadioDefault5">
                  '.$card->resposta5.'
                </label>
              </div>
      ';
    } elseif($item->id_cursos_licoes_tipo == 2){
      $card = $this->licoesTipo2Model->where('id_cursos_licoes', $item->id)->first();
      $html = $card->leitura;
    } elseif($item->id_cursos_licoes_tipo == 3){
      $card = $this->licoesTipo3Model->where('id_cursos_licoes', $item->id)->first();
      $html = '<div class="row">
                <div class="col">
                  <img src="'.base_url('uploads/'.$card->recomendacao_img).'" class="w-100" />
                </div>
                <div class="col">
                  '.nl2br($card->recomendacao_txt).'
                </div>
              </div>
              ';        
    } elseif($item->id_cursos_licoes_tipo == 4){
      $card = $this->licoesTipo4Model->where('id_cursos_licoes', $item->id)->first();
      $html = $card->video;
    } elseif($item->id_cursos_licoes_tipo == 5){
      $card = $this->licoesTipo5Model->where('id_cursos_licoes', $item->id)->first();
      $html = '
                <p>'.$card->pergunta_desc.'</p>
                <textarea class="form-control" id="resposta" name="resposta"></textarea>
              ';
    } elseif($item->id_cursos_licoes_tipo == 6){
      $card = $this->licoesTipo6Model->where('id_cursos_licoes', $item->id)->first();
      $html = '<div id="carouselCards" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                  <button type="button" data-bs-target="#carouselCards" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                  ';
                  if($card->card2_img != null){
                    $html .= '<button type="button" data-bs-target="#carouselCards" data-bs-slide-to="1" aria-label="Slide 2"></button> ';
                  }
                  if($card->card3_img != null){
                    $html .= '<button type="button" data-bs-target="#carouselCards" data-bs-slide-to="2" aria-label="Slide 3"></button> ';
                  }
                  if($card->card4_img != null){
                    $html .= '<button type="button" data-bs-target="#carouselCards" data-bs-slide-to="3" aria-label="Slide 4"></button> ';
                  }
                  if($card->card5_img != null){
                    $html .= '<button type="button" data-bs-target="#carouselCards" data-bs-slide-to="4" aria-label="Slide 5"></button> ';
                  }
                  if($card->card6_img != null){
                    $html .= '<button type="button" data-bs-target="#carouselCards" data-bs-slide-to="5" aria-label="Slide 6"></button> ';
                  }
                $html .= '
                </div>
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <img src="'.base_url('uploads/'.$card->card1_img).'" class="d-block w-100" alt="'.$card->card1_alt.'">
                  </div>
                  ';
                  if($card->card2_img != null){
                    $html .= '<div class="carousel-item">
                    <img src="'.base_url('uploads/'.$card->card2_img).'" class="d-block w-100" alt="'.$card->card2_alt.'">
                  </div> ';
                  }
                  if($card->card3_img != null){
                    $html .= '<div class="carousel-item">
                    <img src="'.base_url('uploads/'.$card->card3_img).'" class="d-block w-100" alt="'.$card->card3_alt.'">
                  </div> ';
                  }
                  if($card->card4_img != null){
                    $html .= '<div class="carousel-item">
                    <img src="'.base_url('uploads/'.$card->card4_img).'" class="d-block w-100" alt="'.$card->card4_alt.'">
                  </div> ';
                  }
                  if($card->card5_img != null){
                    $html .= '<div class="carousel-item">
                    <img src="'.base_url('uploads/'.$card->card5_img).'" class="d-block w-100" alt="'.$card->card5_alt.'">
                  </div> ';
                  }
                  if($card->card6_img != null){
                    $html .= '<div class="carousel-item">
                    <img src="'.base_url('uploads/'.$card->card6_img).'" class="d-block w-100" alt="'.$card->card6_alt.'">
                  </div> ';
                  }
                $html .= '
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselCards" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselCards" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
              </div>
              ';
    } elseif($item->id_cursos_licoes_tipo == 7){
      $card = $this->licoesTipo7Model->where('id_cursos_licoes', $item->id)->first();
      $html = '<div class="row">
                <div class="mb-3 col-12">'.$card->enunciado.'</div>
                <div class="col-12 col-md-6">
                  '.$card->colA1.'<br />
                  '.$card->colA2.'<br />
                  '.$card->colA3.'<br />
                  '.$card->colA4.'<br />
                  '.$card->colA5.'<br />
                </div>
                <div class="col-12 col-md-6">
                  '.$card->colB1.'<br />
                  '.$card->colB2.'<br />
                  '.$card->colB3.'<br />
                  '.$card->colB4.'<br />
                  '.$card->colB5.'<br />
                </div>
        </div>
      ';
    } elseif($item->id_cursos_licoes_tipo == 8){
      $card = $this->licoesTipo8Model->where('id_cursos_licoes', $item->id)->first();
      $resposta = ['V' => '', 'F' => ''];
      $resposta[$card->vouf] = 'checked';
      $html = '
              <p>'.$card->vouf_pergunta.'</p>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" '.$resposta['V'].'>
                <label class="form-check-label" for="flexRadioDefault2">
                  Verdadeiro
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" '.$resposta['F'].'>
                <label class="form-check-label" for="flexRadioDefault2">
                  Falso
                </label>
              </div>
              ';
    }


    return $html;
  }

  public function aDelete($id){
    $this->licoesModel->where('id', $id)->delete();
  }
  
}

