<?php

namespace App\Controllers;

require('../vendor/autoload.php');

use App\Models\cursosModel;
use App\Models\unidadesModel;
use App\Models\cursanteModel;
use App\Models\cursosCursanteModel;

use App\Models\manualModel;

class Cursos extends BaseController
{
  public function __construct()
  {
    //parent::__construct();
    check_menu_access(52);
    $this->cursosModel = new cursosModel();
    $this->unidadesModel = new unidadesModel();
    $this->cursanteModel = new cursanteModel();
    $this->cursosCursanteModel = new cursosCursanteModel();
    $this->manualModel = new manualModel();
    $this->manual = $this->manualModel->where('id', 52)->first()->manual;
  }

  public function index() {
    return redirect()->to(base_url('cursos/listar'));
  }

  public function listar() {
    log_message('info', 'O usuário '.$this->session->get('user_name').' acessou a listagem de cursos');

    $data['textos'] = $this->cursosModel->orderBy('nome', 'asc')->findAll();
    $data['manual'] = $this->manual;

    return view('cursos_lista', $data);
  }

  public function add() {
    $data['manual'] = $this->manual;

    return view('cursos_add', $data);
  }

  public function edit($id) {
    $data['txt'] = $this->cursosModel->where('id', $id)->first();
    $data['unidades'] =  $this->unidadesModel->where('id_curso', $id)->orderBy('numero', 'asc')->findAll();
    $data['inscritos'] =  $this->cursanteModel
                                ->select('cursante.id, cursante.nome, cursante.email')
                                ->join('cursante_cursos', 'cursante_cursos.id_cursante = cursante.id')
                                ->where('id_cursos', $id)
                                ->orderBy('cursante.nome', 'asc')
                                ->findAll();
    $data['manual'] = $this->manual;

    return view('cursos_edit', $data);
  }

  public function update() {
    log_message('info', 'O usuário '.$this->session->get('user_name').' editou o curso '.$this->request->getVar('nome'));

    $data = [
      'id' => $this->request->getVar('id'),
      'nome' => $this->request->getVar('nome'),
      'descricao' => $this->request->getVar('descricao'),
    ];
    //echo '<pre>'; var_dump($data); die;

    if($this->request->getVar('id') == ''){
      $save = $this->cursosModel->insert($data);

      return redirect()->to(base_url('Cursos/edit/'.$save));
    } else {
      $save = $this->cursosModel->save($data);
      return redirect()->to(base_url('Cursos'));
    }
  }

    public function inscrever($id) {
    $data['manual'] = $this->manual;
    $data['id_curso'] = $id;
    $data['id'] = gerarUUID();
    $data['cursantes'] = $this->db->query('SELECT c.id, c.nome, c.email
                                            FROM cursante c
                                            WHERE NOT EXISTS (
                                                SELECT 1 
                                                FROM cursante_cursos cc 
                                                WHERE cc.id_cursante = c.id 
                                                AND cc.id_cursos = '.$id.')'
                                            )->getResult();
    //echo '<pre>'; var_dump($data['cursantes']); die;
    return view('cursos_inscrever', $data);
  }

  public function submit() {
    if($this->request->getVar('id_cursante') == 'ADD') {
      $data = [
        'id' => $this->request->getVar('id'),
        'nome' => $this->request->getVar('nome'),
        'email' => $this->request->getVar('email'),
        'telefone' => $this->request->getVar('telefone'),
      ];
      //echo '<pre>'; var_dump($data); die;
      $id_cursante = $this->cursanteModel->insert($data);
    } else {
      $id_cursante = $this->request->getVar('id_cursante');
    }

    $data = [
      'id_cursante' => $id_cursante,
      'id_cursos' => $this->request->getVar('id_curso'),
    ];
    //echo '<pre>'; var_dump($data); die;
    $save = $this->cursosCursanteModel->insert($data);
    
     return redirect()->to(base_url('Cursos/edit/'.$this->request->getVar('id_curso').'?aba=inscritos'));
  }

}
