<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 vh-100">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Cursos > Unidades > Lições > Editar</h1>
  </div>
  <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?=base_url('cursos/edit/'.$breadcumb->id_curso)?>">Voltar ao curso <?=$breadcumb->curso?></a></li>
      <li class="breadcrumb-item" aria-current="page"><a href="<?=base_url('unidades/edit/'.$breadcumb->id_unidade)?>">Voltar a unidade <?=$breadcumb->unidade?></a></li>
      <li class="breadcrumb-item active" aria-current="page">Lição</li>
    </ol>
  </nav>

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
        <input type="hidden" name="id" id="id" value="<?=$id?>" />
        <input type="hidden" name="id_conteudo" id="id_conteudo" value="<?=$conteudo->id?>" />
        <input type="hidden" name="id_cursos_unidades" id="id_cursos_unidades" value="<?=$txt->id_cursos_unidades?>" />

        <div class="mb-3">
          <label for="titulo" class="form-label">Título:</label>
          <input type="text" class="form-control" maxlength="250" id="titulo" name="titulo" value="<?=$txt->titulo?>" required />
        </div>

        <div class="mb-3">
          <label for="ordem" class="form-label">Ordem:</label>
          <input type="text" class="form-control numeros" maxlength="250" id="ordem" name="ordem" value="<?=$txt->ordem?>" required />
        </div>

        <div class="mb-3">
          <label for="id_cursos_licoes_tipo" class="form-label">Tipo:</label>
          <select class="form-select" name="id_cursos_licoes_tipo" id="id_cursos_licoes_tipo" required onchange="troca_tipo_licao(this.value,'edit')" readonly>
            <option value="" selected disabled>Selecione</option>
            <?php
            foreach($tipos as $t){
            ?>
            <option value="<?=$t->id?>" <?php if($t->id == $txt->id_cursos_licoes_tipo) echo 'selected'; ?>><?=$t->tipo?></option>
            <?php
            }
            ?>
          </select>
        </div>

        <?php if($txt->id_cursos_licoes_tipo == 1) { ?>

        <div class="mb-3 tipo_licao pergunta">
          <label for="pergunta" class="form-label">Pergunta:</label>
          <textarea class="form-control" id="pergunta" name="pergunta"><?=$conteudo->pergunta?></textarea>
        </div>

        <div class="mb-3 tipo_licao pergunta">
          <label for="resposta1" class="form-label">Resposta 1:</label>
          <input type="text" class="form-control" maxlength="250" id="resposta1" name="resposta1" value="<?=$conteudo->resposta1?>" />
        </div>

        <div class="mb-3 tipo_licao pergunta">
          <label for="resposta2" class="form-label">Resposta 2:</label>
          <input type="text" class="form-control" maxlength="250" id="resposta2" name="resposta2" value="<?=$conteudo->resposta2?>" />
        </div>

        <div class="mb-3 tipo_licao pergunta">
          <label for="resposta3" class="form-label">Resposta 3:</label>
          <input type="text" class="form-control" maxlength="250" id="resposta3" name="resposta3" value="<?=$conteudo->resposta3?>" />
        </div>

        <div class="mb-3 tipo_licao pergunta">
          <label for="resposta4" class="form-label">Resposta 4:</label>
          <input type="text" class="form-control" maxlength="250" id="resposta4" name="resposta4" value="<?=$conteudo->resposta4?>" />
        </div>

        <div class="mb-3 tipo_licao pergunta">
          <label for="resposta5" class="form-label">Resposta 5:</label>
          <input type="text" class="form-control" maxlength="250" id="resposta5" name="resposta5" value="<?=$conteudo->resposta5?>" />
        </div>

        <div class="mb-3 tipo_licao pergunta">
          <label for="resposta_certa" class="form-label">Resposta Correta:</label>
          <select class="form-select" name="resposta_certa" id="resposta_certa">
            <option value="" selected disabled>Selecione</option>
            <?php
            for($i=1; $i<=5; $i++){
            ?>
            <option value="<?=$i?>" <?php if($i == $conteudo->resposta_certa) echo 'selected'; ?>><?=$i?></option>
            <?php
            }
            ?>
          </select>
        </div>

        <?php } elseif($txt->id_cursos_licoes_tipo == 2) { ?>


        <div class="mb-3 tipo_licao leitura">
          <label for="leitura" class="form-label">Texto adicional:</label>
          <textarea class="form-control" id="leitura" name="leitura"><?=$conteudo->leitura?></textarea>
        </div>


        <?php } elseif($txt->id_cursos_licoes_tipo == 3) { ?>

        <div class="mb-3 tipo_licao recomedacao">
          <label for="recomendacao_txt" class="form-label">Recomendação:</label>
          <textarea class="form-control" id="recomendacao_txt" name="recomendacao_txt"><?=$conteudo->recomendacao_txt?></textarea>
        </div>

        <div class="mb-3 tipo_licao recomedacao">
            <label for="recomendacao_img" class="form-label">Imagem (1000x667):</label>
            <input class="form-control" type="file" id="recomendacao_img" name="recomendacao_img" />
            <input type="hidden" name="recomendacao_imgOld" id="recomendacao_imgOld" value="<?=$conteudo->recomendacao_img?>" />
            <a href="<?=base_url('uploads/'.$conteudo->recomendacao_img)?>" target="_blank" class="" >Ver imagem atual</a>
        </div>

        <?php } elseif($txt->id_cursos_licoes_tipo == 4) { ?>
        
        <div class="mb-3 tipo_licao video">
          <label for="video" class="form-label">Embed vídeo:</label>
          <textarea class="form-control" id="video" name="video"><?=$conteudo->video?></textarea>
        </div>



        <?php } elseif($txt->id_cursos_licoes_tipo == 5) { ?>


        <div class="mb-3 tipo_licao pergunta_desc">
          <label for="pergunta_desc" class="form-label">Pergunta:</label>
          <textarea class="form-control" id="pergunta_desc" name="pergunta_desc"<?=$conteudo->pergunta_desc?>></textarea>
        </div>

        <?php } elseif($txt->id_cursos_licoes_tipo == 6) { ?>


        <div class="mb-1 tipo_licao cards">
            <label for="card1_img" class="form-label">Imagem (1000x667):</label>
            <input class="form-control" type="file" id="card1_img" name="card1_img" />
            <input type="hidden" name="card1_imgOLD" id="card1_imgOLD" value="<?=$conteudo->card1_img?>" />
            <a href="<?=base_url('uploads/'.$conteudo->card1_img)?>" target="_blank" class="" >Ver imagem atual</a>
        </div>
        <div class="mb-3 tipo_licao cards">
          <label for="card1_alt" class="form-label">Descrição da imagem:</label>
          <input type="text" class="form-control" id="card1_alt" name="card1_alt" maxlength="250" value="<?=$conteudo->card1_alt?>" />
        </div>

        <div class="mb-1 tipo_licao cards">
            <label for="card2_img" class="form-label">Imagem (1000x667):</label>
            <input class="form-control" type="file" id="card2_img" name="card2_img" />
            <input type="hidden" name="card2_imgOLD" id="card2_imgOLD" value="<?=$conteudo->card2_img?>" />
            <a href="<?=base_url('uploads/'.$conteudo->card2_img)?>" target="_blank" class="" >Ver imagem atual</a>
        </div>
        <div class="mb-3 tipo_licao cards">
          <label for="card2_alt" class="form-label">Descrição da imagem:</label>
          <input type="text" class="form-control" id="card2_alt" name="card2_alt" maxlength="250" value="<?=$conteudo->card2_alt?>" />
        </div>

        <div class="mb-1 tipo_licao cards">
            <label for="card3_img" class="form-label">Imagem (1000x667):</label>
            <input class="form-control" type="file" id="card3_img" name="card3_img" />
            <input type="hidden" name="card3_imgOLD" id="card3_imgOLD" value="<?=$conteudo->card3_img?>" />
            <a href="<?=base_url('uploads/'.$conteudo->card3_img)?>" target="_blank" class="" >Ver imagem atual</a>
        </div>
        <div class="mb-3 tipo_licao cards">
          <label for="card3_alt" class="form-label">Descrição da imagem:</label>
          <input type="text" class="form-control" id="card3_alt" name="card3_alt" maxlength="250" value="<?=$conteudo->card3_alt?>" />
        </div>

        <div class="mb-1 tipo_licao cards">
            <label for="card4_img" class="form-label">Imagem (1000x667):</label>
            <input class="form-control" type="file" id="card4_img" name="card4_img" />
            <input type="hidden" name="card4_imgOLD" id="card4_imgOLD" value="<?=$conteudo->card4_img?>" />
            <a href="<?=base_url('uploads/'.$conteudo->card4_img)?>" target="_blank" class="" >Ver imagem atual</a>
        </div>
        <div class="mb-3 tipo_licao cards">
          <label for="card4_alt" class="form-label">Descrição da imagem:</label>
          <input type="text" class="form-control" id="card4_alt" name="card4_alt" maxlength="250" value="<?=$conteudo->card4_alt?>" />
        </div>

        <div class="mb-1 tipo_licao cards">
            <label for="card5_img" class="form-label">Imagem (1000x667):</label>
            <input class="form-control" type="file" id="card5_img" name="card5_img" />
            <input type="hidden" name="card5_imgOLD" id="card5_imgOLD" value="<?=$conteudo->card5_img?>" />
            <a href="<?=base_url('uploads/'.$conteudo->card5_img)?>" target="_blank" class="" >Ver imagem atual</a>
        </div>
        <div class="mb-3 tipo_licao cards">
          <label for="card5_alt" class="form-label">Descrição da imagem:</label>
          <input type="text" class="form-control" id="card5_alt" name="card5_alt" maxlength="250" value="<?=$conteudo->card5_alt?>" />
        </div>

        <div class="mb-1 tipo_licao cards">
            <label for="card6_img" class="form-label">Imagem (1000x667):</label>
            <input class="form-control" type="file" id="card6_img" name="card6_img" />
            <input type="hidden" name="card6_imgOLD" id="card6_imgOLD" value="<?=$conteudo->card6_img?>" />
            <a href="<?=base_url('uploads/'.$conteudo->card6_img)?>" target="_blank" class="" >Ver imagem atual</a>
        </div>
        <div class="mb-3 tipo_licao cards">
          <label for="card6_alt" class="form-label">Descrição da imagem:</label>
          <input type="text" class="form-control" id="card6_alt" name="card6_alt" maxlength="250" value="<?=$conteudo->card6_alt?>" />
        </div>


        <?php } elseif($txt->id_cursos_licoes_tipo == 7) { ?>

        <div class="row ordenacao tipo_licao mb-3">
          <div class="mb-3 col-12">
            <label for="enunciado" class="form-label">Enunciado:</label>
            <textarea class="form-control" id="enunciado" name="enunciado"><?=$conteudo->enunciado?></textarea>
          </div>

          <div class="col-12 col-md-6">
            <h5 class="d-block">Coluna A</h5>
            <div class="mb-1">
              <label for="colA1" class="form-label">Item 1</label>
              <input type="text" class="form-control" id="colA1" name="colA1" maxlength="250" value="<?=$conteudo->colA1?>" />
            </div>
            <div class="mb-1">
              <label for="colA2" class="form-label">Item 2</label>
              <input type="text" class="form-control" id="colA2" name="colA2" maxlength="250" value="<?=$conteudo->colA2?>" />
            </div>
            <div class="mb-1">
              <label for="colA3" class="form-label">Item 3</label>
              <input type="text" class="form-control" id="colA3" name="colA3" maxlength="250" value="<?=$conteudo->colA3?>" />
            </div>
            <div class="mb-1">
              <label for="colA4" class="form-label">Item 4</label>
              <input type="text" class="form-control" id="colA4" name="colA4" maxlength="250" value="<?=$conteudo->colA4?>" />
            </div>
            <div class="mb-1">
              <label for="colA5" class="form-label">Item 5</label>
              <input type="text" class="form-control" id="colA5" name="colA5" maxlength="250" value="<?=$conteudo->colA5?>" />
            </div>
          </div>

          <div class="col-12 col-md-6">
            <h5 class="d-block">Coluna B</h5>
            <div class="mb-1">
              <label for="colB1" class="form-label">Item 1</label>
              <input type="text" class="form-control" id="colB1" name="colB1" maxlength="250" value="<?=$conteudo->colB1?>" />
            </div>
            <div class="mb-1">
              <label for="colB2" class="form-label">Item 2</label>
              <input type="text" class="form-control" id="colB2" name="colB2" maxlength="250" value="<?=$conteudo->colB2?>" />
            </div>
            <div class="mb-1">
              <label for="colB3" class="form-label">Item 3</label>
              <input type="text" class="form-control" id="colB3" name="colB3" maxlength="250" value="<?=$conteudo->colB3?>" />
            </div>
            <div class="mb-1">
              <label for="colB4" class="form-label">Item 4</label>
              <input type="text" class="form-control" id="colB4" name="colB4" maxlength="250" value="<?=$conteudo->colB4?>" />
            </div>
            <div class="mb-1">
              <label for="colB5" class="form-label">Item 5</label>
              <input type="text" class="form-control" id="colB5" name="colB5" maxlength="250" value="<?=$conteudo->colB5?>" />
            </div>
          </div>

        </div>

        <?php } elseif($txt->id_cursos_licoes_tipo == 8) { ?>

        <div class="mb-3 tipo_licao vouf_label">
          <label for="vouf_pergunta" class="form-label">Pergunta:</label>
          <textarea class="form-control" id="vouf_pergunta" name="vouf_pergunta"><?=$conteudo->vouf_pergunta?></textarea>
        </div>

        <div class="mb-3 tipo_licao vouf_label">
          <input type="radio" class="btn-check" name="vouf" id="vouf_v" autocomplete="off" value="V" <?php if($conteudo->vouf == 'V') echo 'checked';?> />
          <label class="btn btn-outline-success" for="vouf_v">Verdadeiro</label>

          <input type="radio" class="btn-check" name="vouf" id="vouf_f" autocomplete="off" value="F" <?php if($conteudo->vouf == 'F') echo 'checked';?> />
          <label class="btn btn-outline-danger" for="vouf_f">Falso</label>
        </div>
        
        <?php } ?>


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
    troca_tipo_licao(<?=$txt->id_cursos_licoes_tipo?>,'edit')
  }
</script>

<?= $this->endSection() ?>