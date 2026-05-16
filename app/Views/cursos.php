<?= $this->extend('layouts/area_logada') ?>

<?= $this->section('content') ?>




    <div class="col-12 col-md-10 order-1 order-md-2" id="miolo_cursos">
      <h3>Meus cursos</h3>

      <div class="row">
        
        <?php
        foreach($cursos as $c) {
          if($c->imagem_curso == null) {
            $img = '/assets/img/curso-sem-imagem.jpg';
          } else {
            $img = '/uploads/'.$c->imagem_curso;
          }
        ?>
        <div class="col-12 col-md-6 col-lg-4 curso">
          <div class="card">
            <img src="<?=base_url($img)?>" class="card-img-top" alt="<?=$c->nome?>">
            <div class="card-body">
              <h5 class="card-title"><?=$c->nome?></h5>
              <p class="card-text"><?=$c->descricao?></p>
              <a href="<?=base_url('/aprender/ir_trilha/'.$c->id.'/'.$c->id_cursante_curso)?>" class="btn btn-primary">Ir para o curso</a>
            </div>
          </div>
        </div>
        <?php
        }
        ?>

      </div>

    </div>
    <!-- fim da div stats -->

  </div>
</div>
<script>
  window.onload = function() {
    carregaForms()
  }
</script>
<?= $this->endSection() ?>