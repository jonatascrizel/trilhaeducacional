<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 vh-100">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Usuários > Adicionar</h1>
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


            <form id="formCadastro" method="post" action="<?= base_url('usuarios/store') ?>" class="mb-5 mt-3">

                <div class="mb-3">
                    <label for="user_name" class="form-label">Nome:*</label>
                    <input type="text" class="form-control" id="user_name" name="user_name" aria-describedby="user_nameHelp" required />
                    <div id="user_nameHelp" class="form-text">Insira aqui o nome do usuário.</div>
                </div>

                <div class="mb-3">
                    <label for="user_email" class="form-label">E-mail:</label>
                    <input type="email" class="form-control" id="user_email" name="user_email" aria-describedby="user_emailHelp" required />
                    <div id="user_emailHelp" class="form-text">Insira aqui o e-mail do usuário.</div>
                </div>

                <div class="mb-3">
                    <label for="ativo" class="form-label">Status:</label>
                    <input type="checkbox" class="form-check-input" id="ativo" name="ativo" aria-describedby="ativoHelp" value="1" checked />
                    <div id="ativoHelp" class="form-text">Marque para tornar esse usuário ativo no sistema.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Menus habilitados:</label>
                    <?php
                    foreach ($menus as $m) {
                    ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="<?= $m->id ?>" id="menu<?= $m->id ?>" name="menus[]">
                            <label class="form-check-label" for="menu<?= $m->id ?>">
                                <?= $m->nome ?>
                            </label>
                        </div>
                    <?php
                    }
                    ?>
                </div>

                <button type="button" onclick="submitForm('formCadastro')" class="btn btn-secondary">Salvar</button>

            </form>

        </div>
        <div class="tab-pane fade" id="manual" role="tabpanel" aria-labelledby="profile-tab">
            <?= $manual ?>
        </div>
    </div>

</main>