<?= $this->extend('layouts/area_logada') ?>

<?= $this->section('content') ?>




    <div class="col-12 col-md-6 order-2 order-md-1" id="miolo_perfil">
      <h3>Preferências</h3>

      <form id="formCadastro" method="post" action="<?= base_url('perfil/updatepref') ?>" class="mb-5 mt-3">
        <input type="hidden" name="id" id="id" value="<?= $cursante->id ?>" />

        <h4>Notificações</h4>

        <div class="form-check form-switch mb-3">
          <input class="form-check-input" type="checkbox" id="notfica_progressao_eml" name="notfica_progressao_eml" disabled />
          <label class="form-check-label" for="notfica_progressao_eml">Lembrete de progressão no e-mail</label>
        </div>

        <div class="form-check form-switch mb-3">
          <input class="form-check-input" type="checkbox" id="notfica_progressao_wpp" name="notfica_progressao_wpp" disabled />
          <label class="form-check-label" for="notfica_progressao_wpp">Lembrete de progressão no whatsapp</label>
        </div>

        <h4>Privacidade</h4>

        <div class="form-check form-switch mb-3">
          <input class="form-check-input" type="checkbox" id="perfil_publico" name="perfil_publico" disabled />
          <label class="form-check-label" for="perfil_publico">Tornar o meu perfil público</label>
          <p class="small">Permite que outras pessoas vejam seu perfil e sua pontuação.</p>
        </div>

        <button type="button" onclick="submitForm('formCadastro')" class="btn btn-primary" disabled>Salvar alterações</button>
      </form>

    </div>
    <!-- fim da div miolo_aprender -->

    <div class="col-12 col-md-4 order-1 order-md-2" id="detalhes">

      <div>
        <h4>Conta</h4>
        
        <a href="/perfil">Perfil</a>
        <a href="/perfil/senha">Senha</a>
        <a href="/perfil/preferencias" class="active">Preferências</a>
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