<?php

namespace App\Controllers;

require('../vendor/autoload.php');

use App\Models\downloadModel;
use App\Models\manualModel;

class downloads extends BaseController
{

    public function __construct()
    {
        //parent::__construct();
        $this->bannerModel = new downloadModel();
        $this->manualModel = new manualModel();
        $this->manual = $this->manualModel->where('id', 51)->first()->manual;
    }


    public function index()
    {
        return redirect()->to(base_url('downloads/listar'));
    }

    public function listar()
    {
        log_message('info', 'O usuário '.$this->session->get('user_name').' acessou a listagem de banners');

        $data['banners'] = $this->bannerModel->orderBy('nome', 'asc')->findAll();
        $data['manual'] = $this->manual;

        echo view('header');
        echo view('menu');
        echo view('banners_lista', $data);
        echo view('footer');
    }

    public function add()
    {
        $data['manual'] = $this->manual;

        echo view('header');
        echo view('menu');
        echo view('banners_add', $data);
        echo view('footer');
    }

    public function store() {
      log_message('info', 'O usuário '.$this->session->get('user_name').' adicionou o banner '.$this->request->getVar('nome'));

      $data = [
          'id'  => $this->request->getVar('id'),
          'nome' => ($this->request->getVar('nome')),
          'titulo'  => $this->request->getVar('titulo'),
          'frase_apoio' => ($this->request->getVar('frase_apoio')),
          'link' => ($this->request->getVar('link')),
          'imagem'  => $this->request->getVar('imagemOld'),
      ];

      $img = $this->request->getFile('imagem');
      if ($img != '') {
        $nome_img = slugify($this->request->getVar('nome')).'.'.$img->getClientExtension();
        $path = $img->move(ROOTPATH.'/public/uploads/', $nome_img, true);

        $data['imagem'] = $nome_img;
      }

      //echo '<pre>'; print_r($data); die;

      $save = $this->bannerModel->replace($data);

      return redirect()->to(base_url('banners'));
    }

    public function edit($id)
    {
        $data['banners'] = $this->bannerModel->where('id', $id)->first();
        $data['manual'] = $this->manual;

        echo view('header');
        echo view('menu');
        echo view('banners_edit', $data);
        echo view('footer');
    }


}
