<?php

namespace App\Controllers;

require('../vendor/autoload.php');

use App\Models\textosModel;
use App\Models\manualModel;

class textos extends BaseController
{
  public function __construct()
  {
    //parent::__construct();
    $this->textosModel = new textosModel();
    $this->manualModel = new manualModel();
    $this->manual = $this->manualModel->where('id', 3)->first()->manual;
  }

  public function index()
  {
    return redirect()->to(base_url('textos/listar'));
  }

  public function listar()
  {
    log_message('info', 'O usuário '.$this->session->get('user_name').' acessou a listagem de textos');

    $data['textos'] = $this->textosModel->orderBy('nome', 'asc')->findAll();
    $data['manual'] = $this->manual;

    echo view('header');
    echo view('menu');
    echo view('texto_lista', $data);
    echo view('footer');
  }

  public function aGetTexto($id)
  {
    $data = $this->textosModel->where('id', $id)->first();

    echo json_encode($data);
  }

  public function ver($id)
  {
    $txt = $this->textosModel->where('id', $id)->first();
    log_message('info', 'O usuário '.$this->session->get('user_name').' avisualizou o texto '.$txt->assunto);

    $html = '
      <div class="mb3"><strong>' . $txt->assunto . '</strong></div>
      <div class="mb3">' . $txt->conteudo . '</div>
    ';
    return $html;
  }

  public function edit($id)
  {
    $data['txt'] = $this->textosModel->where('id', $id)->first();
    $data['manual'] = $this->manual;

    echo view('header');
    echo view('menu');
    echo view('texto_edit', $data);
    echo view('footer');
  }

  public function update()
  {
    log_message('info', 'O usuário '.$this->session->get('user_name').' editou o texto '.$this->request->getVar('nome'));

    $data = [
      'nome' => $this->request->getVar('nome'),
      'assunto' => $this->request->getVar('assunto'),
      'conteudo' => $this->request->getVar('conteudo'),
    ];
    //echo '<pre>'; var_dump($data); die;
    $save = $this->textosModel->update($this->request->getVar('id'), $data);

    return redirect()->to(base_url('Textos'));
  }
}
