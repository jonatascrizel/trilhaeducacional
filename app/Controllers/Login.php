<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Libraries\CaptchaLibrary;
use App\Libraries\MailcontrolLibrary;


class Login extends BaseController
{
    public function index(){
        //die(password_hash('metallica69', PASSWORD_DEFAULT));
        helper(['form', 'uteis']);
        $data['reCaptchaKey'] = $this->session->get('reCaptchaKey');
        echo view('login', $data);
    }

    public function auth()
    {
        $status = verificarEnterprise($this->request->getVar('g-recaptcha-response'), 
                                      $this->session->get('reCaptchaKey'), 
                                      $this->session->get('gApiKey'),
                                      $this->session->get('gProjectID')
                                      );

        if (isset($status) && $status === true) {
            $model = new UserModel();

            $email = $this->request->getVar('InputForEmail');
            $password = $this->request->getVar('InputForPassword');
            $data = $model->where(['user_email' => $email, 'ativo' => 1])->first();
            //echo '<pre>'; var_dump($data); die;
            if ($data) {
                $pass = $data->user_password;
                $verify_pass = password_verify($password, $pass);
                if ($verify_pass) {

                    $ses_data = [
                        'user_id'       => $data->id,
                        'user_name'     => $data->user_name,
                        'user_email'    => $data->user_email,
                        'logged_in'     => TRUE
                    ];
                    $this->session->set($ses_data);

                    log_message('info', 'O usuário '.$this->session->get('user_name').' logou no sistema');
                    
                    if($data->troca_senha == 1){
                        return redirect()->to(base_url('/dashboard/trocaSenha'));
                    } else {
                        return redirect()->to(base_url('/dashboard'));
                    }
                    exit();
                } else {
 
                    log_message('info', 'Tentativa de login falha (erro de senha) com o e-mail '.$this->request->getVar('InputForEmail'));

                   $this->session->setFlashdata('msg', 'Senha inválida');
                    return redirect()->to(base_url('/login'));
                }
            } else {
 
                log_message('info', 'Tentativa de login falha (E-mail não encontrado) com o e-mail '.$this->request->getVar('InputForEmail'));

                $this->session->setFlashdata('msg', 'E-mail não encontrado');
                return redirect()->to(base_url('/login'));
            }
        } else {
 
            log_message('info', 'Tentativa de login falha (Erro na validação do reCaptcha) com o e-mail '.$this->request->getVar('InputForEmail'));

            log_message('error', 'Erro de captcha no acesso à área administrativa.');
            $this->session->setFlashdata('msg', 'Erro na validação do reCaptcha. Tente novamente.');
            return redirect()->to(base_url('/login'));
        }
    }

    public function logout()
    {
        log_message('info', 'O usuário '.$this->session->get('user_name').' deslogou do sistema');

        $this->session = session();
        $this->session->destroy();
        return redirect()->to(base_url('/login'));
    }

    public function forget() {
        $eml = $this->request->getVar('InputForEmail');
        if ($eml != '') {
            $mailControl = new MailcontrolLibrary();
            $model = new UserModel();

            $data = $model->where(['user_email' => $eml, 'ativo' => 1])->first();
            if ($data) {
                $senha_pa = gerarSenha(10);

                $dt = [
                    'user_password'  => password_hash($senha_pa, PASSWORD_DEFAULT),
                    'troca_senha' => 1,
                ];
                $model->update($data->id, $dt);


                $email = [
                    'html' => '<p>Prezado,<br>Segue sua nova senha conforme solicitado pelo site:</p>
                    <p>
                        <strong>Senha: </strong> ' . $senha_pa . '<br>
                        <strong>IP: </strong> ' . $_SERVER['REMOTE_ADDR'] . '<br>
                        <strong>Data: </strong> ' . date('d/m/Y H:i') . '
                    </p>',
                    'subject' => 'Lembrete de senha!',
                    'to' => array(
                        array(
                            'email' => $eml,
                        ),
                    ),
                    'from' => array(
                        'email' => $this->session->get('SENDER_MAIL'),
                        'name' => $this->session->get('SENDER_NAME')
                    ),
                ];

                $mailControl->sendEmail($email);

                log_message('info', 'Recuperação de senha com o e-mail '.$this->request->getVar('InputForEmail'));

                $this->session->setFlashdata('msg', 'Lembrete enviado para o e-mail informado');
                return redirect()->to(base_url('/login'));
            } else {

                log_message('info', 'Erro na recuperação de senha (e-mail não encontrado) com o e-mail '.$this->request->getVar('InputForEmail'));

                $this->session->setFlashdata('msg', 'E-mail não encontrado');
                return redirect()->to(base_url('/login'));
            }
        }
    }

}
