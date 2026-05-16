<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 vh-100">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Banners > Adicionar</h1>
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


            <form id="formCadastro" method="post" action="<?= base_url('banners/store') ?>" enctype="multipart/form-data" class="mb-5 mt-3">

                <div class="mb-3">
                    <label for="nome" class="form-label">Nome:</label>
                    <input type="text" class="form-control" id="nome" name="nome" required />
                </div>

                <div class="mb-3">
                    <label for="titulo" class="form-label">Título:</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" />
                </div>

                <div class="mb-3">
                    <label for="frase_apoio" class="form-label">Frase de apoio:</label>
                    <input type="text" class="form-control" id="frase_apoio" name="frase_apoio" />
                </div>

                <div class="mb-3">
                    <label for="link" class="form-label">Link:</label>
                    <input type="text" class="form-control" id="link" name="link" />
                </div>

                <div class="mb-3">
                    <label for="imagem" class="form-label">Imagem (1000x667):</label>
                    <input class="form-control" type="file" id="imagem" name="imagem" required />
                </div>

                <button type="button" onclick="submitForm('formCadastro')" class="btn btn-personal">Salvar</button>

            </form>

        </div>
        <div class="tab-pane fade" id="manual" role="tabpanel" aria-labelledby="profile-tab">
            <?= $manual ?>
        </div>
    </div>

</main>