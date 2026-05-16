<?php
################################################################
# Classe de manipulação do Email Mkt da Locaweb
# Jonatas Crizel @ 2023-08-15 
#
################################################################
namespace App\Libraries;

class NewsLibrary 
{
  protected $chave;
  protected $url = 'https://emailmarketing.locaweb.com.br/api/v1';
  protected $idConta;
  protected $contato = [];

  public function __construct() {
    $this->session = session();

    if ($this->session->get('lw_chaveApi') && $this->session->get('lw_id_conta')) {
      $this->chave = $this->session->get('lw_chaveApi');
      $this->idConta = $this->session->get('lw_id_conta');
    } else {
      throw new \Exception("O Email Mkt não está configurado.");
    }
  }

  public function addContato($contato, $idLista) {

    if(!$idLista){
      throw new \Exception("A lista precisa ser informada.");
    }
    if(!$contato){
      throw new \Exception("É preciso informar um contato.");
    }

    $this->contato['contact']['email'] = $contato;
    $this->contato['contact']['list_ids'][] = $idLista;

    $urlAdd = $this->url . "/accounts/".$this->idConta."/contacts";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $urlAdd);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array('X-Auth-Token: '.$this->chave, 
                                                'Content-type: application/json'));
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->contato));
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $this->validaCodigoHttp($http_code, $response);

    $status = json_decode($response, true);

    return $status;
  }

  function validaCodigoHttp($http_code, $resultado_http='') {
    if (empty ($http_code)) {
      throw new \Exception("Erro na chamada do webservice, falta algum " .
      "parametro na url ou algum problema na rede.");
    }
    if ($http_code != '200') {
      throw new \Exception("Erro na chamada do webservice: " .
      "statusCode:$http_code, mensagem:$resultado_http");
    }
  }

}