<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<body>

    <section id="login">
        <div class="container">
            <div class="row justify-content-md-center">

                <div class="col-12 col-md-6 mx-auto bg-white rounded-3 p-5">
                    <div class="text-center">
                        <img src="<?= base_url('assets/img/logo.png') ?>" class="w-75" alt="<?= session()->get('SEO_title') ?> ADM" />
                        <span class="d-block"><?= session()->get('SEO_description') ?></span>
                        <span class="d-block mt-3"><?= session()->get('endereco') ?></span>
                        <span class="d-block">Fone: <?= session()->get('telefone') ?></span>
                        <span class="d-block"><?= session()->get('emlContato') ?></span>
                    </div>
                    <h1 class="h3 text-center mt-5">Acesso à área administrativa</h1>
                    <?php if (session()->getFlashdata('msg')) : ?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('msg') ?></div>
                    <?php endif; ?>
                    <form action="<?= base_url('login/auth') ?>" method="post" id="formLogin">
                        <div class="mb-3">
                            <label for="InputForEmail" class="form-label">E-mail:</label>
                            <input type="email" name="InputForEmail" class="form-control" id="InputForEmail" value="<?= set_value('email') ?>" required />
                        </div>
                        <div class="mb-3">
                            <label for="InputForPassword" class="form-label">Senha:</label>
                            <div class="input-group">
                                <input type="password" name="InputForPassword" class="form-control" id="InputForPassword" required />
                                <span class="input-group-text p-0" id="basic-addon1"><button type="button" class="btn" id="btn_pws_confirma" onclick="verPws('InputForPassword')" title="Exibe/oculta a senha"><i class="far fa-eye"></i></button></span>
                            </div>
                        </div>
                        <input type="hidden" class="g-recaptcha" id="g-recaptcha-response" name="g-recaptcha-response" value="" />
                        <button type="button" class="btn btn-primary me-2 mb-2" onclick="submitForm('formLogin')" disabled>Entrar</button>
                        <button type="button" class="btn btn-outline-danger me-2 mb-2" onclick="resetForm('formLogin')">Limpar</button>
                        <a class="btn btn-outline-warning mb-2" onclick="esqueciSenha()">Esqueci a senha</a>
                    </form>
                </div>

            </div>
        </div>
    </section>


    <script>
        const caminho = "<?= base_url() ?>";
        let reCaptchaKey = "<?= $reCaptchaKey ?>";
        window.onload = function() {
            carregaForms();
        }
    </script>
    <?= $this->endSection() ?>
