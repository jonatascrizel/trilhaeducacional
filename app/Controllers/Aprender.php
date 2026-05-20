<?php

namespace App\Controllers;

require('../vendor/autoload.php');

use App\Models\cursosModel;
use App\Models\unidadesModel;
use App\Models\licoesModel;
use App\Models\cursosCursanteModel;
use App\Models\cursanteLicaoModel;
use App\Models\licoesTipo1Model;
use App\Models\licoesTipo2Model;
use App\Models\licoesTipo3Model;
use App\Models\licoesTipo4Model;
use App\Models\licoesTipo5Model;
use App\Models\licoesTipo6Model;
use App\Models\licoesTipo7Model;
use App\Models\licoesTipo8Model;


class aprender extends BaseController
{
    public function __construct() {
      //parent::__construct();
      if (!session()->has('acessado')) {
        return redirect()->to(base_url('/entrar'));
      }

      $this->cursosModel = new cursosModel();
      $this->unidadesModel = new unidadesModel();
      $this->licoesModel = new licoesModel();
      $this->cursosCursanteModel = new cursosCursanteModel();
      $this->cursanteLicaoModel = new cursanteLicaoModel();
      $this->licoesTipo1Model = new licoesTipo1Model();
      $this->licoesTipo2Model = new licoesTipo2Model();
      $this->licoesTipo3Model = new licoesTipo3Model();
      $this->licoesTipo4Model = new licoesTipo4Model();
      $this->licoesTipo5Model = new licoesTipo5Model();
      $this->licoesTipo6Model = new licoesTipo6Model();
      $this->licoesTipo7Model = new licoesTipo7Model();
      $this->licoesTipo8Model = new licoesTipo8Model();
   }

    public function index(){
      $txt = $this->db->query('SELECT
                                c.*,
                                cc.id as id_cursante_curso
                              FROM
                                cursos c,
                                cursante_cursos cc
                              WHERE
                                cc.id_cursos = c.id
                                AND cc.id_cursante = "'.$this->session->get('cursante_id').'"')
                        ->getResult();
      $data['cursos'] = $txt;
      return view('cursos', $data);
    }

    public function ir_trilha($id_curso, $id_cursante_curso){
        $this->session->set(['id_curso' => $id_curso, 'id_cursante_curso' => $id_cursante_curso]);
        return redirect()->to(base_url('/aprender/trilha'));
    }

    public function trilha(){
      //se não tem curso definido direciona para a tela de escolha
      if (!session()->has('id_curso')) {
        return redirect()->to(base_url('/aprender'));
      }
      //salva a data/hora do acesso
      $dt = [
        'id' => $this->session->get('id_cursante_curso'),
        'ultimo_acesso' => date('Y-m-d H:i:s')
      ];
      $save = $this->cursosCursanteModel->save($dt);

      $data['unidades'] = $this->unidadesModel->where('id_curso', $this->session->get('id_curso'))->where('st', 1)->orderby('numero')->findAll();
      $query = $this->db->query('SELECT
                                    cl.id,
                                    cl.id_cursos_licoes_tipo,
                                    cl.id_cursos_unidades,
                                    clt.icone,
                                    clt.tipo,
                                    (SELECT id FROM cursante_licoes crl WHERE crl.id_licao = cl.id AND crl.id_cursante = "'.$this->session->get('cursante_id').'") AS respondido
                                  FROM
                                    cursos_licoes cl,
                                    cursos_licoes_tipos clt,
                                    cursos_unidades cu
                                  WHERE
                                    cl.id_cursos_licoes_tipo = clt.id
                                    AND cl.id_cursos_unidades = cu.id
                                    AND cu.id_curso = '.$this->session->get('id_curso').'
                                    AND cl.st = 1
                                  ORDER BY
                                    cu.numero ASC,
                                    cl.ordem ASC')
                        ->getResult();
      foreach($query as $q){
        $data['licoes'][$q->id_cursos_unidades][] = $q;
      }
      
      
      return view('aprender', $data);
    }

    public function unidades(){
        $data = [];
        return view('unidades', $data);
    }

    public function aCard($id){
      $item = $this->licoesModel->where('id', $id)->first();

      $respondida = $this->cursanteLicaoModel->where('id_cursante', $this->session->get('cursante_id'))->where('id_licao', $id)->first();


      if($item->id_cursos_licoes_tipo == 1){
        $card = $this->licoesTipo1Model->where('id_cursos_licoes', $item->id)->first();
        if(is_object($respondida)){
          $resp = $respondida->resposta;
          $dis = 1;
        } else {
          $resp = 0;
          $dis = 0;
        }

        $html = '<form id="formCard" method="post" action="" class="mb-5 mt-3">
                  <input type="hidden" id="id_licao" name="id_licao" value="'. $id.'" />
                  <p>'.$card->pergunta.'</p>

                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="resposta" id="resposta1" value="1" onclick="libera_enviar_resposta()" '.($resp == 1 ? 'checked' : '').' '.($dis == 1 ? 'disabled' : '').' />
                    <label class="form-check-label" for="resposta1">
                      '.$card->resposta1.'
                    </label>
                  </div>

                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="resposta" id="resposta2"  value="2" onclick="libera_enviar_resposta()" '.($resp == 2 ? 'checked' : '').' '.($dis == 1 ? 'disabled' : '').' />
                    <label class="form-check-label" for="resposta2">
                      '.$card->resposta2.'
                    </label>
                  </div>

                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="resposta" id="resposta3"  value="3" onclick="libera_enviar_resposta()" '.($resp == 3 ? 'checked' : '').' '.($dis == 1 ? 'disabled' : '').' />
                    <label class="form-check-label" for="resposta3">
                      '.$card->resposta3.'
                    </label>
                  </div>

                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="resposta" id="resposta4"  value="4" onclick="libera_enviar_resposta()" '.($resp == 4 ? 'checked' : '').' '.($dis == 1 ? 'disabled' : '').' />
                    <label class="form-check-label" for="resposta4">
                      '.$card->resposta4.'
                    </label>
                  </div>

                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="resposta" id="resposta5"  value="5" onclick="libera_enviar_resposta()" '.($resp == 51 ? 'checked' : '').' '.($dis == 1 ? 'disabled' : '').' />
                    <label class="form-check-label" for="resposta5">
                      '.$card->resposta5.'
                    </label>
                  </div>

        ';
        if(!is_object($respondida)){
          $html .= '
                  <div id="retorno"></div>

                  <button class="btn btn-primary mt-3" type="button" id="registra_resposta" onclick="verificar_resposta()" disabled>Verificar resposta</button>
                  <button class="btn btn-primary mt-3 d-none" type="button" id="btn_fechar" data-bs-dismiss="modal" aria-label="Close">Fechar</button>
                </form>
          ';  
        } else {
          $html .= '
                  <button class="btn btn-primary mt-3" type="button" id="btn_fechar" data-bs-dismiss="modal" aria-label="Close">Fechar</button>
                </form>
          ';
        }

      } elseif($item->id_cursos_licoes_tipo == 2){
        $card = $this->licoesTipo2Model->where('id_cursos_licoes', $item->id)->first();
        $html = $card->leitura.'<div class="w-100"></div>';
        if(is_object($respondida)){
          $html .= '
          <button class="btn btn-primary mt-3" type="button" id="btn_fechar" data-bs-dismiss="modal" aria-label="Close">Fechar</button>
          ';        
        } else {
          $html .= '
                <button class="btn btn-primary mt-3" type="button" onclick="marcar_concluido(\''.$id.'\')">Marcar como concluída</button>
          ';        
        }
      } elseif($item->id_cursos_licoes_tipo == 3){
        $card = $this->licoesTipo3Model->where('id_cursos_licoes', $item->id)->first();
        $html = '<div class="row">
                  <div class="col-12 col-md-6">
                    <img src="'.base_url('uploads/'.$card->recomendacao_img).'" class="w-100" />
                  </div>
                  <div class="col-12 col-md-6">
                    '.$card->recomendacao_txt.'
                  </div>
                </div>
                ';
        if(is_object($respondida)){
          $html .= '
          <button class="btn btn-primary mt-3" type="button" id="btn_fechar" data-bs-dismiss="modal" aria-label="Close">Fechar</button>
          ';        
        } else {
          $html .= '
                <button class="btn btn-primary mt-3" type="button" onclick="marcar_concluido(\''.$id.'\')">Marcar como concluída</button>
          ';        
        }
      } elseif($item->id_cursos_licoes_tipo == 4){
        $card = $this->licoesTipo4Model->where('id_cursos_licoes', $item->id)->first();
        $html = $card->video.'<div class="w-100"></div>';
        if(is_object($respondida)){
          $html .= '
          <button class="btn btn-primary mt-3" type="button" id="btn_fechar" data-bs-dismiss="modal" aria-label="Close">Fechar</button>
          ';        
        } else {
          $html .= '
                <button class="btn btn-primary mt-3" type="button" onclick="marcar_concluido(\''.$id.'\')">Marcar como concluída</button>
          ';        
        }
      } elseif($item->id_cursos_licoes_tipo == 5){
        $card = $this->licoesTipo5Model->where('id_cursos_licoes', $item->id)->first();
        if(is_object($respondida)){
          $resp = $respondida->resposta;
          $dis = 1;
        } else {
          $resp = '';
          $dis = 0;
        }

        $html = '<form id="formDescritiva" method="post" action="" class="mb-5 mt-3">
                  <input type="hidden" id="id_licao" name="id_licao" value="'. $id.'" />
                  <p>'.$card->pergunta_desc.'</p>
                  <textarea class="form-control" id="resposta" name="resposta" '.($dis == 1 ? 'disabled' : '').'>'.$resp.'</textarea>

                ';
        if(!is_object($respondida)){
          $html .= '
                  <div id="retorno"></div>

                  <button class="btn btn-primary mt-3" type="button" id="registra_resposta" onclick="responder_descritiva()">Verificar resposta</button>
                  <button class="btn btn-primary mt-3 d-none" type="button" id="btn_fechar" data-bs-dismiss="modal" aria-label="Close">Fechar</button>
                </form>
          ';  
        } else {
          $html .= '
                  <button class="btn btn-primary mt-3" type="button" id="btn_fechar" data-bs-dismiss="modal" aria-label="Close">Fechar</button>
                </form>
          ';
        }
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
        if(is_object($respondida)){
          $html .= '
          <button class="btn btn-primary mt-3" type="button" id="btn_fechar" data-bs-dismiss="modal" aria-label="Close">Fechar</button>
          ';        
        } else {
          $html .= '
                <button class="btn btn-primary mt-3" type="button" onclick="marcar_concluido(\''.$id.'\')">Marcar como concluída</button>
          ';        
        }
      } elseif($item->id_cursos_licoes_tipo == 7){
        $card = $this->licoesTipo7Model->where('id_cursos_licoes', $item->id)->first();
        $html = '<form id="formCard" method="post" action="" class="mb-5 mt-3">
                  <input type="hidden" id="id_licao" name="id_licao" value="'. $id.'" />
                  <p>'.$card->enunciado.'</p>

                  <div class="row ordenavel">
                    <div class="col-12 col-md-6">
                      <ul>
                        <li>'.$card->colA1.'</li>
                        <li>'.$card->colA2.'</li>
                        <li>'.$card->colA3.'</li>
                        <li>'.$card->colA4.'</li>
                        <li>'.$card->colA5.'</li>
                      </ul>
                    </div>
                    <div class="col-12 col-md-6">
                      <ul id="card_ordenar">
                        <li id="1">'.$card->colB1.'</li>
                        <li id="2">'.$card->colB2.'</li>
                        <li id="3">'.$card->colB3.'</li>
                        <li id="4">'.$card->colB4.'</li>
                        <li id="5">'.$card->colB5.'</li>
                      </ul>
                    </div>
                  </div>
        ';

        if(!is_object($respondida)){
          $html .= '
                  <div id="retorno"></div>

                  <button class="btn btn-primary mt-3" type="button" id="registra_resposta" onclick="verificar_ordem()">Verificar resposta</button>
                  <button class="btn btn-primary mt-3 d-none" type="button" id="btn_fechar" data-bs-dismiss="modal" aria-label="Close">Fechar</button>
                </form>
          ';  
        } else {
          $html .= '
                  <button class="btn btn-primary mt-3" type="button" id="btn_fechar" data-bs-dismiss="modal" aria-label="Close">Fechar</button>
                </form>
          ';
        }
      } elseif($item->id_cursos_licoes_tipo == 8){
        $card = $this->licoesTipo8Model->where('id_cursos_licoes', $item->id)->first();
        $resposta = ['V' => '', 'F' => ''];
        if(is_object($respondida)){
          $resposta[$respondida->vouf] = 'checked';
        }
        $html = '<form id="formCard" method="post" action="" class="mb-5 mt-3">
                  <input type="hidden" id="id_licao" name="id_licao" value="'. $id.'" />
                <p>'.$card->vouf_pergunta.'</p>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="resposta" id="vouf_v" value="V" onclick="libera_enviar_resposta()" required />
                  <label class="form-check-label" for="vouf_v">
                    Verdadeiro
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="resposta" id="vouf_f" value="F" onclick="libera_enviar_resposta()" />
                  <label class="form-check-label" for="vouf_f">
                    Falso
                  </label>
                </div>
                ';
        if(!is_object($respondida)){
          $html .= '
                  <div id="retorno"></div>

                  <button class="btn btn-primary mt-3" type="button" id="registra_resposta" onclick="verificar_resposta()" disabled>Verificar resposta</button>
                  <button class="btn btn-primary mt-3 d-none" type="button" id="btn_fechar" data-bs-dismiss="modal" aria-label="Close">Fechar</button>
                </form>
          ';  
        } else {
          $html .= '
                  <button class="btn btn-primary mt-3" type="button" id="btn_fechar" data-bs-dismiss="modal" aria-label="Close">Fechar</button>
                </form>
          ';
        }
      }

      return $html;
    }

    public function verificar_resposta(){
      //registra a resposta
      $data = [
        'id_cursante' => $this->session->get('cursante_id'),
        'id_licao' => $this->request->getVar('id_licao'),
        'feita_em' => date('Y-m-d H:i:s'),
        //'resposta' => implode(',',$this->request->getVar('resposta')),
      ];
      if(is_array($this->request->getVar('resposta'))){
        $data['resposta'] = implode(',',$this->request->getVar('resposta'));
      } else {
        $data['resposta'] = $this->request->getVar('resposta');
      }
      $save = $this->cursanteLicaoModel->save($data);      

      //verifica se era a correta (se for questionário) e retorna
      $questao = $this->licoesModel->where('id', $this->request->getVar('id_licao'))->first();

      if($questao->id_cursos_licoes_tipo == 1){
        $card = $this->licoesTipo1Model->where('id_cursos_licoes', $this->request->getVar('id_licao'))->first();
        if($this->request->getVar('resposta') == $card->resposta_certa){
          $data = [
            'resposta' => 1,
          ];
        } else {
          $corr = $card->resposta_certa;
          $data = [
            'resposta' => 2,
            'msg' => 'Oooops! A resposta correta é: <b>'.$card->{'resposta'.$corr}.'</b>',
          ];
        }
        return json_encode($data);
      } elseif($questao->id_cursos_licoes_tipo == 5){
        return '<div class="alert alert-info mt-5" role="alert">
                  Registramos sua resposta!
                </div>';
      } elseif($questao->id_cursos_licoes_tipo == 7){
        $resposta = array_diff_assoc([1,2,3,4,5], $this->request->getVar('resposta'));
        if(empty($resposta)){
          $data = [
            'resposta' => 1,
          ];
        } else {
          $card = $this->licoesTipo7Model->where('id_cursos_licoes', $this->request->getVar('id_licao'))->first();
          $data = [
            'resposta' => 2,
            'msg' => 'Oooops! A sequência correta é: <b>'.$card->colB1.' / '.$card->colB2.' / '.$card->colB3.' / '.$card->colB4.' / '.$card->colB5.'</b>',
          ];
        }
        return json_encode($data);
      }elseif($questao->id_cursos_licoes_tipo == 8){
        $card = $this->licoesTipo8Model->where('id_cursos_licoes', $this->request->getVar('id_licao'))->first();
        if($this->request->getVar('resposta') == $card->vouf){
          $data = [
            'resposta' => 1,
          ];
        } else {
          $data = [
            'resposta' => 2,
            'msg' => 'Oooops! A resposta correta é: <b>'.$card->vouf.'</b>',
          ];
        }
        return json_encode($data);
      }
    }
}
