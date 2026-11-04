<?php

namespace App\Controllers;

require('../vendor/autoload.php');

use App\Models\unidadesModel;
use App\Models\licoesModel;
use App\Models\manualModel;

class Unidades extends BaseController
{
  public function __construct() {
    //parent::__construct();
    check_menu_access(52);
    $this->unidadesModel = new unidadesModel();
    $this->licoesModel = new licoesModel();
    $this->manualModel = new manualModel();
    $this->manual = $this->manualModel->where('id', 52)->first()->manual;
  }

  public function index() {
    return redirect()->to(base_url('cursos'));
  }

  public function ver($id) {
    $txt = $this->unidadesModel->where('id_curso', $id)->orderBy('numero', 'asc')->findAll();

    $html = '<div class="row">';
    foreach($txt as $t){
      $html .= '
        <div class="col-4 mb-1 border-bottom">Unidade ' . $t->numero . '</div>
        <div class="col-8 mb-1 border-bottom">' . $t->unidade . '</div>
      ';
    }

    $html .= '</div>
    ';
    return $html;
  }

  public function add($id) {
    $data['id'] = $id;
    $data['manual'] = $this->manual;

    return view('unidades_add', $data);
  }

  public function edit($id) {
    $data['id'] = $id;
    $unidade = $this->unidadesModel->where('id', $id)->first();
    $data['licoes'] = $this->licoesModel
                              ->select('cursos_licoes.id, cursos_licoes.titulo, cursos_licoes.ordem, cursos_licoes_tipos.tipo')
                              ->join('cursos_licoes_tipos', 'id_cursos_licoes_tipo = cursos_licoes_tipos.id')
                              ->where('id_cursos_unidades', $id)
                              ->orderBy('cursos_licoes.ordem', 'ASC')
                              ->findAll();
    $data['manual'] = $this->manual;
    $breadcumb = $this->db->query('SELECT
                                      c.id AS id_curso,
                                      c.nome AS curso
                                    FROM
                                      cursos c
                                    WHERE
                                      c.id = '.$unidade->id_curso)->getResult();
    
    //echo '<pre>'; var_dump($breadcumb[0]); die;

    $data['txt'] = $unidade;
    $data['breadcumb'] = $breadcumb[0];

    return view('unidades_edit', $data);
  }

  public function update() {
    log_message('info', 'O usuário '.$this->session->get('user_name').' editou a unidade didática '.$this->request->getVar('unidade'));

    $data = [
      'id' => $this->request->getVar('id'),
      'id_curso' => $this->request->getVar('id_curso'),
      'unidade' => $this->request->getVar('unidade'),
      'numero' => $this->request->getVar('numero'),
      'descricao' => $this->request->getVar('descricao'),
    ];
    //echo '<pre>'; var_dump($data); die;

    if($this->request->getVar('id') == ''){
      $save = $this->unidadesModel->insert($data);
      return redirect()->to(base_url('Unidades/edit/'.$save));
    } else {
      $save = $this->unidadesModel->save($data);
      return redirect()->to(base_url('Cursos/edit/'.$this->request->getVar('id_curso')));
    }
  }
}
