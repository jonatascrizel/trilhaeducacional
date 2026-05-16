<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

use App\Models\configModel;

class AutoConfig implements FilterInterface
{
  public function before(RequestInterface $request, $arguments = null)
  {
    $model = new configModel();
    $session = session();
    $data = $model->findAll();
    foreach ($data as $v) {
      //echo $v->configName . '<hr>';
      //$_SESSION[$v->configName] = $v->configValue;
      $session->set($v->configName, $v->configValue);
    }
  }

  //--------------------------------------------------------------------

  public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
  {
    // Do something here
  }
}
