<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Acesso implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {   
        $uri = explode('/',current_url());{
            // if user not logged in
            if (!session()->has('acessado')) {
                // then redirct to login page
                return redirect()->to(base_url('/entrar'));
            }
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
