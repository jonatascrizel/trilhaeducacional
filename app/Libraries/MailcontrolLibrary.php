<?php

namespace App\Libraries;

include_once APPPATH . 'ThirdParty/SendPulse/ApiInterface.php';
include_once APPPATH . 'ThirdParty/SendPulse/ApiClient.php';
//include_once APPPATH . 'ThirdParty/SendPulse/Automation360.php';
include_once APPPATH . 'ThirdParty/SendPulse/Storage/TokenStorageInterface.php';
include_once APPPATH . 'ThirdParty/SendPulse/Storage/FileStorage.php';
include_once APPPATH . 'ThirdParty/SendPulse/Storage/SessionStorage.php';
include_once APPPATH . 'ThirdParty/SendPulse/Storage/MemcachedStorage.php';
include_once APPPATH . 'ThirdParty/SendPulse/Storage/MemcacheStorage.php';

use Sendpulse\RestApi\ApiClient;
use Sendpulse\RestApi\Storage\FileStorage;

class MailcontrolLibrary
{
  protected $SPApiClient;
  protected $SMTPemail;

  public function __construct()
  {
    $this->session = session();

    if ($this->session->get('email_type') == "email") {
      # se o envio for feito via SMTP
      $cfgEml = [
        'protocol' => 'smtp',
        'charset' => 'utf-8',
        'mailType' => 'html',
        'wordWrap' => TRUE,
        'SMTPHost' => $this->session->get('email_SMTPHost'),
        'SMTPUser' => $this->session->get('email_SMTPUser'),
        'SMTPPass' => $this->session->get('email_SMTPPass'),
        'SMTPCrypto' => $this->session->get('email_SMTPCrypto'),
        'SMTPPort' => (int)$this->session->get('email_SMTPPort'),
      ];
      //echo '<pre>';print_r($cfgEml);die;
      $this->SMTPemail = \Config\Services::email();
      $this->SMTPemail->initialize($cfgEml);
      $this->SMTPemail->setFrom($this->session->get('SENDER_MAIL'), $this->session->get('SENDER_NAME'));
    } elseif ($this->session->get('email_type') == "sendpulse") {
      # se o envio for feito via SENDPULSE
      define('API_USER_ID', $this->session->get('API_USER_ID'));
      define('API_SECRET', $this->session->get('API_SECRET'));
      define('PATH_TO_ATTACH_FILE', __FILE__);
      $this->SPApiClient = new ApiClient(API_USER_ID, API_SECRET, new FileStorage());
    } else {
      throw new \Exception("O envio de e-mails não está configurado adequadamente.");
    }
  }

  public function addEmail($bookID, $emails, $confirmation = true)
  {
    /*
    $bookID = 123;
    $emails = array(
        array(
            'email' => 'subscriber@example.com',
            'variables' => array(
                'phone' => '+12345678900',
                'name' => 'User Name',
            )
        )
    );
    */

    if ($confirmation) {
      $additionalParams = array(
        'confirmation' => 'force',
        'sender_email' => $this->session->get('SENDER_MAIL'),
      );
      $envio = $this->SPApiClient->addEmails($bookID, $emails, $additionalParams);
    } else {
      $envio = $this->SPApiClient->addEmails($bookID, $emails);
    }

    if (isset($envio->error_code)) {
      log_message('error', 'Erro no salvamento do e-mail. Codigo ' . $envio->error_code . '. Mensagem: ' . $envio->message);
      return false;
    } else {
      log_message('info', 'Email enviado com sucesso');
      return true;
    }
  }

  public function sendEmail($email)
  {
    if ($this->session->get('email_CC') != '') {
      $email['to'][]['email'] = $this->session->get('email_CC');
    }
    /*
    $email = [
      'html' => '<p>Hello!</p>',
      'subject' => 'Mail subject',
      'to' => array(
        array(
            'email' => 'subscriber@example.com',
        ),
      ),
      'bcc' => array(
        array(
          'email' => 'manager@example.com',
        ),
      ),
      'from' => array(
        'email' => $this->session->get('SENDER_MAIL'),
        'name' => $this->session->get('SENDER_NAME')
      ),
    ];

    echo '<pre>';
    print_r($email);
    die;
    */

    if ($this->session->get('email_type') == "email") {
      # se o envio for feito via SMTP

      foreach ($email['to'] as $v) {
        $to[] = $v['email'];
      }
      $this->SMTPemail->setto(implode(', ', $to));

      if (isset($email['bcc']) && is_array($email['bcc'])) {
        foreach ($email['bcc'] as $v) {
          $bcc[] = $v['email'];
        }
        $this->SMTPemail->setBCC(implode(', ', $bcc));
      }

      $this->SMTPemail->setSubject($email['subject']);
      $this->SMTPemail->setMessage($email['html']);

      $envio = $this->SMTPemail->send();
      $data = $this->SMTPemail->printDebugger(['headers']);
      if ($envio) {
        log_message('info', $data);
        return true;
      } else {
        log_message('error', $data);
        return false;
      }
    } elseif ($this->session->get('email_type') == "sendpulse") {
      # se o envio for feito via SENDPULSE

      $envio = $this->SPApiClient->smtpSendMail($email);

      if (isset($envio->error_code)) {
        log_message('error', 'Erro no envio do e-mail. Codigo ' . $envio->error_code . '. Mensagem: ' . $envio->message);
        return false;
      } else {
        return true;
      }
    }
  }
}
