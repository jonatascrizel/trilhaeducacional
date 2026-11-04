<?php

namespace App\Controllers;

require('../vendor/autoload.php');

use App\Models\configModel;
use App\Models\manualModel;

class configuracoes extends BaseController
{
  public $ConfigModel;

  public function __construct()
  {
    //parent::__construct();
    check_menu_access(2);
    $this->ConfigModel = new configModel();
    $this->manualModel = new manualModel();
    $this->manual = $this->manualModel->where('id', 2)->first()->manual;
  }

  public function index()
  {
    return redirect()->to(base_url('configuracoes/listar'));
  }

  public function listar()
  {
    log_message('info', 'O usuário '.$this->session->get('user_name').' acessou a listagem de configurações');

    $data['cfgItens'] = $this->ConfigModel->orderBy('configName', 'asc')->findAll();
    $data['manual'] = $this->manual;

    return view('configuracoes_lista', $data);
  }

  public function edit($id)
  {
    $data['cfgItem'] = $this->ConfigModel->where('id', $id)->first();
    $data['manual'] = $this->manual;

    return view('configuracoes_edit', $data);
  }

  public function update()
  {
    log_message('info', 'O usuário '.$this->session->get('user_name').' editou a configuração '.$this->request->getVar('configName'));

    $data = [
      'configValue' => $this->request->getVar('configValue'),
    ];
    //echo '<pre>'; var_dump($data); die;
    $save = $this->ConfigModel->update($this->request->getVar('id'), $data);

    return redirect()->to(base_url('configuracoes'));
  }
}
