<?= $this->extend('layouts/area_logada') ?>

<?= $this->section('content') ?>




    <div class="col-12 col-md-6 order-1 order-md-2" id="miolo_aprender">
      <div id="protecao"></div>
      <div id="cabecalho">
        <p><!--<a href="<?=base_url('aprender/unidades')?>" class=""><i class="fas fa-arrow-left"></i></a> -->Unidade I</p>
        <h4>Assunto da unidade</h4>
      </div>

      <div class="trilha">

      <?php
      foreach($unidades as $u) {
      ?>

        <section class="secao-conteudo" data-unidade="<?=$u->unidade?>" data-unidade-numero="<?=$u->numero?>">
          <div class="separador">
            <hr />
            <h2 class="h4"><?=$u->unidade?></h2>
            <hr />
          </div>

          <?php
          //echo '<pre>'; print_r($licoes); echo $u->id; die; 
          
          if(isset($licoes[$u->id])){
            foreach($licoes[$u->id] as $l) {

              if($l->respondido){
                $class = 'btn-secondary';
                $diss = '';
              } else {
                $class = 'btn-primary';
                $diss = 'disabled';
              }
          ?>
          <div class="point" id="<?=$l->id?>">
            <button type="button" class="btn <?=$class?> btn-round-press" data-bs-toggle="tooltip" data-bs-html="true" title="<?=$l->tipo?>" onclick="ver_card('<?=$l->id?>', '<?=$l->id_cursos_licoes_tipo?>')" <?=$diss?>>
              <i class="<?=$l->icone?>"></i>
            </button>
          </div>
          <?php
            }
          }
          ?>

        </section>

      <?php
      }
      ?>

      </div>


    </div>
    <!-- fim da div miolo_aprender -->

    <div class="col-4 order-3" id="stats">
      <!--
      <div id="divisao">
        <h4>Divisão 1</h4>
        <div class="row">
          <div class="col-4"><i class="fas fa-medal"></i></div>
          <div class="col-8">
            <p><strong>Sua posição 2º<strong></p>
            <p>Muito bem.. mande bala.</p>
          </div>
        </div>
      </div>

      <div id="missoes">
        <h4>Missões do dia</h4>

        <div class="row">
          <div class="col-4">
            <i class="far fa-hand-point-up"></i>
          </div>
          <div class="col-8">
            <h5>Faça X</h5>
            <div class="progress">
              <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%">2/3</div>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-4">
            <i class="far fa-hand-point-up"></i>
          </div>
          <div class="col-8">
            <h5>Faça X</h5>
            <div class="progress">
              <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%">2/3</div>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-4">
            <i class="far fa-hand-point-up"></i>
          </div>
          <div class="col-8">
            <h5>Faça X</h5>
            <div class="progress">
              <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%">2/3</div>
            </div>
          </div>
        </div>
        
      </div>
    -->
    </div>
    <!-- fim da div stats -->

  </div>
</div>

<script>
  window.onload = function() {
    renderizarTrilhaS();
    window.addEventListener('resize', renderizarTrilhaS);

    $('.secao-conteudo').each(function() {
      new IntersectionObserver((entries) => {
          if (entries[0].isIntersecting) {
              $('#cabecalho h4').text($(this).data('unidade'));
              $('#cabecalho p').text('Unidade '+$(this).data('unidade-numero'));
          }
      }, { threshold: 0.2 }).observe(this);
    });

    ultima_licao();
  };


</script>
<?= $this->endSection() ?>