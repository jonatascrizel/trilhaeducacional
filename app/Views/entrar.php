<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

    <section id="login">
        <div class="container min-vh-100 d-flex flex-column justify-content-center">
            <div class="row justify-content-md-center">

                <div class="col-12 col-md-6 mx-auto bg-white rounded-3 p-5">
                    <?php if (session()->getFlashdata('msg')) : ?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('msg') ?></div>
                    <?php endif; ?>

                    <?php if (env('CI_ENVIRONMENT') == 'development') { ?>
                    <h1 class="h3 text-center mt-5">Entrar</h1>
                    <form action="<?= base_url('entrar/auth') ?>" method="post" id="formLogin">
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
                    <hr />
                    <?php } else { ?>
                    <a href="<?=base_url('entrar/google')?>" class="btn btn-primary btn-lg mt-3"><i class="fab fa-google"></i> Entrar com Google</a>

                    <p class="mt-3">Não está conseguindo? <a href="https://www.google.com/accounts/Logout" target="_blank">clique aqui</a>.</p>
                    <?php } ?>
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
