<?php

namespace App\Controllers;
use App\Libraries\NewsLibrary;
use App\Libraries\MailcontrolLibrary;
use App\Models\leadsModel;
use App\Models\textosModel;

class Home extends BaseController
{

    public function __construct()
    {
        //parent::__construct();
        $this->leadsModel = new leadsModel();
        $this->textosModel = new textosModel();
    }


    public function index(): string
    {
        $data = [
        ];

        return view('home', $data);
    }

    public function aCadastrarNews()
    {
        //registra lead
        $data = [
        'email' => $this->request->getVar('email'),
        ];
        $save = $this->leadsModel->save($data);

        

        //envia e-mail para validação
        $lead = $this->leadsModel->where('email', $this->request->getVar('email'))->first();

		$mailControl = new MailcontrolLibrary();
        $txt = $this->textosModel->where('id', 1)->first();
        $arr_alt = array(
            '[LINK]' => base_url('Home/confirma/'.$lead->cod_validacao),
        );
        $conteudo = str_replace(array_keys($arr_alt), $arr_alt, $txt->conteudo);
		$email = [
			'html' => $conteudo,
			'subject' => $txt->assunto,
			'to' => array(
				array(
					'email' => $lead->email,
				),
			),
			'from' => array(
				'email' => $this->session->get('SENDER_MAIL'),
				'name' => $this->session->get('SENDER_NAME')
		),
		];
		$mailControl->sendEmail($email);
    }

    public function confirma($cod_validacao){
        $lead = $this->leadsModel->where('cod_validacao', $cod_validacao)->first();

        if($lead){
            $data = [
                'cod_validacao' => '',
                'validado_em' => date('Y-m-d H:i:s'),
            ];
            $save = $this->leadsModel->update($lead->email, $data);

            $txt = $this->textosModel->where('id', 2)->first();
        } else {
            $txt = $this->textosModel->where('id', 3)->first();
        }
        
        $data['txt'] = $txt;
        $data['session'] = $this->session->get();

        return view('texto', $data);
    }




    public function politica_privacidade()
    {
        $txt = $this->textosModel->where('id', 2)->first();
        $arr_alt = array(
            '[link_pol_cookies]' => base_url('Home/politica_de_cookies'),
        );
        $txt->conteudo = str_replace(array_keys($arr_alt), $arr_alt, $txt->conteudo);
        $data['txt'] = $txt;
        $data['session'] = $this->session->get();
        return view('texto', $data);
    }

    public function politica_de_cookies()
    {
        $txt = $this->textosModel->where('id', 2)->first();
        $arr_alt = array(
            '[link_pol_privacidade]' => base_url('Home/politica_privacidade'),
        );
        $txt->conteudo = str_replace(array_keys($arr_alt), $arr_alt, $txt->conteudo);
        $data['txt'] = $txt;
        $data['session'] = $this->session->get();
        return view('site/texto', $data);
    }

    public function termos_de_uso()
    {
        $txt = $this->textosModel->where('id', 3)->first();
        $arr_alt = array(
            '[link_pol_cookies]' => base_url('Home/politica_de_cookies'),
            '[link_pol_privacidade]' => base_url('Home/politica_privacidade'),
        );
        $txt->conteudo = str_replace(array_keys($arr_alt), $arr_alt, $txt->conteudo);
        $data['txt'] = $txt;
        $data['session'] = $this->session->get();
        return view('site/texto', $data);
    }

}
