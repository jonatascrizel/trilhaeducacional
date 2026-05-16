<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 vh-100">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Cursos > Inscrever</h1>
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


      <form id="formCadastro" method="post" action="<?= base_url('Cursos/submit') ?>" class="mb-5 mt-3">
        <input type="hidden" name="id_curso" id="id_curso" value="<?=$id_curso?>" />

        <div class="mb-3">
          <label for="id_cursos_licoes_tipo" class="form-label">Cursante:</label>
          <select class="form-select" name="id_cursante" id="id_cursante" required onchange="cadastra_cursante(this.value)">
            <option value="" selected disabled>Selecione</option>
            <option value="ADD">>>> Cadastrar novo e inscrever</option>
            <?php
            foreach($cursantes as $t){
            ?>
            <option value="<?=$t->id?>"><?=$t->nome?></option>
            <?php
            }
            ?>
          </select>
        </div>

        <input type="hidden" name="id" id="id" value="<?= $id ?>" />

        <div class="mb-3 new">
          <label for="nome" class="form-label">Nome:</label>
          <input type="text" class="form-control" id="nome" name="nome" value="" required />
        </div>

        <div class="mb-3 new">
          <label for="email" class="form-label">E-mail:</label>
          <input type="email" class="form-control" id="email" name="email" value="" required />
        </div>

        <div class="mb-3 new">
          <label for="telefone" class="form-label">Telefone:</label>
          <input type="text" class="form-control phone_with_ddd" id="telefone" name="telefone" value="" />
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
    //cadastra_cursante($('#id_cursante').val())
    $('.new').hide();
  }
</script>

<?= $this->endSection() ?>