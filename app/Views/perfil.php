<?= $this->extend('layouts/area_logada') ?>

<?= $this->section('content') ?>




    <div class="col-12 col-md-6 order-2 order-md-1" id="miolo_perfil">
      <h3>Perfil</h3>

      <form id="formCadastro" method="post" action="<?= base_url('perfil/update') ?>" class="mb-5 mt-3">
        <input type="hidden" name="id" id="id" value="<?= $cursante->id ?>" />

        <div class="mb-3">
          <label for="nome" class="form-label">Nome</label>
          <input type="text" class="form-control form-control-lg" id="nome" name="nome" value="<?= $cursante->nome ?>" required />
        </div>

        <div class="mb-3">
          <label for="apelido" class="form-label">Apelido</label>
          <input type="text" class="form-control form-control-lg" id="apelido" name="apelido" value="<?= $cursante->apelido ?>" />
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">E-mail</label>
          <input type="email" class="form-control form-control-lg" id="email" name="email" value="<?= $cursante->email ?>" readonly />
        </div>

        <div class="mb-3">
          <label for="telefone" class="form-label">Telefone</label>
          <input type="text" class="form-control form-control-lg phone_with_ddd" id="telefone" name="telefone" value="<?= $cursante->telefone ?>" />
        </div>

        <button type="button" onclick="submitForm('formCadastro')" class="btn btn-primary">Salvar alterações</button>
      </form>

    </div>
    <!-- fim da div miolo_aprender -->

    <div class="col-12 col-md-4 order-1 order-md-2" id="detalhes">

      <div>
        <h4>Conta</h4>
        
        <a href="/perfil" class="active">Perfil</a>
        <a href="/perfil/senha">Senha</a>
        <a href="/perfil/preferencias">Preferências</a>
      </div>

    </div>
    <!-- fim da div stats -->

  </div>
</div>
<script>
  window.onload = function() {
    carregaForms()
  }
</script>
<?= $this->endSection() ?>