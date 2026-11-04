<?php

namespace App\Controllers;

require('../vendor/autoload.php');

use App\Models\cursanteModel;
use App\Models\manualModel;
use CodeIgniter\I18n\Time;

class Cursantes extends BaseController
{
  public function __construct() {
    //parent::__construct();
    check_menu_access(53);
    $this->cursanteModel = new cursanteModel();
    $this->manualModel = new manualModel();
    $this->manual = $this->manualModel->where('id', 53)->first()->manual;
  }

  public function index() {
    return redirect()->to(base_url('cursantes/listar'));
  }

  public function listar() {
    log_message('info', 'O usuário '.$this->session->get('user_name').' acessou a listagem de cursantes');

    $data['textos'] = $this->cursanteModel->orderBy('nome', 'asc')->findAll();
    $data['manual'] = $this->manual;

    return view('cursantes_lista', $data);
  }

  public function ver($id) {
    $txt = $this->cursanteModel
                ->select('cursante.id, cursante.nome, cursante.email')
                ->join('cursante_cursos', 'id_cursante = cursante.id')
                ->where('cursante_cursos.id_cursos', $id)
                ->orderBy('nome', 'asc')
                ->findAll();
    //echo '<pre>'; print_r($txt); die;
    $html = '<div class="row">
        <div class="col-4 mb-1 border-bottom">Nome</div>
        <div class="col-6 mb-1 border-bottom">E-mail</div>
        <div class="col-2 mb-1 border-bottom">Ações</div>
      ';
    foreach($txt as $t){
      $html .= '
        <div class="col-4 mb-1 border-bottom">' . $t->nome . '</div>
        <div class="col-6 mb-1 border-bottom">' . $t->email . '</div>
        <div class="col-2 mb-1 border-bottom"><a href="'.base_url('/Downloads/aVerRespostasCursante/'.$t->id.'/'.$id).'" title="Ver respostas"><i class="far fa-file-excel"></i></a></div>
      ';
    }

    $html .= '</div>
    ';
    return $html;
  }

  public function aInscricoes($id) {
    $txt = $this->db->query('SELECT
                                c.nome,
                                aceito_em
                              FROM
                                cursos c,
                                cursante_cursos cc
                              WHERE
                                cc.id_cursos = c.id
                                AND cc.id_cursante = "'.$id.'"')->getResult();

    $html = '<div class="row">
              <div class="col-4 mb-1 border-bottom">Curso</div>
              <div class="col-8 mb-1 border-bottom">Adicionado em</div>
            ';
    foreach($txt as $t){
      $html .= '
        <div class="col-4 mb-1 border-bottom">' . $t->nome . '</div>
        <div class="col-8 mb-1 border-bottom">' . Time::parse($t->aceito_em)->format('d/m/Y H:i:s') . '</div>
      ';
    }

    $html .= '</div>
    ';
    return $html;
  }

  public function add() {
    $data['id'] = gerarUUID();
    $data['manual'] = $this->manual;

    return  view('cursantes_add', $data);
  }

  public function edit($id) {
    $data['txt'] = $this->cursanteModel->where('id', $id)->first();
    $data['manual'] = $this->manual;

    return view('cursantes_edit', $data);
  }

  public function update() {
    log_message('info', 'O usuário '.$this->session->get('user_name').' editou o cadastro do cursante '.$this->request->getVar('nome'));

    $data = [
      'id' => $this->request->getVar('id'),
      'nome' => $this->request->getVar('nome'),
      'email' => $this->request->getVar('email'),
      'telefone' => $this->request->getVar('telefone'),
    ];
    //echo '<pre>'; var_dump($data); die;
    $save = $this->cursanteModel->save($data);

    return redirect()->to(base_url('Cursantes'));
  }
}
