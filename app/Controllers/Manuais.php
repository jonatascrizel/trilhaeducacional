<?php

namespace App\Controllers;

require('../vendor/autoload.php');

use App\Models\textosModel;
use App\Models\manualModel;

class manuais extends BaseController
{
  public function __construct()
  {
    //parent::__construct();
    $this->manualModel = new manualModel();
    $this->manual = $this->manualModel->where('id', 4)->first()->manual;
  }

  public function index()
  {
    return redirect()->to(base_url('manuais/listar'));
  }

  public function listar()
  {
    log_message('info', 'O usuário '.$this->session->get('user_name').' acessou a listagem de manuais');

    $data['textos'] = $this->manualModel->orderBy('nome', 'asc')->findAll();
    $data['manual'] = $this->manual;

    echo view('header');
    echo view('menu');
    echo view('manuais_lista', $data);
    echo view('footer');
  }

  public function ver($id)
  {
    $txt = $this->manualModel->where('id', $id)->first();

    log_message('info', 'O usuário '.$this->session->get('user_name').' visualizou o manual '.$txt->nome);

    $html = '
      <div class="mb3">' . $txt->manual . '</div>
    ';
    return $html;
  }

  public function edit($id)
  {
    $data['txt'] = $this->manualModel->where('id', $id)->first();
    $data['manual'] = $this->manual;

    echo view('header');
    echo view('menu');
    echo view('manuais_edit', $data);
    echo view('footer');
  }

  public function update()
  {
    log_message('info', 'O usuário '.$this->session->get('user_name').' editou o manual '.$this->request->getVar('nome'));
    
    $data = [
      'manual' => $this->request->getVar('manual'),
    ];
    //echo '<pre>'; var_dump($data); die;
    $save = $this->manualModel->update($this->request->getVar('id'), $data);

    return redirect()->to(base_url('manuais'));
  }
}
