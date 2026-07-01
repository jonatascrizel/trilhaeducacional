<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 vh-100">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Cursos</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?= base_url('/cursos/add') ?>" class="btn btn-personal btn-sm" title="Adiciona um novo curso">
            <i class="fas fa-plus-circle"></i>
            Adicionar
        </a>
    </div>
  </div>

  <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Listagem</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#manual" type="button" role="tab" aria-controls="profile" aria-selected="false">Manual do usuário</button>
    </li>
  </ul>
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

      <div class="mb-5">
        <table class="table table-striped table-sm" id="tabelaPrincipal">
          <thead>
            <tr>
              <th>#</th>
              <th>Nome</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php
            //echo '<pre>'; var_dump($users); die;
            foreach ($textos as $k => $n) {
            ?>
              <tr>
                <td><?= ($k + 1) ?></td>
                <td><?= $n->nome ?></td>
                <td>
                  <a href="javascript:ver_unidades('<?= $n->id ?>')" title="Ver unidades"><i class="far fa-list-alt"></i></a>
                  <a href="javascript:ver_inscritos('<?= $n->id ?>')" title="Ver inscritos"><i class="fas fa-address-book"></i></a>
                  <a href="<?=base_url('/Downloads/aVerRespostas/'.$n->id)?>" title="Ver respostas"><i class="far fa-file-excel"></i></a>
                  <a href="<?= base_url('cursos/edit/' . $n->id) ?>" title="Editar"><i class="far fa-edit"></i></a>
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
  };
</script>

<?= $this->endSection() ?>