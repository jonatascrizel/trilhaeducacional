<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {   
        $uri = explode('/',current_url());
        //print_r($uri); die;
        /*
        if($uri[4] == 'pedidos' && $uri[5] == 'pdf'){

        } else 
        */{
            // if user not logged in
            if (!session()->has('logged_in')) {
                // then redirct to login page
                return redirect()->to(base_url('/login'));
            }
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
