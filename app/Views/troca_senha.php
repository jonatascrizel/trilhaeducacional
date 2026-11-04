<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 vh-100">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Troca de senha</h1>
  </div>

  <form id="formCadastro" method="post" action="<?= base_url('dashboard/trocaSenhaDo') ?>" class="mb-5 mt-3">

    <div class="mb-3">
      <p class="form-control-static">A senha deve conter letras maiúsculas, minúsculas e números; e ser formada, ao menos, por 6 caracteres.</p>
      <p class="form-control-static">Recomendamos a troca de senha por uma senha sua, pessoal, de fácil memorização e que contenha números e letras.</p>
      <p class="form-control-static">Datas de aniversário, sequencias de letras ou números (abc102030 por exemplo) ou coisas ligadas a você não são seguras.</p>
      <p class="form-control-static">Você ainda pode memorizar que, em todas as palavras que você utilizar, irá substituir o "i" por "1" e o "a" por 4. Por exemplo a palavra "amigo" ficaria "4m1go". Uma senha fácil na qual você não memoriza os caracteres individualmente, mas uma palavra e as regras.</p>
      <p class="form-control-static">Em vez de usar palavras, você também pode usar as letras iniciais das palavras de uma frase. Por exemplo, &ldquo;O aniversário da minha mãe é em maio&rdquo; ficaria &ldquo;oadmmeem&rdquo;.</p>
      <p class="form-control-static">O analisador observará mais do que o comprimento da senha, mas também a complexidade e irá gerar um índice, representado pela barra logo abaixo do campo Nova Senha. É esperado um mínimo de 6 caracteres e a combinação de letras maiúsculas, minúsculas e números, evitando palavras comuns e sequências numéricas.</p>
    </div>

    <div class="mb-3 d-block col-12 col-md-3">
      <label for="nome" class="form-label">Nova senha:</label>
      <div class="input-group">
        <input type="password" class="form-control" id="pws_nova" name="pws_nova" required />
        <span class="input-group-text" id="basic-addon1"><button type="button" class="btn" id="btn_pws_nova" onclick="verPws('pws_nova')" title="Exibe/oculta a senha"><i class="far fa-eye"></i></button></span>
      </div>
      <div class="elemValidador"><meter value="0" class="mtSenha" max="100" low="30" high="60" optimum="100" title="Força da senha"></meter></div>
    </div>

    <div class="mb-3 d-block col-12 col-md-3">
      <label for="nome" class="form-label">Confirmação da senha:</label>
      <div class="input-group">
        <input type="password" class="form-control" id="pws_confirma" name="pws_confirma" required />
        <span class="input-group-text" id="basic-addon1"><button type="button" class="btn" id="btn_pws_confirma" onclick="verPws('pws_confirma')" title="Exibe/oculta a senha"><i class="far fa-eye"></i></button></span>
      </div>
    </div>

    <button type="button" onclick="trocaSenha()" class="btn btn-personal">Salvar</button>

  </form>

</main>
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