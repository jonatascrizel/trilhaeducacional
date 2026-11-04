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
    $configs = cache()->remember('app_global_configs', 86400, function () {
      $model = new configModel();
      return $model->findAll();
    });

    $session = session();
    foreach ($configs as $v) {
        $session->set($v->configName, $v->configValue);
    }
  }

  //--------------------------------------------------------------------

  public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
  {
    // Do something here
  }
}
