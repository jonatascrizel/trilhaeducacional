<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 vh-100">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Cursos > Unidades > Editar</h1>
  </div>

  <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Informações</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#manual" type="button" role="tab" aria-controls="profile" aria-selected="false">Manual do usuário</button>
    </li>
  </ul>
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">


      <form id="formCadastro" method="post" action="<?= base_url('Unidades/update') ?>" class="mb-5 mt-3">
        <input type="hidden" name="id_curso" id="id_curso" value="<?= $id ?>" />

        <div class="mb-3">
          <label for="unidade" class="form-label">Unidade:</label>
          <input type="text" class="form-control" id="unidade" name="unidade" value="" />
        </div>

        <div class="mb-3">
          <label for="numero" class="form-label">Número:</label>
          <input type="text" class="form-control" id="numero" name="numero" value="" />
        </div>

        <div class="mb-3">
          <label for="descricao" class="form-label">Descrição:</label>
          <textarea class="form-control" id="descricao" name="descricao"></textarea>
        </div>

        <button type="button" onclick="submitForm('formCadastro')" class="btn btn-personal">Salvar</button>

      </form>

    </div>
    <div class="tab-pane fade" id="manual" role="tabpanel" aria-labelledby="profile-tab">
      <?= $manual ?>
    </div>
  </div>

</main>
<script>
  window.onload = function() {
    ckeditor("descricao");
  }
</script>

<?= $this->endSection() ?>