<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Jônatas Crizel @ Next Step Up" />
    <title><?= session()->get('SEO_title') ?> [ADMIN]</title>
    <meta http-equiv="expires" content="<?= date('D, d M Y H:i:s', strtotime('2025-06-02')) ?> GMT-3" />

    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('assets/img/apple-touch-icon.png') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('assets/img/favicon-32x32.png') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('assets/img/favicon-16x16.png') ?>">
    <link rel="manifest" href="<?= base_url('assets/site.webmanifest') ?>">
    <link rel="mask-icon" href="<?= base_url('assets/img/safari-pinned-tab.svg') ?>" color="#5bbad5">
    <link rel="shortcut icon" href="<?= base_url('assets/img/favicon.png') ?>">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet" />
    <link rel="preload" href="<?= base_url('assets/css/all.min.css') ?>" as="style" onload="this.onload=null;this.rel='stylesheet'" />
    <!--<link href="<?= base_url('assets/css/dataTables.bootstrap5.min.css') ?>" rel="stylesheet" />-->
    <link href="<?= base_url('assets/css/datatables.min.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('assets/css/jquery-ui.min.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('assets/css/jquery-ui.theme.min.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('assets/css/bootstrap-select.min.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('assets/css/admin.css') ?>" rel="stylesheet" />

</head>

<body class="">

    <header class="navbar navbar-dark sticky-top flex-md-nowrap p-0 shadow" style="background-color:<?php if(ENVIRONMENT == 'development') echo '#993333'; else echo '#1A3F5A';?> !important;" >
        <button class="navbar-toggler d-md-none collapsed ms-3" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="<?= base_url('/Dashboard') ?>">
            <img src="<?= base_url('assets/img/logo_pb.png') ?>" alt="<?= session()->get('SEO_title') ?>" />
        </a>

        <div class="dropdown me-md-4 ms-1">
            <span class="text-white d-inline-block me-2">Olá <?= session()->get('user_name') ?><br />
                <small><?= session()->get('nome_perfil') ?></small>
             </span>
            <a class="dropdown-toggle text-decoration-none text-white" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user"></i>
            </a>

            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
                <li><a class="dropdown-item" href="<?= base_url('/dashboard/trocaSenha') ?>" title="Trocar senha" data-bs-placement="left">
                        <i class="fas fa-key"></i> Trocar senha</a></li>
                <li><a class="dropdown-item" href="<?= base_url('/Alertas/meusAlertas') ?>" title="Ver os alertas que recebi" data-bs-placement="left">
                        <i class="fas fa-bell"></i> Alertas</a></li>
                <li><a class="dropdown-item" href="<?= base_url('/login/logout') ?>" title="Sair" data-bs-placement="left">
                        <i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
    </header>

    <div class="container-fluid mb-3">
        <div class="row">