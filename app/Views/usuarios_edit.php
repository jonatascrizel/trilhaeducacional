<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 vh-100">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Usuários > Editar</h1>
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

            <form id="formCadastro" method="post" action="<?= base_url('usuarios/update') ?>" class="mb-5 mt-3">
                <input type="hidden" name="id" id="id" value="<?= $users->id ?>" />

                <div class="alert alert-danger" role="alert">
                    As alterações feitas aqui serão válidas a partir da próxima vez que este usuário fizer login no sistema.
                </div>

                <div class="mb-3">
                    <label for="user_name" class="form-label">Nome e sobrenome:</label>
                    <input type="text" class="form-control" id="user_name" name="user_name" required value="<?= $users->user_name ?>" />
                </div>

                <div class="mb-3">
                    <label for="user_email" class="form-label">E-mail:</label>
                    <input type="email" class="form-control" id="user_email" name="user_email" onblur="validaEmail('user_email')" required value="<?= $users->user_email ?>" />
                </div>

                <div class="mb-3">
                    <label for="telefone" class="form-label">Whatsapp:</label>
                    <input type="text" class="form-control phone_with_ddd" id="telefone" name="telefone" value="<?= $users->telefone ?>" required />
                </div>

                <div class="mb-3 form-check form-switch">
                    <label for="ativo" class="form-label" id="check_ativo">Usuário <span>habilitado</span></label>
                    <input type="checkbox" class="form-check-input" id="ativo" name="ativo" aria-describedby="ativoHelp" value="1" <?php if ($users->ativo == 1) echo 'checked'; ?> onclick="changeStatusUsuario('ativo', 'check_ativo','o')" />
                </div>

                <button type="button" onclick="submitForm('formCadastro')" class="btn btn-personal">Salvar</button>

            </form>

        </div>
        <div class="tab-pane fade" id="manual" role="tabpanel" aria-labelledby="profile-tab">
            <?= $manual ?>
        </div>
    </div>

</main>