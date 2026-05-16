<?= $this->extend('layouts/area_logada') ?>

<?= $this->section('content') ?>




    <div class="col-12 col-md-6 order-2 order-md-1" id="miolo_perfil">
      <h3>Troca de senha</h3>

      <form id="formCadastro" method="post" action="<?= base_url('perfil/updatepws') ?>" class="mb-5 mt-3">
        <input type="hidden" name="id" id="id" value="<?= $cursante->id ?>" />

        <div class="mb-3">
          <label for="pws_nova" class="form-label">Nova senha</label>
          <div class="input-group">
            <input type="password" class="form-control" id="pws_nova" name="pws_nova" required />
            <span class="input-group-text" id="basic-addon1"><button type="button" class="btn" id="btn_pws_nova" onclick="verPws('pws_nova')" title="Exibe/oculta a senha"><i class="far fa-eye"></i></button></span>
          </div>
          <div class="elemValidador"><meter value="0" class="mtSenha" max="100" low="30" high="60" optimum="100" title="Força da senha"></meter></div>
        </div>

        <div class="mb-3">
          <label for="pws_confirma" class="form-label">Confirmação da senha:</label>
          <div class="input-group">
            <input type="password" class="form-control" id="pws_confirma" name="pws_confirma" required />
            <span class="input-group-text" id="basic-addon1"><button type="button" class="btn" id="btn_pws_confirma" onclick="verPws('pws_confirma')" title="Exibe/oculta a senha"><i class="far fa-eye"></i></button></span>
          </div>
        </div>

        <button type="button" onclick="submitForm('formCadastro')" class="btn btn-primary">Salvar alterações</button>
      </form>

    </div>
    <!-- fim da div miolo_aprender -->

    <div class="col-12 col-md-4 order-1 order-md-2" id="detalhes">

      <div>
        <h4>Conta</h4>
        
        <a href="/perfil">Perfil</a>
        <a href="/perfil/senha" class="active">Senha</a>
        <a href="/perfil/preferencias">Preferências</a>
      </div>

    </div>
    <!-- fim da div stats -->

  </div>
</div>

<script defer src="<?= base_url('assets/js/jquery.complexify.banlist.js') ?>" type="text/javascript"></script>

<script>
  window.onload = function() {

    $.getScript(caminho + '/assets/js/jquery.complexify.js', function() {
      $("#pws_nova").complexify({
        bannedPassword: COMPLEXIFY_BANLIST,
        minimumChars: 6,
        strengthScaleFactor: .3
      }, function(valid, complexity) {
        $(".mtSenha").val(complexity);
      });
    });


    $("#cadastro").validate({
      rules: {
        pws_nova: {
          required: true,
          minlength: 6,
          password: true
        },
        pws_confirma: {
          required: true,
          equalTo: "#pws_nova"
        }
      }
    });
  }
</script>

<?= $this->endSection() ?>