<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 vh-100">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Cursos > Unidades > Editar</h1>
  </div>
  <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?=base_url('cursos/edit/'.$breadcumb->id_curso)?>">Voltar ao curso <?=$breadcumb->curso?></a></li>
      <li class="breadcrumb-item active" aria-current="page">Unidade</li>
    </ol>
  </nav>

  <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Informações</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="licoes-tab" data-bs-toggle="tab" data-bs-target="#licoes" type="button" role="tab" aria-controls="profile" aria-selected="false">Lições</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#manual" type="button" role="tab" aria-controls="profile" aria-selected="false">Manual do usuário</button>
    </li>
  </ul>
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">


      <form id="formCadastro" method="post" action="<?= base_url('Unidades/update') ?>" class="mb-5 mt-3">
        <input type="hidden" name="id" id="id" value="<?= $txt->id ?>" />
        <input type="hidden" name="id_curso" id="id_curso" value="<?= $txt->id_curso ?>" />

        <div class="mb-3">
          <label for="unidade" class="form-label">Unidade:</label>
          <input type="text" class="form-control" id="unidade" name="unidade" value="<?= $txt->unidade ?>" />
        </div>

        <div class="mb-3">
          <label for="numero" class="form-label">Número:</label>
          <input type="text" class="form-control" id="numero" name="numero" value="<?= $txt->numero ?>" />
        </div>

        <div class="mb-3">
          <label for="descricao" class="form-label">Descrição:</label>
          <textarea class="form-control" id="descricao" name="descricao"><?= $txt->descricao ?></textarea>
        </div>

        <button type="button" onclick="submitForm('formCadastro')" class="btn btn-personal">Salvar</button>

      </form>

    </div>
    <div class="tab-pane fade" id="licoes" role="tabpanel" aria-labelledby="profile-tab">
      <div class="my-2 d-md-flex justify-content-end">
        <a href="<?= base_url('/licoes/add/'.$txt->id) ?>" class="btn btn-personal btn-sm" title="Adiciona uma nova lição">
            <i class="fas fa-plus-circle"></i>
            Adicionar
        </a>
      </div>

        <div class="mb-5">
        <table class="table table-striped table-sm" id="tabelaPrincipal">
          <thead>
            <tr>
              <th>#</th>
              <th>Ordem</th>
              <th>Lição</th>
              <th>Tipo</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php
            //echo '<pre>'; var_dump($users); die;
            foreach ($licoes as $k => $n) {
            ?>
              <tr>
                <td><?= ($k + 1) ?></td>
                <td><?= $n->ordem ?></td>
                <td><?= $n->titulo ?></td>
                <td><?= $n->tipo ?></td>
                <td>
                  <a href="javascript:ver_card('<?= $n->id ?>')" title="Ver lição"><i class="fas fa-eye"></i></a>
                  <a href="<?= base_url('licoes/edit/' . $n->id) ?>" title="Editar"><i class="far fa-edit"></i></a>
                  <a href="javascript:deleta_licao('<?= $n->id ?>')" title="Deletar"><i class="fas fa-minus-circle"></i></a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    

    </div>
    <div class="tab-pane fade" id="manual" role="tabpanel" aria-labelledby="profile-tab">
      <?= $manual ?>
    </div>
  </div>

</main>
<script>
  window.onload = function() {
    ckeditor("descricao");

    dtDefaults();
    $('#tabelaPrincipal').DataTable({
      columnDefs: [
        { orderable: false, targets: 0 }
      ],
      //order: [[1, 'desc']],
      fnDrawCallback: function (settings) {
        numerar('tabelaPrincipal');
      },
    });

    const urlParams = new URLSearchParams(window.location.search);
    const tabNome = urlParams.get('aba'); // Ex: ?aba=licoes

    if (tabNome) {
        // Seleciona o botão que tem o target correspondente
        const abaTrigger = document.querySelector(`#myTab button[data-bs-target="#${tabNome}"]`);
        
        if (abaTrigger) {
            // Cria a instância do Bootstrap Tab e mostra
            const tab = new bootstrap.Tab(abaTrigger);
            tab.show();
        }
    }
  }
</script>

<?= $this->endSection() ?>