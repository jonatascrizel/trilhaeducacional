<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 vh-100">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Usuários</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="<?= base_url('/usuarios/add') ?>" class="btn btn-personal btn-sm" title="Adiciona um novo usuário do sistema">
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

            <div class="row">
                <div class="mt-2">
                    <div class="form-check form-switch float-end">
                        <input class="form-check-input" type="checkbox" id="switchUserStatus" onchange="filtraUsuarios('switchUserStatus', 'check_ativo')" checked />
                        <label class="form-check-label" for="switchUserStatus" >Ocultar usuários desabilitados</label>
                    </div>
                </div>
            </div>


            <div class="mb-5">
                <table class="table table-striped table-sm" id="tabelaPrincipal" width="90%%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Usuário</th>
                            <th>E-mail</th>
                            <th>Status</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //echo '<pre>'; var_dump($users); die;
                        foreach ($users as $k => $n) {
                        ?>
                            <tr>
                                <td><?= ($k + 1) ?></td>
                                <td><?= $n->user_name ?></td>
                                <td><?= $n->user_email ?></td>
                                <td>
                                    <?php
                                    if ($n->ativo == 1) {
                                    ?>
                                        <i class="fas fa-circle text-success"></i>
                                    <?php
                                    } else {
                                    ?>
                                        <i class="fas fa-circle text-secondary"></i>
                                    <?php
                                    }
                                    ?>
                                </td>
                                <td><?= $n->ativo ?></td>
                                <td>
                                    <a href="<?= base_url('/usuarios/edit/' . $n->id) ?>" title="Editar"><i class="fas fa-edit"></i></a>
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
        tabelaPrincipal = $('#tabelaPrincipal').DataTable({
            columnDefs: [
                { orderable: false, targets: 0 },
                { visible: false, targets: 4 }
            ],
            order: [[1, 'asc']],
            fnDrawCallback: function (settings) {
                numerar('tabelaPrincipal');
            },
            initComplete: function () {
                filtraUsuarios('switchUserStatus');
            },
        });
        
        //filtraUsuarios('switchUserStatus');
    };
</script>

<?= $this->endSection() ?>