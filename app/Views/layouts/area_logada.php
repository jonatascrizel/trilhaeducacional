<!DOCTYPE html>
<html lang="pt-BR">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Jônatas Crizel @ Next Step Up" />
    <title><?= session()->get('SEO_title') ?> [Área do cursante]</title>

    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('assets/img/apple-touch-icon.png') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('assets/img/favicon-32x32.png') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('assets/img/favicon-16x16.png') ?>">
    <link rel="manifest" href="<?= base_url('assets/site.webmanifest') ?>">
    <link rel="mask-icon" href="<?= base_url('assets/img/safari-pinned-tab.svg') ?>" color="#5bbad5">
    <link rel="shortcut icon" href="<?= base_url('assets/img/favicon.png') ?>">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('assets/css/all.min.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('assets/css/site.css') ?>" rel="stylesheet" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  </head>
  <body>


  <div class="container-fluid">
  <div class="row">

    <div class="col-12 col-md-2 order-2 order-md-1" id="menu">
      <h1 class="text-center h2"><?= session()->get('SEO_title') ?></h1>

      <ul class="nav">
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('/aprender') ?>" ><i class="fas fa-shapes"></i> <span>Cursos</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="<?= base_url('/aprender/trilha') ?>"><i class="fas fa-chalkboard-teacher"></i> <span>Aprender</span></a>
        </li>
<!--        
        <li class="nav-item">
          <a class="nav-link disabled" href="#" disabled aria-disabled="true" tabindex="-1"><i class="fab fa-font-awesome-flag"></i> Metas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#" disabled aria-disabled="true" tabindex="-1"><i class="fas fa-trophy"></i> Ranking</a>
        </li>
-->
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('/perfil') ?>"><i class="fas fa-user-cog"></i> <span>Perfil</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('/entrar/sair') ?>"><i class="fas fa-sign-out-alt"></i> <span>Sair</span></a>
        </li>
      </ul>
    </div>
    <!-- fim da div menu -->

    <?= $this->renderSection('content') ?>

    <!-- Modal -->
    <div class="modal fade" id="jsModal" tabindex="-1" aria-labelledby="jsModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="jsModalLabel">Modal title</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">


          </div>
        </div>
      </div>
    </div>
    <!-- fim modal -->

    <audio id="task_error" src="<?= base_url('assets/audio/task_error.mp3') ?>"></audio>
    <audio id="task_success" src="<?= base_url('assets/audio/task_success.mp3') ?>"></audio>
    <audio id="task_complete" src="<?= base_url('assets/audio/task_complete.mp3') ?>"></audio>

    <script>
      let caminho = "<?= base_url() ?>";
      let enviroment = "<?= ENVIRONMENT ?>";
      let reCaptchaKey = "<?= session()->get('reCaptchaKey') ?>";
    </script>

    <script src="<?= base_url('assets/js/jquery.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/sweetalert2.all.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/waitingfor.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/jquery.validate.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/jquery.mask.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/jquery-ui.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/site.js') ?>" type="text/javascript"></script>
  </body>

</html>