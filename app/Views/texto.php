<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

	<section id="topo" class="bg_texto">
    <div class="container mt-5">
      <h1><?=$txt->assunto?></h1>
    </div>
	</section>

  <section id="contato" class="py-4">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <?=$txt->conteudo?>
        </div>
      </div>
    </div>
  </section>

<?= $this->endSection() ?>

