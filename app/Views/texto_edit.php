<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 vh-100">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Textos > Editar</h1>
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


      <form id="formCadastro" method="post" action="<?= base_url('Textos/update') ?>" class="mb-5 mt-3">
        <input type="hidden" name="id" id="id" value="<?= $txt->id ?>" />

        <div class="mb-3">
          <label for="nome" class="form-label">Nome:</label>
          <input type="text" class="form-control" id="nome" name="nome" value="<?= $txt->nome ?>" />
          <div class="form-text">Esse é um indentificador interno do texto. Não é exibido para o cliente.</div>
        </div>

        <div class="mb-3">
          <label for="assunto" class="form-label">Assunto:</label>
          <input type="text" class="form-control" id="assunto" name="assunto" value="<?= $txt->assunto ?>" />
          <div class="form-text">Pode ser o assunto de um e-mail ou o título da página, dependendo de onde o texto é empregado.</div>
        </div>

        <div class="mb-3">
          <label class="form-label">Coringas:</label>
          <textarea class="form-control" disabled col="3"><?= $txt->coringas ?></textarea>
          <div class="form-text">São usados para substituir informações dinâmicas. Observe que os colchetes [] são parte integrante do coringa, quando o inserir mantenha conforme está aparedendo acima.</div>
        </div>

        <div class="mb-3">
          <label for="conteudo" class="form-label">Conteúdo:</label>
          <textarea class="form-control" id="conteudo" name="conteudo"><?= $txt->conteudo ?></textarea>
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
    ckeditor("conteudo");
  }
</script>