<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 vh-100">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Configurações > Editar</h1>
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


      <form id="formCadastro" method="post" action="<?= base_url('configuracoes/update') ?>" class="mb-5 mt-3">
        <input type="hidden" name="id" id="id" value="<?= $cfgItem->id ?>" />

        <div class="mb-3">
          <label for="configName" class="form-label">Item:</label>
          <input type="text" class="form-control-plaintext" id="configName" name="configName" aria-describedby="configNameHelp" readonly value="<?= $cfgItem->configName ?>" />
        </div>

        <div class="mb-3">
          <label for="configValue" class="form-label">Valor:</label>
          <input type="text" class="form-control" id="configValue" name="configValue" aria-describedby="configValueHelp" value="<?= $cfgItem->configValue ?>" />
          <div id="configValueHelp" class="form-text">Insira aqui o valor da configuração.</div>
        </div>

        <div class="mb-3">
          <p><?= $cfgItem->descricao ?></p>
        </div>

        <button type="button" onclick="submitForm('formCadastro')" class="btn btn-personal">Salvar</button>

      </form>


    </div>
    <div class="tab-pane fade" id="manual" role="tabpanel" aria-labelledby="profile-tab">
      <?= $manual ?>
    </div>
  </div>
</main>