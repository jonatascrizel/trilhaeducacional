<?php

namespace App\Libraries;


class CaptchaLibrary
{
  protected $secret;
  protected $url = 'https://www.google.com/recaptcha/api/siteverify';

  public function __construct()
  {
    $this->session = session();

    if ($this->session->get('reCaptcha_server')) {
      $this->secret = $this->session->get('reCaptcha_server');
    } else {
      throw new \Exception("O reCaptcha não está configurado.");
    }
  }

  public function verifyResponse($recaptchaResponse)
  {
    $data1 = array('secret' => $this->secret, 'response' => $recaptchaResponse);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $this->url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $response = curl_exec($ch);
    curl_close($ch);

    $status = json_decode($response, true);

    return $status;
  }
}
