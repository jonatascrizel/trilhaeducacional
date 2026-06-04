$(document).ready(function() {
  // rolagem suave
  $('a[href^="#"]').on('click', function (e) {
    e.preventDefault();
    var id = $(this).attr('href'),
      targetOffset = $(id).offset().top;

    $('html, body').animate({
      scrollTop: targetOffset - 100
    }, 1000);
  });

  // exibe o botão subir
  $(window).scroll(function () {
    var windowTop = $(window).scrollTop();
    var windowHeight = $(window).innerHeight();
    
    if (windowTop > windowHeight) {
      $("#subir").show();
    } else {
      $("#subir").hide();
    }
  });

  //aciona os tooltips
  $('[title]').tooltip();

  marca_menu();

  $.validator.setDefaults({
    debug: false,//impede de enviar caso for true
    errorElement: "em",
    errorPlacement: function (error, element) {
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass("is-invalid");//.removeClass( "is-valid" );
      $(element).parents('.form-group').addClass("text-danger");
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass("is-invalid");//.addClass( "is-valid" )
      $(element).parents('.form-group').removeClass("text-danger");
    },
    ignore: ':disabled, [type="search"]',
  });

});

function maskAll() {
  $('.date').mask('00/00/0000');
  $('.phone_with_ddd').mask('(00) #0000-0000');
  $('.whatsapp').mask('(00) 0 0000-0000');
  $('.cep').mask('00000-000');
  $('.money2').mask("#.###.##0,00", { reverse: true });
  $('.peso').mask("#0.000", { reverse: true });
  $('.taxa').mask("0.0000", { reverse: true });
  $('.taxa_comma').mask("0,0000", { reverse: true });
  $('.percentual').mask("000,00", {
    reverse: true,
    onKeyPress: function (val, e, field, options) {
      if (val.replace(',', '.') > 100.0) {
        console.log(field.prop('name') + ' excedeu o valor máximo de 100,00!');
        field.val('100,00');
      }
    }
  });
  $('.docCNPJ').mask('00.000.000/0000-00', { reverse: true });
  $('.cpf').mask('000.000.000-00', { reverse: true });
  $('.numeros').mask('#############0');
  $('.hora').mask("00:00", { reverse: true });
  $('.cpfcnpj').focusout(function () {
    var aux, element;
    element = $(this);
    element.unmask();
    aux = element.val().replace(/\D/g, '');

    if (aux.length > 11)
      element.mask("99.999.999/9999-99");
    else
      element.mask("999.999.999-99?999");
  }).focus(function () {
    var element;
    element = $(this);
    element.unmask();
  });
}

function carregaForms() {
  //$.getScript('https://www.google.com/recaptcha/api.js?hl=pt-BR&onload=onloadCallback&render=explicit');
  $.getScript('https://www.google.com/recaptcha/enterprise.js?render='+reCaptchaKey);
  $.getScript(caminho + '/assets/js/jquery.mask.js', function () {
    maskAll();
  });
  onloadCallback();
  console.log('carregado');
}

function resetForm(idElemento) {
  Swal.fire({
    icon: 'info',
    title: 'Deseja mesmo limpar todos dados do formulário?',
    text: '',
    showCancelButton: true,
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Apagar tudo',
    confirmButtonColor: '#d33',
    reverseButtons: true
  }).then((result) => {
    if (result.isConfirmed) {
      $("#" + idElemento).trigger('reset');
    }
  })
}

function onloadCallback() {
  $('form button[type="button"]').removeAttr("disabled");
}

async function submitForm(idForm) {
  if ($("#" + idForm).valid()) {
    //pede pro usuario aguardar
    waitingDialog.show('Aguarde, processando', {
      dialogSize: 'lg',
      progressType: 'info'
    });

    //busca toke do captcha do google
    try {
      const token = await grecaptcha.enterprise.execute(reCaptchaKey, {
        action: 'LOGIN'
      });
      $('#g-recaptcha-response').val(token);

      $('#' + idForm).submit();

    } catch (error) {
      console.error("Erro ao obter token do reCAPTCHA:", error);
      Swal.fire('Erro', 'Falha na verificação de segurança.', 'error');
    }

  } else {
    Swal.fire({
      icon: 'error',
      title: 'Verifique os campos em vermelho.',
      text: 'Preencha todos os dados corretamente',
      confirmButtonColor: '#d33'
    });
  }
}

function esqueciSenha() {
  if ($('#InputForEmail').val() == '') {
    Swal.fire({
      icon: 'error',
      title: 'Erro!',
      text: 'Preencha seu e-mail antes!',
      confirmButtonColor: '#d33'
    }).then((result) => {
      $('#InputForEmail').focus();
      return false;
    });
  } else {
    waitingDialog.show('Processando. Por gentileza, aguarde.', { progressType: 'danger' });
    $.redirect(caminho + '/Login/forget', { 'InputForEmail': $('#InputForEmail').val() }, "POST");
  }
}

function verPws(obj) {
  if ($("#" + obj).attr('type') == 'text') {
    $("#" + obj).attr('type', 'password');
    $("#btn_" + obj + ' i').removeClass("fa-eye-slash");
    $("#btn_" + obj + ' i').addClass("fa-eye");
  } else {
    $("#" + obj).attr('type', 'text');
    $("#btn_" + obj + ' i').removeClass("fa-eye");
    $("#btn_" + obj + ' i').addClass("fa-eye-slash");
  }
}


// ##################################################
//            Área logada
// ##################################################

function renderizarTrilhaS() {
    const trilha = document.querySelector('.trilha');
    const itens = trilha.querySelectorAll('.point');
    const total = itens.length;
    if (total === 0) return;

    const amplitude = 120; 
    const frequencia = 1.2;
    let pathD = '';

    // Remove SVG antigo se existir para evitar duplicatas
    const antigo = trilha.querySelector('.trilha-path');
    if (antigo) antigo.remove();

    // Cria o SVG
    const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
    const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
    svg.classList.add('trilha-path');
    
    itens.forEach((item, index) => {
        const fatorAlinhamento = Math.sin((index / (total - 1)) * Math.PI);
        const deslocamento = Math.sin((index / (total - 1)) * Math.PI * 2 * frequencia) * amplitude * fatorAlinhamento;
        
        item.style.left = `${deslocamento}px`;

        // Posição centralizada baseada no offset do item dentro da .trilha
        const x = trilha.offsetWidth / 2 + deslocamento;
        //const y = item.offsetTop + (item.offsetHeight / 2);
        const y = item.getBoundingClientRect().top - trilha.getBoundingClientRect().top + (item.offsetHeight / 2);

        if (index === 0) {
            pathD += `M ${x} ${y}`;
        } else {
            const prevItem = itens[index - 1];
            const prevFator = Math.sin(((index - 1) / (total - 1)) * Math.PI);
            const prevDesloc = Math.sin(((index - 1) / (total - 1)) * Math.PI * 2 * frequencia) * amplitude * prevFator;
            
            const prevX = trilha.offsetWidth / 2 + prevDesloc;
            const prevY = prevItem.offsetTop + (prevItem.offsetHeight / 2);
            
            const cpY = (prevY + y) / 2;
            pathD += ` C ${prevX} ${cpY}, ${x} ${cpY}, ${x} ${y}`;
        }
    });

    path.setAttribute('d', pathD);
    path.setAttribute('stroke', '#004a8d'); // Usando sua var --color-accent
    path.setAttribute('stroke-width', '4');
    path.setAttribute('fill', 'none');
    path.setAttribute('stroke-dasharray', '8, 8');
    path.setAttribute('stroke-linecap', 'round');

    svg.appendChild(path);
    trilha.prepend(svg);

    // Ajusta o tamanho do SVG para o tamanho real da div .trilha
    svg.setAttribute('width', trilha.scrollWidth);
    svg.setAttribute('height', trilha.scrollHeight);
}

function marca_menu() {
  var currentPath = window.location.pathname;
    var bestMatch = null;
    var maxLen = -1;

  $('#menu .nav-link').each(function() {
        var linkHref = $(this).attr('href');
        if (!linkHref || linkHref === '#') return;

        var linkPath = new URL(linkHref, window.location.origin).pathname;

        // Verifica se a URL atual começa com o caminho do link
        if (currentPath.startsWith(linkPath)) {
            // Se o comprimento deste link for maior que o anterior, ele é mais específico
            if (linkPath.length > maxLen) {
                maxLen = linkPath.length;
                bestMatch = $(this);
            }
        }
    });

    // Remove qualquer active existente e aplica apenas ao melhor match
    if (bestMatch) {
        $('#menu .nav-link').removeClass('active');
        bestMatch.addClass('active');
    }
}

function ver_card(id, id_cursos_licoes_tipo) {
  waitingDialog.show('', { progressType: 'danger' });
  $.ajax({
    type: 'post',
    url: '../../../aprender/aCard/' + id,
    success: function (r) {
      waitingDialog.hide();
      $('#jsModalLabel').html('');
      $('#jsModal .modal-body').html(r);
      if(id_cursos_licoes_tipo == 6){
        var myCarousel = document.querySelector('#carouselCards');
        var carousel = new bootstrap.Carousel(myCarousel, {
          ride: 'carousel',
          touch: true
        });
      }
      if(id_cursos_licoes_tipo == 7){
        $("#card_ordenar").sortable({
          cursor: "move",
          axis: "y",
          update: function(event, ui) {
              // Este evento dispara sempre que a ordem muda
              let novaOrdem = $(this).sortable("toArray");
              //console.log("Nova ordem:", novaOrdem);
          }
        });
      }
      $('#jsModal').modal('show');
    },
  });
}

function libera_enviar_resposta(){
  $('#registra_resposta').prop('disabled', false);
}

function verificar_resposta() {
    //pede pro usuario aguardar
    waitingDialog.show('Aguarde, processando', {
      dialogSize: 'lg',
      progressType: 'info'
    });

    $.ajax({
      type: 'post',
      url: '../../../aprender/verificar_resposta',
      data: {
        id_licao: $('#id_licao').val(),
        resposta: $('input[name="resposta"]:checked').val(),
      },
      success: function (r) {
        waitingDialog.hide();

        $("#formCard :input[type=radio], #registra_resposta").prop("disabled", true);

        $("#btn_fechar").removeClass('d-none');

        var rr = $.parseJSON(r);

        if(rr.resposta == 1){
          $('#retorno').html('<div class="alert alert-success mt-3" role="alert">'
                            + 'Sua resposta está correta!'
                            + '</div>');
          $('#task_success')[0].play();
        } else if(rr.resposta == 2) {
          $('#retorno').html('<div class="alert alert-danger mt-3" role="alert">'
                            + rr.msg
                            + '</div>');
          $('#task_error')[0].play();
        }        

        $('#'+$('#id_licao').val()+' button').removeClass('btn-primary').addClass('btn-secondary');

        ultima_licao();
      },
    });
}

function responder_descritiva() {
    if($('#resposta').val() == "") {
      Swal.fire({
        icon: 'error',
        title: 'Preencha sua resposta antes de enviar!',
        text: '',
        showCancelButton: false,
      }).then((result) => {
        $("#resposta").focus('');
      });
    } else {
      //pede pro usuario aguardar
      waitingDialog.show('Aguarde, processando', {
        dialogSize: 'lg',
        progressType: 'info'
      });

      $.ajax({
        type: 'post',
        url: '../../../aprender/verificar_resposta',
        data: {
          id_licao: $('#id_licao').val(),
          resposta: $('#resposta').val(),
        },
        success: function (r) {
          waitingDialog.hide();

          $("#resposta, #registra_resposta").prop("disabled", true);

          $("#btn_fechar").removeClass('d-none');

          $('#retorno').html(r);        

          $('#'+id+' button').removeClass('btn-primary').addClass('btn-secondary');
          $('#task_complete')[0].play();
          ultima_licao();
        },
      });
    }
}

function verificar_ordem() {
    var novaOrdem = $('#card_ordenar li').map(function() {
        return this.id; // Captura o ID de cada <li>
    }).get();

    console.log(novaOrdem);
    //pede pro usuario aguardar
    waitingDialog.show('Aguarde, processando', {
      dialogSize: 'lg',
      progressType: 'info'
    });

    $.ajax({
      type: 'post',
      url: '../../../aprender/verificar_resposta',
      data: {
        id_licao: $('#id_licao').val(),
        resposta: novaOrdem,
      },
      success: function (r) {
        waitingDialog.hide();

        $("#card_ordenar").sortable({
          disabled: true
        });

        $("#registra_resposta").prop("disabled", true);

        $("#btn_fechar").removeClass('d-none');

        var rr = $.parseJSON(r);

        if(rr.resposta == 1){
          $('#retorno').html('<div class="alert alert-success mt-3" role="alert">'
                            + 'Sua resposta está correta!'
                            + '</div>');
          $('#task_success')[0].play();
        } else if(rr.resposta == 2) {
          $('#retorno').html('<div class="alert alert-danger mt-3" role="alert">'
                            + rr.msg
                            + '</div>');
          $('#task_error')[0].play();
        }        

        $('#'+$('#id_licao').val()+' button').removeClass('btn-primary').addClass('btn-secondary');

        ultima_licao();
      },
    });
}


function marcar_concluido(id) {
    //pede pro usuario aguardar
    waitingDialog.show('Aguarde, processando', {
      dialogSize: 'lg',
      progressType: 'info'
    });

    $.ajax({
      type: 'post',
      url: '../../../aprender/verificar_resposta',
      data: {
        id_licao: id,
        resposta: '',
      },
      success: function (r) {
        waitingDialog.hide();

        $('#jsModal').modal('hide');

        $('#'+id+' button').removeClass('btn-primary').addClass('btn-secondary');

        $('#task_complete')[0].play();

        ultima_licao();
      },
    });
}

function ultima_licao(){
  var target = $('.point button:not(.btn-secondary)').first();
  target.prop('disabled', false);
  if (target.length) {
    var targetOffset = target.offset().top;
    $('html, body').animate({
            scrollTop: targetOffset - 150 
        }, 800); // 800ms de duração
  }
}