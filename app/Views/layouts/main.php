<!DOCTYPE html>
<html lang="pt-BR">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Jônatas Crizel @ Next Step Up" />
    <title><?= session()->get('SEO_title') ?></title>

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
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@0,100..900;1,100..900&family=Yatra+One&display=swap" rel="stylesheet">

  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark" id="topo">
      <div class="container">
        <a class="navbar-brand" href="/">
          <img src="<?= base_url('assets/img/logo_pb.png') ?>" alt="<?= session()->get('SEO_title') ?>" title="<?= session()->get('SEO_title') ?>" /> <?= session()->get('SEO_title') ?>
        </a>
      </div>
    </nav>

    <?= $this->renderSection('content') ?>

    <footer>
      <div class="container">
        <p class="text-center">&copy; <?= date('Y') ?></p>
      </div>
    </footer>

    <script src="<?= base_url('assets/js/jquery.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/sweetalert2.all.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/waitingfor.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/jquery.validate.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/jquery.mask.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/site.js') ?>" type="text/javascript"></script>
  </body>

</html>