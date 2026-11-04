<?php

namespace App\Controllers;

use App\Models\cursanteModel;

require('../vendor/autoload.php');


class perfil extends BaseController
{
  protected $cursanteModel;
  public function __construct() {
    //parent::__construct();
    $this->cursanteModel = new cursanteModel();
  }

  public function index(){
      $data['cursante'] = $this->cursanteModel->where('id', $this->session->get('cursante_id'))->first();

      return view('perfil', $data);
  }

  public function update(){
    log_message('info', 'O cursante '.$this->session->get('cursante_nome').' editou seu perfil');
    
    $data = [
      'nome' => $this->request->getVar('nome'),
      'apelido' => $this->request->getVar('apelido'),
      //'email' => $this->request->getVar('email'),
      'telefone' => $this->request->getVar('telefone'),
    ];
    //echo '<pre>'; var_dump($data); die;
    $save = $this->cursanteModel->update($this->session->get('cursante_id'), $data);

    return redirect()->to(base_url('perfil'));
  }

  public function senha(){
      $data['cursante'] = $this->cursanteModel->where('id', $this->session->get('cursante_id'))->first();

      return view('perfil-senha', $data);
  }
    public function updatepws(){
    log_message('info', 'O cursante '.$this->session->get('cursante_nome').' alterou sua senha');
    
    $data = [
      'senha' => password_hash($this->request->getVar('pws_nova'), PASSWORD_DEFAULT),
      'troca_senha' => 0,
    ];
    //echo '<pre>'; var_dump($data); die;
    $save = $this->cursanteModel->update($this->session->get('cursante_id'), $data);

    return redirect()->to(base_url('perfil/senha'));
  }

  public function preferencias(){
      $data['cursante'] = $this->cursanteModel->where('id', $this->session->get('cursante_id'))->first();

      return view('perfil-preferencias', $data);
  }

  public function updatepref(){
    log_message('info', 'O cursante '.$this->session->get('cursante_nome').' editou suas preferência dos perfil');
    
    $data = [
      'notfica_progressao_eml' => $this->request->getVar('notfica_progressao_eml'),
      'notfica_progressao_wpp' => $this->request->getVar('notfica_progressao_wpp'),
      'perfil_publico' => $this->request->getVar('perfil_publico'),
    ];
    //echo '<pre>'; var_dump($data); die;
    $save = $this->cursanteModel->update($this->session->get('cursante_id'), $data);

    return redirect()->to(base_url('perfil/preferencias'));
  }

}
