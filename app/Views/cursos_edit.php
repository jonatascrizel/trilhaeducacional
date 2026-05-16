<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 vh-100">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Cursos > Editar</h1>
  </div>

  <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Informações</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#unidades" type="button" role="tab" aria-controls="profile" aria-selected="false">Unidades didáticas</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#inscritos" type="button" role="tab" aria-controls="profile" aria-selected="false">Inscritos</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#manual" type="button" role="tab" aria-controls="profile" aria-selected="false">Manual do usuário</button>
    </li>
  </ul>
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">


      <form id="formCadastro" method="post" action="<?= base_url('Cursos/update') ?>" class="mb-5 mt-3">
        <input type="hidden" name="id" id="id" value="<?= $txt->id ?>" />

        <div class="mb-3">
          <label for="nome" class="form-label">Nome:</label>
          <input type="text" class="form-control" id="nome" name="nome" value="<?= $txt->nome ?>" required />
        </div>

        <div class="mb-3">
          <label for="descricao" class="form-label">Descrição:</label>
          <textarea class="form-control" id="descricao" name="descricao"><?= $txt->descricao ?></textarea>
        </div>

        <button type="button" onclick="submitForm('formCadastro')" class="btn btn-personal">Salvar</button>

      </form>

    </div>
    <div class="tab-pane fade" id="unidades" role="tabpanel" aria-labelledby="profile-tab">
      <div class="my-2 d-md-flex justify-content-end">
        <a href="<?= base_url('/unidades/add/'.$txt->id) ?>" class="btn btn-personal btn-sm" title="Adiciona uma nova unidade">
            <i class="fas fa-plus-circle"></i>
            Adicionar
        </a>
      </div>

        <div class="mb-5">
        <table class="table table-striped table-sm" id="tabelaPrincipal">
          <thead>
            <tr>
              <th>#</th>
              <th>Número</th>
              <th>Unidade</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php
            //echo '<pre>'; var_dump($users); die;
            foreach ($unidades as $k => $n) {
            ?>
              <tr>
                <td><?= ($k + 1) ?></td>
                <td><?= $n->numero ?></td>
                <td><?= $n->unidade ?></td>
                <td>
                  <a href="javascript:ver_licoes('<?= $n->id ?>')" title="Ver lições"><i class="far fa-list-alt"></i></a>
                  <a href="<?= base_url('unidades/edit/' . $n->id) ?>" title="Editar"><i class="far fa-edit"></i></a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    

    </div>
    <div class="tab-pane fade" id="inscritos" role="tabpanel" aria-labelledby="profile-tab">
      <div class="my-2 d-md-flex justify-content-end">
        <a href="<?= base_url('/cursos/inscrever/'.$txt->id) ?>" class="btn btn-personal btn-sm" title="Adiciona uma novo inscrito">
            <i class="fas fa-plus-circle"></i>
            Adicionar
        </a>
      </div>

        <div class="mb-5">
        <table class="table table-striped table-sm" id="tabelaInscritos">
          <thead>
            <tr>
              <th>#</th>
              <th>Nome</th>
              <th>E-mail</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php
            //echo '<pre>'; var_dump($users); die;
            foreach ($inscritos as $k => $n) {
            ?>
              <tr>
                <td><?= ($k + 1) ?></td>
                <td><?= $n->nome ?></td>
                <td><?= $n->email ?></td>
                <td>
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
      order: [[1, 'asc']],
      fnDrawCallback: function (settings) {
        numerar('tabelaPrincipal');
      },
    });
    $('#tabelaInscritos').DataTable({
      columnDefs: [
        { orderable: false, targets: 0 }
      ],
      order: [[1, 'asc']],
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