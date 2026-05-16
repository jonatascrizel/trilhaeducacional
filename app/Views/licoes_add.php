<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 vh-100">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Cursos > Unidades > Lições > Adicionar</h1>
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


      <form id="formCadastro" method="post" enctype="multipart/form-data" action="<?= base_url('Licoes/update') ?>" class="mb-5 mt-3">
        <input type="hidden" name="id_cursos_unidades" id="id_cursos_unidades" value="<?=$id_cursos_unidades?>" />

        <div class="mb-3">
          <label for="titulo" class="form-label">Título:</label>
          <input type="text" class="form-control" maxlength="250" id="titulo" name="titulo" value="" required />
        </div>

        <div class="mb-3">
          <label for="ordem" class="form-label">Ordem:</label>
          <input type="text" class="form-control numeros" maxlength="250" id="ordem" name="ordem" value="" required />
        </div>

        <div class="mb-3">
          <label for="id_cursos_licoes_tipo" class="form-label">Tipo:</label>
          <select class="form-select" name="id_cursos_licoes_tipo" id="id_cursos_licoes_tipo" required onchange="troca_tipo_licao(this.value,'add')">
            <option value="" selected disabled>Selecione</option>
            <?php
            foreach($tipos as $t){
            ?>
            <option value="<?=$t->id?>"><?=$t->tipo?></option>
            <?php
            }
            ?>
          </select>
        </div>

        <div class="mb-3 tipo_licao pergunta">
          <label for="pergunta" class="form-label">Pergunta:</label>
          <textarea class="form-control" id="pergunta" name="pergunta"></textarea>
        </div>

        <div class="mb-3 tipo_licao pergunta">
          <label for="resposta1" class="form-label">Resposta 1:</label>
          <input type="text" class="form-control" maxlength="250" id="resposta1" name="resposta1" value="" />
        </div>

        <div class="mb-3 tipo_licao pergunta">
          <label for="resposta2" class="form-label">Resposta 2:</label>
          <input type="text" class="form-control" maxlength="250" id="resposta2" name="resposta2" value="" />
        </div>

        <div class="mb-3 tipo_licao pergunta">
          <label for="resposta3" class="form-label">Resposta 3:</label>
          <input type="text" class="form-control" maxlength="250" id="resposta3" name="resposta3" value="" />
        </div>

        <div class="mb-3 tipo_licao pergunta">
          <label for="resposta4" class="form-label">Resposta 4:</label>
          <input type="text" class="form-control" maxlength="250" id="resposta4" name="resposta4" value="" />
        </div>

        <div class="mb-3 tipo_licao pergunta">
          <label for="resposta5" class="form-label">Resposta 5:</label>
          <input type="text" class="form-control" maxlength="250" id="resposta5" name="resposta5" value="" />
        </div>

        <div class="mb-3 tipo_licao pergunta">
          <label for="resposta_certa" class="form-label">Resposta Correta:</label>
          <select class="form-select" name="resposta_certa" id="resposta_certa">
            <option value="" selected disabled>Selecione</option>
            <?php
            for($i=1; $i<=5; $i++){
            ?>
            <option value="<?=$i?>"><?=$i?></option>
            <?php
            }
            ?>
          </select>
        </div>



        <div class="mb-3 tipo_licao leitura">
          <label for="leitura" class="form-label">Texto adicional:</label>
          <textarea class="form-control" id="leitura" name="leitura"></textarea>
        </div>




        <div class="mb-3 tipo_licao recomedacao">
          <label for="recomendacao_txt" class="form-label">Recomendação:</label>
          <textarea class="form-control" id="recomendacao_txt" name="recomendacao_txt"></textarea>
        </div>

        <div class="mb-3 tipo_licao recomedacao">
            <label for="recomendacao_img" class="form-label">Imagem (1000x667):</label>
            <input class="form-control" type="file" id="recomendacao_img" name="recomendacao_img" />
        </div>


        
        <div class="mb-3 tipo_licao video">
          <label for="video" class="form-label">Embed vídeo:</label>
          <textarea class="form-control" id="video" name="video"></textarea>
        </div>


        <div class="mb-3 tipo_licao pergunta_desc">
          <label for="pergunta_desc" class="form-label">Pergunta:</label>
          <textarea class="form-control" id="pergunta_desc" name="pergunta_desc"></textarea>
        </div>



        <div class="mb-1 tipo_licao cards">
            <label for="card1_img" class="form-label">Imagem (1000x667):</label>
            <input class="form-control" type="file" id="card1_img" name="card1_img" />
        </div>
        <div class="mb-3 tipo_licao cards">
          <label for="card1_alt" class="form-label">Descrição da imagem:</label>
          <input type="text" class="form-control" id="card1_alt" name="card1_alt" maxlength="250" value="" />
        </div>

        <div class="mb-1 tipo_licao cards">
            <label for="card2_img" class="form-label">Imagem (1000x667):</label>
            <input class="form-control" type="file" id="card2_img" name="card2_img" />
        </div>
        <div class="mb-3 tipo_licao cards">
          <label for="card2_alt" class="form-label">Descrição da imagem:</label>
          <input type="text" class="form-control" id="card2_alt" name="card2_alt" maxlength="250" value="" />
        </div>

        <div class="mb-1 tipo_licao cards">
            <label for="card3_img" class="form-label">Imagem (1000x667):</label>
            <input class="form-control" type="file" id="card3_img" name="card3_img" />
        </div>
        <div class="mb-3 tipo_licao cards">
          <label for="card3_alt" class="form-label">Descrição da imagem:</label>
          <input type="text" class="form-control" id="card3_alt" name="card3_alt" maxlength="250" value="" />
        </div>

        <div class="mb-1 tipo_licao cards">
            <label for="card4_img" class="form-label">Imagem (1000x667):</label>
            <input class="form-control" type="file" id="card4_img" name="card4_img" />
        </div>
        <div class="mb-3 tipo_licao cards">
          <label for="card4_alt" class="form-label">Descrição da imagem:</label>
          <input type="text" class="form-control" id="card4_alt" name="card4_alt" maxlength="250" value="" />
        </div>

        <div class="mb-1 tipo_licao cards">
            <label for="card5_img" class="form-label">Imagem (1000x667):</label>
            <input class="form-control" type="file" id="card5_img" name="card5_img" />
        </div>
        <div class="mb-3 tipo_licao cards">
          <label for="card5_alt" class="form-label">Descrição da imagem:</label>
          <input type="text" class="form-control" id="card5_alt" name="card5_alt" maxlength="250" value="" />
        </div>

        <div class="mb-1 tipo_licao cards">
            <label for="card6_img" class="form-label">Imagem (1000x667):</label>
            <input class="form-control" type="file" id="card6_img" name="card6_img" />
        </div>
        <div class="mb-3 tipo_licao cards">
          <label for="card6_alt" class="form-label">Descrição da imagem:</label>
          <input type="text" class="form-control" id="card6_alt" name="card6_alt" maxlength="250" value="" />
        </div>


        <div class="row ordenacao tipo_licao mb-3">
          <div class="mb-3 col-12">
            <label for="enunciado" class="form-label">Enunciado:</label>
            <textarea class="form-control" id="enunciado" name="enunciado"></textarea>
          </div>

          <div class="col-12 col-md-6">
            <h5 class="d-block">Coluna A</h5>
            <div class="mb-1">
              <label for="colA1" class="form-label">Item 1</label>
              <input type="text" class="form-control" id="colA1" name="colA1" maxlength="250" value="" />
            </div>
            <div class="mb-1">
              <label for="colA2" class="form-label">Item 2</label>
              <input type="text" class="form-control" id="colA2" name="colA2" maxlength="250" value="" />
            </div>
            <div class="mb-1">
              <label for="colA3" class="form-label">Item 3</label>
              <input type="text" class="form-control" id="colA3" name="colA3" maxlength="250" value="" />
            </div>
            <div class="mb-1">
              <label for="colA4" class="form-label">Item 4</label>
              <input type="text" class="form-control" id="colA4" name="colA4" maxlength="250" value="" />
            </div>
            <div class="mb-1">
              <label for="colA5" class="form-label">Item 5</label>
              <input type="text" class="form-control" id="colA5" name="colA5" maxlength="250" value="" />
            </div>
          </div>

          <div class="col-12 col-md-6">
            <h5 class="d-block">Coluna B</h5>
            <div class="mb-1">
              <label for="colB1" class="form-label">Item 1</label>
              <input type="text" class="form-control" id="colB1" name="colB1" maxlength="250" value="" />
            </div>
            <div class="mb-1">
              <label for="colB2" class="form-label">Item 2</label>
              <input type="text" class="form-control" id="colB2" name="colB2" maxlength="250" value="" />
            </div>
            <div class="mb-1">
              <label for="colB3" class="form-label">Item 3</label>
              <input type="text" class="form-control" id="colB3" name="colB3" maxlength="250" value="" />
            </div>
            <div class="mb-1">
              <label for="colB4" class="form-label">Item 4</label>
              <input type="text" class="form-control" id="colB4" name="colB4" maxlength="250" value="" />
            </div>
            <div class="mb-1">
              <label for="colB5" class="form-label">Item 5</label>
              <input type="text" class="form-control" id="colB5" name="colB5" maxlength="250" value="" />
            </div>
          </div>

        </div>


        <div class="mb-3 tipo_licao vouf_label">
          <label for="vouf_pergunta" class="form-label">Pergunta:</label>
          <textarea class="form-control" id="vouf_pergunta" name="vouf_pergunta"></textarea>
        </div>

        <div class="mb-3 tipo_licao vouf_label">
          <input type="radio" class="btn-check" name="vouf" id="vouf_v" autocomplete="off" value="V" />
          <label class="btn btn-outline-success" for="vouf_v">Verdadeiro</label>

          <input type="radio" class="btn-check" name="vouf" id="vouf_f" autocomplete="off" value="F" />
          <label class="btn btn-outline-danger" for="vouf_f">Falso</label>
        </div>



        <button type="button" onclick="submitForm('formCadastro')" class="btn btn-personal">Salvar</button>

      </form>

    </div>
    <div class="tab-pane fade" id="manual" role="tabpanel" aria-labelledby="profile-tab">
      <?= $manual ?>
    </div>
  </div>

</main>
<script>
  window.onload = function() {
    ckeditor("recomendacao_txt");
    ckeditor("leitura");
    reset_tipo_licao();
  }
</script>

<?= $this->endSection() ?>