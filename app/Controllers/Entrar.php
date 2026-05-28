<?php

namespace App\Controllers;

use App\Models\cursanteModel;
use App\Libraries\CaptchaLibrary;
use App\Libraries\MailcontrolLibrary;


class Entrar extends BaseController
{
    public function index() {
        //die(password_hash('metallica69', PASSWORD_DEFAULT).' - '.uniqid());
        helper(['form', 'uteis']);
        $data['reCaptchaKey'] = $this->session->get('reCaptchaKey');
        echo view('entrar', $data);
    }

    public function auth()
    {
        //$captcha = new CaptchaLibrary();
        $status = verificarEnterprise($this->request->getVar('g-recaptcha-response'), 
                                      $this->session->get('reCaptchaKey'), 
                                      $this->session->get('gApiKey'),
                                      $this->session->get('gProjectID')
                                      );

        if (isset($status) && $status === true) {
            $model = new cursanteModel();

            $email = $this->request->getVar('InputForEmail');
            $password = $this->request->getVar('InputForPassword');
            $data = $model->where(['email' => $email])->first();
            //echo '<pre>'; var_dump($data); die;
            if ($data) {
                $pass = $data->senha;
                $verify_pass = password_verify($password, $pass);
                if ($verify_pass) {

                    $ses_data = [
                        'cursante_id'       => $data->id,
                        'cursante_nome'     => $data->nome,
                        'cursante_email'    => $data->email,
                        'acessado'     => TRUE
                    ];
                    $this->session->set($ses_data);

                    log_message('info', 'O cursante '.$this->session->get('cursante_nome').' logou no sistema');
                    
                    if($data->troca_senha == 1){
                        return redirect()->to(base_url('/perfil/trocaSenha'));
                    } else {
                        return redirect()->to(base_url('/aprender'));
                    }
                    exit();
                } else {
 
                    log_message('info', 'Tentativa de login de cursante falha (erro de senha) com o e-mail '.$this->request->getVar('InputForEmail'));

                   $this->session->setFlashdata('msg', 'Senha inválida');
                    return redirect()->to(base_url('/entrar'));
                }
            } else {
 
                log_message('info', 'Tentativa de login de cursante falha (E-mail não encontrado) com o e-mail '.$this->request->getVar('InputForEmail'));

                $this->session->setFlashdata('msg', 'E-mail não encontrado');
                return redirect()->to(base_url('/entrar'));
            }
        } else {
 
            log_message('info', 'Tentativa de login de cursante falha (Erro na validação do reCaptcha) com o e-mail '.$this->request->getVar('InputForEmail'));

            log_message('error', 'Erro de captcha no acesso à área administrativa.');
            $this->session->setFlashdata('msg', 'Erro na validação do reCaptcha. Tente novamente.');
            return redirect()->to(base_url('/entrar'));
        }
    }

    public function google(){
        $url = "https://accounts.google.com/o/oauth2/v2/auth?" . http_build_query([
            'client_id'     => $this->session->get('gIdClient'),
            'redirect_uri'  => base_url('entrar/oauthCallback'),
            'response_type' => 'code',
            'scope'         => 'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email',
            'access_type'   => 'offline'
        ]);

        return redirect()->to($url);
    }
    public function oauthCallback(){
        $code = $this->request->getVar('code');

        if (!$code) {
            return redirect()->to(base_url('/entrar'))->with('error', 'Falha na autenticação.');
        }

        // Troca o CODE pelo Access Token via cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://oauth2.googleapis.com/token");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'code'          => $code,
            'client_id'     => $this->session->get('gIdClient'),
            'client_secret' => $this->session->get('gSecretKey'),
            'redirect_uri'  => base_url('entrar/oauthCallback'),
            'grant_type'    => 'authorization_code'
        ]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($ch), true);
        curl_close($ch);

        if (isset($response['access_token'])) {
            // Busca os dados do perfil do usuário
            $userData = $this->getGoogleUserInfo($response['access_token']);

            //echo '<pre>'; print_r($userData); die;
            
            $model = new cursanteModel();
            $data = $model->where(['email' => $userData['email']])->first();
            //echo '<pre>-'; print_r($data); die;
            if($data){
                $ses_data = [
                    'cursante_id'       => $data->id,
                    'cursante_nome'     => $data->nome,
                    'cursante_email'    => $data->email,
                    'acessado'     => TRUE
                ];
                $this->session->set($ses_data);

                log_message('info', 'O cursante '.$this->session->get('cursante_nome').' logou no sistema com sua conta Google');
                
                return redirect()->to(base_url('/aprender'));
            } else {

                log_message('info', 'Tentativa de login de cursante falha (e-mail não encontrado) através do Google com o e-mail '.$userData['email']);

                $this->session->setFlashdata('msg', 'E-mail não localizado. Verifique ou entre em contato com o administrador.');
                return redirect()->to(base_url('/entrar'));
            }
        }
    }

    private function getGoogleUserInfo($token) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.googleapis.com/oauth2/v3/userinfo");
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer $token"]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $info = json_decode(curl_exec($ch), true);
        curl_close($ch);
        return $info;
    }

    public function sair()
    {
        log_message('info', 'O cursante '.$this->session->get('cursante_nome').' deslogou do sistema');

        $this->session = session();
        $this->session->destroy();
        return redirect()->to(base_url('/entrar'));
    }

    public function forget()
    {
        $eml = $this->request->getVar('InputForEmail');
        if ($eml != '') {
            $this->session = session();
            $mailControl = new MailcontrolLibrary();
            $model = new cursanteModel();

            $data = $model->where(['email' => $eml, 'ativo' => 1])->first();
            if ($data) {
                $senha_pa = gerarSenha(10);

                $dt = [
                    'senha'  => password_hash($senha_pa, PASSWORD_DEFAULT),
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

                log_message('info', 'Recuperação de senha do cursante com o e-mail '.$this->request->getVar('InputForEmail'));

                $this->session->setFlashdata('msg', 'Lembrete enviado para o e-mail informado');
                return redirect()->to(base_url('/entrar'));
            } else {

                log_message('info', 'Erro na recuperação de senha (e-mail não encontrado) com o e-mail '.$this->request->getVar('InputForEmail'));

                $this->session->setFlashdata('msg', 'E-mail não encontrado');
                return redirect()->to(base_url('/entrar'));
            }
        }
    }

}
