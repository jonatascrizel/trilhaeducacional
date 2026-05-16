<?= $this->extend('layouts/area_logada') ?>

<?= $this->section('content') ?>




    <div class="col-6" id="miolo_unidades">
      <div id="protecao"></div>
      <div id="cabecalho">
        <h4><a href="<?=base_url('aprender/trilha')?>" class=""><i class="fas fa-arrow-left"></i> Voltar</a></h4>
      </div>

      <div class="unidade">
        <h4>Unidade X</h4>
        <h3>Nome da unidade</h3>

        <div class="progress">
          <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
          <i class="fas fa-trophy"></i>
        </div>
      </div>
      <!-- fim da div unidade -->

      <div class="unidade">
        <h4>Unidade X</h4>
        <h3>Nome da unidade</h3>

        <div class="progress">
          <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
          <i class="fas fa-trophy"></i>
        </div>
      </div>
      <!-- fim da div unidade -->


    </div>
    <!-- fim da div miolo_unidades -->

    <div class="col-4" id="stats">
    </div>
    <!-- fim da div stats -->

  </div>
</div>

<script>
  window.onload = function() {
  };


</script>
<?= $this->endSection() ?>