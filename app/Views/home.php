<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container min-vh-100 d-flex flex-column justify-content-center" id="home">
  <div class="row d-flex align-items-center justify-content-md-evenly">
    <div class="col-12 col-md-5 col-lg-4">
      <img src="uploads/trilha de aprendizagem.png" class="img-fluid" alt="Trilha de Aprendizagem">
    </div>
    <div class="col-12 col-md-5 col-lg-4 mt-5 mt-md-0">
      <h1>Um jeito divertido e eficaz de aprender!</h1>
      <a href="<?= base_url('/entrar') ?>" class="btn btn-primary btn-lg mt-3">Aprender agora</a>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
