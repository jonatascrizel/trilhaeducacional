<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 vh-100">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Configurações</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
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
        <table class="table table-striped table-sm " id="tabelaPrincipal">
          <thead>
            <tr>
              <th>#</th>
              <th>Item</th>
              <th>Valor</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php
            //echo '<pre>'; var_dump($users); die;
            foreach ($cfgItens as $k => $n) {
            ?>
              <tr>
                <td><?= ($k + 1) ?></td>
                <td><?= $n->configName ?></td>
                <td><?= limitaTxt($n->configValue, 40) ?></td>
                <td>
                  <a href="<?= base_url('/configuracoes/edit/' . $n->id) ?>" title="Editar"><i class="fas fa-edit"></i></a>
                  <a class="d-inline-block" title="<?= $n->descricao ?>">
                    <i class="fas fa-info-circle"></i>
                  </a>
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

      Swal.fire({
        title: "Você tem certeza do que irá alterar aqui?",
        text: "Alterações feitas de forma errada podem desconfigurar o sistema.",
        icon: "warning",
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: "Continuar",
        denyButtonText: "Cancelar"
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
          
        } else if (result.isDenied) {
          location.href = "<?= base_url('/dashboard') ?>";
        }
      });
  };
</script>