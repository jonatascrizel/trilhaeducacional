<?php

namespace App\Controllers;

require('../vendor/autoload.php');

use App\Models\UserModel;
use App\Models\manualModel;
use App\Models\textosModel;
use App\Libraries\MailcontrolLibrary;

class usuarios extends BaseController
{

    public function __construct()
    {
        //parent::__construct();
        $this->UserModel = new UserModel();
        $this->manualModel = new manualModel();
        $this->textosModel = new textosModel();
        $this->manual = $this->manualModel->where('id', 1)->first()->manual;
    }


    public function index()
    {
        return redirect()->to(base_url('usuarios/listar'));
    }

    public function listar()
    {
        log_message('info', 'O usuário '.$this->session->get('user_name').' acessou a listagem de usuários');

        $data['users'] = $this->UserModel->listaUsuarios();
        $data['manual'] = $this->manual;

        echo view('header');
        echo view('menu');
        echo view('usuarios_lista', $data);
        echo view('footer');
    }

    public function add()
    {
        $data['manual'] = $this->manual;

        echo view('header');
        echo view('menu');
        echo view('usuarios_add', $data);
        echo view('footer');
    }

    public function store() {
        log_message('info', 'O usuário '.$this->session->get('user_name').' adicionou um usuário chamado '.$this->request->getVar('user_name'));

        $pws_provisorio = gerarSenha(8,true,true,true);

        if($this->request->getVar('ativo') == 1){
            $ativo = 1;
        } else {
            $ativo = 2;
        }
        $data = [
            'user_name' => ($this->request->getVar('user_name')),
            'user_email'  => strtolower($this->request->getVar('user_email')),
            'user_password'  => password_hash($pws_provisorio, PASSWORD_DEFAULT),
            'telefone'  => $this->request->getVar('telefone'),
            'ativo'  => $ativo,
            'troca_senha'  => 1,
        ];
        $save = $this->UserModel->insert($data);

        //envia e-mail com a senha provisória
        $texto = $this->textosModel->where('id', 1)->first();
        $arr_trocar = [
            '[NOME]' => $this->request->getVar('user_name'),
            '[EMAIL]' => $this->request->getVar('user_email'),
            '[SENHA]' => $pws_provisorio,
            '[SITE]' => base_url(),
          ];        
        $html = str_replace(array_keys($arr_trocar), $arr_trocar, $texto->conteudo);

        $mailControl = new MailcontrolLibrary();
		$email = [
			'html' => $html,
			'subject' => $texto->assunto,
			'to' => array(
				array(
					'email' => $this->request->getVar('user_email'),
				),
			),
			'from' => array(
                'email' => $this->session->get('SENDER_MAIL'),
                'name' => $this->session->get('SENDER_NAME')
        ),
		];
		$mailControl->sendEmail($email);


        return redirect()->to(base_url('usuarios'));
    }

    public function edit($id)
    {
        $data['users'] = $this->UserModel->where('id', $id)->first();
        $data['manual'] = $this->manual;

        echo view('header');
        echo view('menu');
        echo view('usuarios_edit', $data);
        echo view('footer');
    }

    public function update()
    {
        log_message('info', 'O usuário '.$this->session->get('user_name').' atualizou o usuário chamado '.$this->request->getVar('user_name'));

        if($this->request->getVar('ativo') == 1){
            $ativo = 1;
        } else {
            $ativo = 2;
        }
        $data = [
            'user_name' => ($this->request->getVar('user_name')),
            'user_email'  => strtolower($this->request->getVar('user_email')),
            'telefone'  => $this->request->getVar('telefone'),
            'ativo'  => $ativo,
        ];
        //echo '<pre>'; var_dump($data); die;
        $save = $this->UserModel->update($this->request->getVar('id'), $data);


        return redirect()->to(base_url('usuarios'));
    }

    public function aGeraMenu()
    {
        //$this->session->get('user_id')
        $data['Relatórios'] = [
            'nome' => 'Relatórios',
            'icone' => 'fas fa-file-contract',
            'title' => 'Relatórios',
            'new_window' => 0,
            'controller' => '',
            'sub' => [],
        ];

        $menus = $this->UserModel->geraMenu($this->session->get('user_id'));
        foreach ($menus as $v) {
            $data[$v->nome] = [
                                'nome' => $v->nome,
                                'icone' => $v->icone,
                                'title' => $v->title,
                                'new_window' => $v->new_window,
                                'controller' => base_url('/' . $v->controller),
                                'sub' => '',
                            ];
        }
        
        ksort($data);
        $rtn = '';
        
        foreach($data as $k => $v){
            if($k == 'Relatórios'){
                if(count($v['sub']) == 0){
                    continue;
                }
                $rtn .= '<li class="nav-item  bg-light rounded">
                            <a class="nav-link pointer" data-bs-toggle="collapse" data-bs-target="#getting-started-collapse" aria-expanded="true" aria-current="true" data-bs-placement="right" title="'.$v['title'].'"><i class="'.$v['icone'].' me-1"></i> <span>'.$k.' <i class="fas fa-caret-down"></i></span></a>
                            <div class="collapse" id="getting-started-collapse">
                               <ul class="list-unstyled pb-1 ps-4"> ';

                foreach($v['sub'] as $k2 => $v2){
                    $rtn .= '<li class="mb-1"><a href="'.$v2['controller'].'" title="'.$v2['title'].'" class="nav-link sub" aria-current="page" data-bs-placement="right"> <span>'.$v2['nome'].'</span></a></li> ';
                }

                $rtn .= '       </ul>
                            </div>
                        </li>';

            } else {
                $rtn .= '<li class="nav-item">
                            <a class="nav-link" href="'.$v['controller'].'" title="'.$v['title'].'" data-bs-placement="right"';
                if($v['new_window'] == 1){
                    $rtn .= ' target="_blank"';
                }
                $rtn .= '><i class="'.$v['icone'].'"></i> <span>'.$k;
                if($v['new_window'] == 1){
                    $rtn .= ' <i class="fas fa-external-link-alt"></i>';
                }
                $rtn .= '</span></a>
                        </li>';
            }
        
        };

        return $rtn;        
    }

    public function aCheckEmail(){
        $menus = $this->UserModel->select('count(id) as total')->where('user_email', $this->request->getVar('email'))->first();

        echo $menus->total;
    }

}
