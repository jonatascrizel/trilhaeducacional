<?php

namespace App\Controllers;

require('../vendor/autoload.php');


class dashboard extends BaseController
{
    public function __construct()
    {
        //parent::__construct();
    }

    public function index(){
        $data = [];
        echo view('header');
        echo view('menu');
        echo view('dashboard', $data);
        echo view('footer');
    }

    public function trocaSenha()
    {
        $data = [];
        echo view('header');
        echo view('menu');
        echo view('troca_senha', $data);
        echo view('footer');
    }

    public function trocaSenhaDo()
    {
        if (!is_numeric($this->session->get('user_id'))) {
            return redirect()->to(base_url('/logout'));
        }

        log_message('info', 'O usuário '.$this->session->get('user_name').' alterou sua senha');

        $data = [
            'user_password' => password_hash($this->request->getVar('pws_nova'), PASSWORD_DEFAULT),
            'troca_senha' => 0,
        ];
        $save = $this->UserModel->update($this->session->get('user_id'), $data);

        return redirect()->to(base_url('/dashboard'));
    }


}
