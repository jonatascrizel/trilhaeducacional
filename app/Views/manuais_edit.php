<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 vh-100">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manuais > Editar</h1>
  </div>

  <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Listagem</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#manualtxt" type="button" role="tab" aria-controls="profile" aria-selected="false">Manual do usuário</button>
    </li>
  </ul>
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

      <form id="formCadastro" method="post" action="<?= base_url('manuais/update') ?>" class="mb-5 mt-3">
        <input type="hidden" name="id" id="id" value="<?= $txt->id ?>" />

        <div class="mb-3">
          <label for="nome" class="form-label">Menu:</label>
          <input type="text" class="form-control-plaintext" id="nome" name="nome" readonly value="<?= $txt->nome ?>" />
        </div>

        <div class="mb-3">
          <label for="manual" class="form-label">Conteúdo:</label>
          <textarea class="form-control" id="manual" name="manual"><?= $txt->manual ?></textarea>
        </div>

        <button type="button" onclick="submitForm('formCadastro')" class="btn btn-personal">Salvar</button>

      </form>

    </div>
    <div class="tab-pane fade" id="manualtxt" role="tabpanel" aria-labelledby="profile-tab">
      <?= $manual ?>
    </div>
  </div>

</main>
<script>
  window.onload = function() {
    ckeditor("manual");
  }
</script>