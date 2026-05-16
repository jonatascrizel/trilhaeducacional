//$(window).on('load', function () {
  $(document).ready(function(){

  let ClassicEditor;
  vlTotalMov = 0;


  montaMenu();
  //dtDefaults
  // buscaAlertas();
  maskAll();
/*
  $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
*/
  $('#getting-started').countdown(gc_maxlifetime, function(event) {
    $(this).html(event.strftime('%H:%M:%S'));
  });

    /*
  $.getScript(caminho + '/assets/js/jquery.mask.js', function () {
    maskAll();
  });
  */
  $('.filtro').hide();

  $.datepicker.setDefaults({
    dateFormat: "dd/mm/yy",
    dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
    dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
    dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
    monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
    monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
    nextText: 'Proximo',
    prevText: 'Anterior',
    autoSize: true,
    beforeShow: function(i) { if ($(i).attr('readonly')) { return false; } }
  });

  $('#dateRangeFrom').datepicker({
    defaultDate: "+1w",
    changeMonth: true,
    numberOfMonths: 3
  })
  .on( "change", function() {
    $('#dateRangeTo').datepicker( "option", "minDate", this.value );
  });

  $('#dateRangeTo').datepicker({
    defaultDate: "+1w",
    changeMonth: true,
    numberOfMonths: 3
  })
  .on( "change", function() {
    $('#dateRangeFrom').datepicker( "option", "maxDate", this.value );
  });


  // validator
  $.validator.setDefaults({
    debug: false,//impede de enviar caso for true
    errorElement: "em",
    ignore: ".ignore",
    errorPlacement: function (error, element) {
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass("is-invalid");//.removeClass( "is-valid" );
      if($(element).hasClass('inFieldset')){
        $(element).parents('fieldset').addClass("text-danger");
      } else if($(element).attr('type') == 'hidden') {
        $('#'+$(element).data('validation')).addClass("is-invalid");
      } else {
        $(element).parents('.form-group').addClass("text-danger");
      }
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass("is-invalid");//.addClass( "is-valid" )
      if($(element).hasClass('inFieldset')){
        $(element).parents('fieldset').removeClass("text-danger");
      } else if($(element).attr('type') == 'hidden') {
        $('#'+$(element).data('validation')).removeClass("is-invalid");
      } else {
        $(element).parents('.form-group').removeClass("text-danger");
      }
    },
    ignore: ':disabled, [type="search"]',
  });


  //validator defaults
  jQuery.validator.addClassRules("min_qtd", {
    required: true,
    min: 1
  });


  brdocs = {
    /**
    * Enum com opções do validador
    * @readonly
    * @enum {number}
    */
    cpfcnpj: { "CPF": 1, "CNPJ": 2, "AMBOS": 3 },

    /**
     * Função que valida CPF e CNPJ de uma só vez.
     * O Documento a ser validado depende apenas da quantidade de dígitos
     * 11 é aceito como CPF, 14 como CNPJ..
     * @param {string} value - Número do CPF ou CNPJ a ser validado.
     * @param {Element} element - Elemento HTML onde o valor se encontra.
     * @param {Object} [params=3] params - pametros do validador definidos 
     *			pelo enum brdocs.cpfcnpj, default assume AMBOS 
     * @returns {boolean} se o documento é válido
     */
    cpfcnpjValidator: function (value, element, params) {
      //params = (typeof params === 'undefined' || (typeof params === 'boolean' && params) ) ? brdocs.cpfcnpj.AMBOS : params;
      value = value.replace(/[^\d]+/g, ''); //Remove todos os cacteres que exceto [0-9]
      var isCNPJ = false;

      if (value.length != 11 && value.length != 14) return false;

      switch (params) {
        case brdocs.cpfcnpj.CPF:
          if (value.length != 11) return false;
          isCNPJ = false;
          break;
        case brdocs.cpfcnpj.CNPJ:
          if (value.length != 14) return false;
          isCNPJ = true;
          break;
        default:
          isCNPJ = (value.length === 14)
          break;
      }

      if (/^(\d)\1+$/.test(value)) return false; //falso se se todos os digitos forem iguais, os digitos verificadores estão corretos, mas o documento não é válido.

      if (brdocs.calculaDigito(value, value.length - 3, isCNPJ) != parseInt(value.charAt(value.length - 2))) return false;
      if (brdocs.calculaDigito(value, value.length - 2, isCNPJ) != parseInt(value.charAt(value.length - 1))) return false;

      return true;
    },
    /**
    * Função que valida 1 dígito verificador, lembrando que
    * esta função não vai checar se o documento tem tamanho 
    * documento está correto, vai apenas calcular o dígito.
    * A única diferença nos algoritimos de CPF e CNPJ é que o 
    * multiplicador deve voltar a 2 quando passar de 9 no caso
    * do cnpj, ao contrário do CPF que multiplicador máximo é 
    * quantidade de caracteres no processo de soma + 2.
    *  
    * @param {string} doc - Número do documento CPF ou CNPJ a ser validado (somente números).
    * @param {number} start [start=doc.length-1] - Indice do char em doc por onde o iteração do cálculo deve iniciar 
    * 	(útil quando a string doc não foi separada previamento dos dígitos verificadores).
    * @param {boolean} [isCNPJ=false] - Se documento deve ser tratado como CPF, se omitido é tratado como falso.
    * @returns {number} valor calculado do digito.
    */
    calculaDigito: function (doc, start, isCNPJ) {
      if (doc.length === 0) return false;

      start = (typeof start === 'undefined') ? doc.length - 1 : start;

      if (start >= doc.length)
        return false;

      if (isNaN(doc))
        return false;

      isCNPJ = (typeof isCNPJ === 'undefined') ? false : isCNPJ;

      var add = 0
      var multi = 2;

      for (i = start; i >= 0; i--) {
        add += parseInt(doc.charAt(i)) * multi++
        if (isCNPJ && multi > 9) multi = 2;
      }
      var resultado = 11 - add % 11;

      return resultado < 9 ? resultado : 0;;
    }
  };
  if (Object.freeze) { Object.freeze(brdocs); }

  jQuery.validator.addMethod("cpfcnpj2", brdocs.cpfcnpjValidator, "Informe um documento válido.");

  jQuery.validator.addMethod("docCNPJ", function (value, element) {

    var numeros, digitos, soma, i, resultado, pos, tamanho, digitos_iguais;
    if (value.length == 0) {
      return false;
    }

    value = value.replace(/\D+/g, '');
    digitos_iguais = 1;

    for (i = 0; i < value.length - 1; i++)
      if (value.charAt(i) != value.charAt(i + 1)) {
        digitos_iguais = 0;
        break;
      }
    if (digitos_iguais)
      return false;

    tamanho = value.length - 2;
    numeros = value.substring(0, tamanho);
    digitos = value.substring(tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
      soma += numeros.charAt(tamanho - i) * pos--;
      if (pos < 2)
        pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(0)) {
      return false;
    }
    tamanho = tamanho + 1;
    numeros = value.substring(0, tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
      soma += numeros.charAt(tamanho - i) * pos--;
      if (pos < 2)
        pos = 9;
    }

    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;

    retorno = (resultado == digitos.charAt(1));

    return this.optional(element) || retorno;
  }, "Informe um CNPJ válido")

  jQuery.validator.addMethod("cpf", function (value, element) {
    value = jQuery.trim(value);

    value = value.replace('.', '');
    value = value.replace('.', '');
    cpf = value.replace('-', '');
    while (cpf.length < 11) cpf = "0" + cpf;
    var expReg = /^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/;
    var a = [];
    var b = new Number;
    var c = 11;
    for (i = 0; i < 11; i++) {
      a[i] = cpf.charAt(i);
      if (i < 9) b += (a[i] * --c);
    }
    if ((x = b % 11) < 2) { a[9] = 0 } else { a[9] = 11 - x }
    b = 0;
    c = 11;
    for (y = 0; y < 10; y++) b += (a[y] * c--);
    if ((x = b % 11) < 2) { a[10] = 0; } else { a[10] = 11 - x; }

    var retorno = true;
    if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10]) || cpf.match(expReg)) retorno = false;

    return this.optional(element) || retorno;

  }, "Informe um CPF válido");

  //Celular
  jQuery.validator.addMethod('celular', function (value, element) {
    value = value.replace("(", "");
    value = value.replace(")", "");
    value = value.replace("-", "");
    value = value.replace(" ", "").trim();
    if (value == '0000000000') {
      return (this.optional(element) || false);
    }
    else if (value == '00000000000') {
      return (this.optional(element) || false);
    }
    if (["00", "01", "02", "03", , "04", , "05", , "06", , "07", , "08", "09", "10"].indexOf(value.substring(0, 2)) != -1) {
      return (this.optional(element) || false);
    }
    if (value.length < 10 || value.length > 11) {
      return (this.optional(element) || false);
    }
    if (["6", "7", "8", "9"].indexOf(value.substring(2, 3)) == -1) {
      return (this.optional(element) || false);
    }
    return (this.optional(element) || true);
  },
    'Informe um celular válido');

  //Telefone fixo
  jQuery.validator.addMethod('telefoneFixo', function (value, element) {
    value = value.replace("(", "");
    value = value.replace(")", "");
    value = value.replace("-", "");
    value = value.replace(" ", "").trim();
    if (value == '0000000000') {
      return (this.optional(element) || false);
    }
    else if (value == '00000000000') {
      return (this.optional(element) || false);
    }
    if (["00", "01", "02", "03", , "04", , "05", , "06", , "07", , "08", "09", "10"].indexOf(value.substring(0, 2)) != -1) {
      return (this.optional(element) || false);
    }
    if (value.length < 10 || value.length > 11) {
      return (this.optional(element) || false);
    }
    if (["1", "2", "3", "4", "5"].indexOf(value.substring(2, 3)) == -1) {
      return (this.optional(element) || false);
    }
    return (this.optional(element) || true);
  },
    'Informe um telefone válido');

  //Telefone generico
  jQuery.validator.addMethod('phone_with_ddd', function (value, element) {
    value = value.replace("(", "");
    value = value.replace(")", "");
    value = value.replace("-", "");
    value = value.replace(" ", "").trim();
    if (value == '0000000000') {
      return (this.optional(element) || false);
    }
    else if (value == '00000000000') {
      return (this.optional(element) || false);
    }
    if (["00", "01", "02", "03", , "04", , "05", , "06", , "07", , "08", "09", "10"].indexOf(value.substring(0, 2)) != -1) {
      return (this.optional(element) || false);
    }
    if (value.length < 10 || value.length > 11) {
      return (this.optional(element) || false);
    }
    return (this.optional(element) || true);
  },
    'Informe um telefone válido');

  //data no formato pt-Br
  $.validator.addMethod("date", function (value, element) {
    var check = false;
    var re = /^\d{1,2}\/\d{1,2}\/\d{4}$/;
    if (re.test(value)) {
      var adata = value.split('/');
      var gg = parseInt(adata[0], 10);
      var mm = parseInt(adata[1], 10);
      var aaaa = parseInt(adata[2], 10);
      var xdata = new Date(aaaa, mm - 1, gg);
      if ((xdata.getFullYear() == aaaa) && (xdata.getMonth() == mm - 1) && (xdata.getDate() == gg))
        check = true;
      else
        check = false;
    }
    else
      check = false;

    return this.optional(element) || check;
  },
    "Insira uma data válida"
  );

  $.validator.addMethod("validarUsuario", function (value, element) {
    return this.optional(element) || /^[a-zA-Z0-9.]+$/.test(value);
  },
    'Informe um usuário válido.'
  );

  $.validator.addMethod("time24", function (value, element) {
    if (!/^\d{2}:\d{2}$/.test(value)) return false;
    var parts = value.split(':');
    if (parts[0] > 23 || parts[1] > 59) return false;
    return true;
  }, "Formato de hora inválido");

  $.validator.addMethod("password", function (value, element) {
    return this.optional(element) || /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,16}$/i.test(value);
  }, "Senhas devem ter entre 8 e 16 caracteres incluindo letras maiúsculas, letras minúsculas e ao menos um número.");
  // FIM Validator

}); // fim onload

function maskAll() {
  $('input,textarea,select').filter('[required]').each(function() {
    if($(this).siblings('label').length == 0) {
      $(this).parent().siblings('label').addClass('label-required');
    } else {
      $(this).siblings('label').addClass('label-required');
    }
  });

  $('.date').datepicker();

  $('.date').mask('00/00/0000');
  $('.phone_with_ddd').mask('(00) #0000-0000');
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
  $('.percentual3').mask("##0,000", {
    reverse: true,
    onKeyPress: function (val, e, field, options) {
      if (val.replace(',', '.') >= 100.001) {
        console.log(field.prop('name') + ' excedeu o valor máximo de 100,000!');
        //field.val('100,000');
      }
    }
  });
  $('.cnpj').mask('00.000.000/0000-00', { reverse: true });
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
    //element.unmask();
  });
}
// funciona semelhante ao number_format do PHP
function formatMoney(number, decPlaces, decSep, thouSep) {
  decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
    decSep = typeof decSep === "undefined" ? "." : decSep;
  thouSep = typeof thouSep === "undefined" ? "" : thouSep;
  var sign = number < 0 ? "-" : "";
  var i = String(parseInt(number = Math.abs(Number(number) || 0).toFixed(decPlaces)));
  var j = (j = i.length) > 3 ? j % 3 : 0;

  return sign +
    (j ? i.substring(0, j) + thouSep : "") +
    i.substring(j).replace(/(\decSep{3})(?=\decSep)/g, "$1" + thouSep) +
    (decPlaces ? decSep + Math.abs(number - i).toFixed(decPlaces).slice(2) : "");
}

function checkAll(tabela){
  if($('#'+tabela+' #selectAll').is(':checked')) {
    $('#'+tabela+' input[type="checkbox"]').prop('checked', true);
  } else {
    $('#'+tabela+' input[type="checkbox"]').prop('checked', false);
  }
}

function submitForm(idForm) {
  if ($("#" + idForm).valid()) {
    //pede pro usuario aguardar
    waitingDialog.show('Aguarde, processando', {
      dialogSize: 'lg',
      progressType: 'info'
    });

    $('#' + idForm).submit();
    /*
    alert('oi - linha 417');
    */
  } else {
    Swal.fire({
      icon: 'error',
      title: 'Verifique os campos em vermelho.',
      text: 'Preencha todos os dados corretamente',
      confirmButtonColor: '#d33'
    });
  }
}

function acionaTooltip() {
  $('[title]').tooltip();
  //console.log('Tooltip inicializado.');
}

function ckeditor(idElemento) {
  ClassicEditor
    .create(document.querySelector('#' + idElemento), {
      ckfinder: {
        uploadUrl: caminho + '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images&responseType=json',
        options: {
          resourceType: 'Images'
        },
      },
    })
    .then(editor => {
      console.log(editor);
    })
    .catch(error => {
      console.error(error);
    });
}

function ver_texto(id) {
  $.ajax({
    type: 'post',
    url: '../../../textos/ver/' + id,
    success: function (r) {
      $('#jsModalLabel').html('Visualização de texto');
      $('#jsModal .modal-body').html(r);
      $('#jsModal').modal('show');
    },
  });
}

function deletar(lnk) {
  Swal.fire({
    icon: 'info',
    title: 'Está certo disto?',
    text: 'Essa operação não possui volta',
    showCancelButton: true,
    cancelButtonText: 'Manter',
    confirmButtonText: 'Continuar',
    confirmButtonColor: '#d33',
    reverseButtons: true
  }).then((result) => {
    if (result.isConfirmed) {
      location.href = lnk;
    }
  })
}

function dtDefaults() {
  $.extend($.fn.dataTable.defaults, {
    "lengthMenu": [[10, 50, 100, 500, -1], [10, 50, 100, 500, "All"]],
    "pageLength": 50,
    "language": {
      "url": "../../../assets/js/datatables.pt_br.json"
    },
    responsive: true,
    rowReorder: {
        selector: 'td:nth-child(2)'
    }
  });
}


function tipoPessoa() {
  if ($('#pessoa').val() == 'F') {
    $('.tipoPessoa input').removeAttr('required');
    $('#cnpj').removeClass('docCNPJ');
    $('.tipoPessoa').hide();
  } else {
    $('.tipoPessoa').css('display', 'block');
    $('#cnpj').addClass('docCNPJ');
    $('.tipoPessoa input').attr('required', true);
  }
}

function buscaCep(campo) {
  if ($('#cep'+campo).val() == '') {
    Swal.fire({
      icon: 'error',
      title: 'Erro!',
      text: 'Informe um CEP!',
      confirmButtonColor: '#d33'
    }).then((result) => {
      $("#cep"+campo).focus();
    });
  } else {
    waitingDialog.show('Processando. Por gentileza, aguarde.', { progressType: 'danger' });
    $.getJSON("https://viacep.com.br/ws/" + $('#cep'+campo).val() + "/json/?callback=?", function (dados) {
      waitingDialog.hide();
      if (!("erro" in dados)) {
                
        $("#estado"+campo+" option").filter(function() {
          return this.text == dados.uf; 
        }).attr('selected', true);
console.log(dados.localidade);
        carrega_cidades('id_cidade'+campo, $('#estado'+campo).val(),'',dados.localidade);
        $("#bairro"+campo).val(dados.bairro);
        $("#rua"+campo).val(dados.logradouro);
        $("#numero"+campo).focus();
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Erro!',
          text: 'Esse CEP não foi encontrado.',
          confirmButtonColor: '#d33'
        }).then((result) => {
          $("#cep"+campo).focus();
        });
      }
    });
  }
}

function carrega_cidades(destino, valor, selecionar, selecionarText, todos) {
  if (valor == '') {
    Swal.fire({
      icon: 'error',
      title: 'Erro!',
      text: 'Selecione um estado antes!',
      confirmButtonColor: '#d33'
    });
    return false;
  } else {
    $.ajax({
      method: "GET",
      url: "../../../../Home/aMontaComboCidades/" + valor + "/null/" + todos,
    })
      .done(function (msg) {
        $('#' + destino).html(msg);

        if (selecionar)
          $('#' + destino).val(selecionar);

        if (selecionarText){
          $("#" + destino+" option").filter(function () { return $(this).html() == selecionarText; }).prop('selected', true);
          //substituído em função de cidade com nome parecidos serem selecionadas errada (Londrina e Nova Londrina no PR, por exemplo)
          //$("#" + destino + " option:contains('" + selecionarText + "')").prop('selected', true);
        }
      });
  }
}

function recuperaEstadoCidade(id_cidade, id_selUF, id_selCid) {
  waitingDialog.show('Processando. Por gentileza, aguarde.', { progressType: 'danger' });
  $.getJSON("../../../../Home/aGetEstado/" + id_cidade, function (dados) {
    $('#' + id_selUF).val(dados);

    carrega_cidades(id_selCid, $('#' + id_selUF).val(), id_cidade)

    waitingDialog.hide();
  });
}

function ver_manual(id) {
  $.ajax({
    type: 'post',
    url: '../../../manuais/ver/' + id,
    success: function (r) {
      $('#jsModalLabel').html('Visualização de manual');
      $('#jsModal .modal-body').html(r);
      $('#jsModal').modal('show');
    },
  });
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

function trocaSenha() {
  console.log($('meter.mtSenha').val());
  if ($('meter.mtSenha').val() < 60) {
    Swal.fire({
      icon: 'error',
      title: 'A senha está muito fraca',
      text: 'Veja as instruções e escolha uma senha forte',
      confirmButtonColor: '#d33'
    });
  } else {
    submitForm('formCadastro');
  }
}

function buscaAlertas() {
  // carrega todos os alertas do usuário logado e mostra os toasts
  $.getJSON(caminho + "/Alertas/aBuscaAlertas")
    .done(function (data) {
      if (data) {
        html = '';
        $.each(data, function (i, item) {
          html += '<div id="toast' + data[i].id + '" class="toast fade align-items-center text-white mb-2 bg-secondary bg-gradient" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">';
          html += '<div class="d-flex">';
          html += '<div class="toast-body">';
          html += '<strong><a href="javascript:ver_alerta(' + data[i].id + ')" > ' + data[i].titulo + '</a ></strong > ';
          html += '</div>';
          html += '<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>';
          html += '</div>';
          html += '</div>';
          html += '</div>';
        });

        $('#toasters').html(html);
        toasts = [];
        $.each(data, function (i, item) {
          toasts[data[i].id] = new bootstrap.Toast($('#toast' + data[i].id));
          toasts[data[i].id].show();
        });

        //console.log("Toasts inseridos");
      } else {
        //console.log("Sem Toasts");
      }
    });
}

function ver_alerta(id) {
  $.ajax({
    type: 'post',
    url: '../../../Alertas/ver/' + id,
    success: function (r) {
      if (typeof toasts[id] != 'undefined') {
        //fecha o toast
        toasts[id].hide();

      }
      //abre o modal
      $('#jsModalLabel').html('Alerta do sistema');
      $('#jsModal .modal-body').html(r);
      $('#jsModal').modal('show');
    },
  });
}

function montaMenu() {
  $.get(caminho + "Usuarios/aGeraMenu")
    .done(function (data) {
      $('#sidebarMenu ul').append(data);
      acionaTooltip();
    });
}

function alertas_quemviu(id) {
  $.ajax({
    type: 'post',
    url: '../../../Alertas/quemViu/' + id,
    success: function (r) {
      //abre o modal
      $('#jsModalLabel').html('Alerta visualizado por:');
      $('#jsModal .modal-body').html(r);
      $('#jsModal').modal('show');
    },
  });
}

function validaEmail(campo){
  $.ajax({
    method: 'post',
    url: '../../../../Usuarios/aCheckEmail',
    data : { email: $("#"+campo).val() },
    headers: {'X-Requested-With': 'XMLHttpRequest'},
    cache: false
  })
    .done(function (msg) {
      if (msg >= 1) {
        Swal.fire({
          icon: 'error',
          title: 'Esse e-mail já está cadastrado',
          text: 'Utilize outro e-mail ou edite o usuário apropriado',
          confirmButtonColor: '#d33'
        });
        $("#"+campo).attr("placeholder", "Email "+$("#"+campo).val()+" ja está cadastrado para outro usuário");
        $("#"+campo).addClass("is-invalid");
        $("#"+campo).val("");
        $("#"+campo).focus();
      } else {
        $("#"+campo).removeClass("is-invalid");
      }
    });
}


function changeStatusUsuario(elemento, alvo, artigo){
  if($("#"+elemento).is(':checked'))
    $("#"+alvo+' span').html('habilitad'+artigo);
  else
    $("#"+alvo+' span').html('desabilitad'+artigo);
}

function filtraUsuarios(elemento, alvo){
  //changeStatusUsuario(elemento, alvo);
  if($("#"+elemento).is(':checked')){
    tabelaPrincipal.column(4).search('1').draw();
    //$("#"+alvo).html('Usuários ativos');
  } else {
    tabelaPrincipal.column(4).search('').draw();
    //$("#"+alvo).html('Todos os usuários');
  }
}



/*
          MÓDULO CURSOS
*/
function ver_unidades(id) {
  waitingDialog.show('', { progressType: 'danger' });
  $.ajax({
    type: 'post',
    url: '../../../unidades/ver/' + id,
    success: function (r) {
      waitingDialog.hide();
      $('#jsModalLabel').html('Lista de Unidades Didáticas');
      $('#jsModal .modal-body').html(r);
      $('#jsModal').modal('show');
    },
  });
}

function ver_inscritos(id) {
  waitingDialog.show('', { progressType: 'danger' });
  $.ajax({
    type: 'post',
    url: '../../../cursantes/ver/' + id,
    success: function (r) {
      waitingDialog.hide();
      $('#jsModalLabel').html('Lista de Inscritos');
      $('#jsModal .modal-body').html(r);
      $('#jsModal').modal('show');
    },
  });
}

function ver_licoes(id) {
  waitingDialog.show('', { progressType: 'danger' });
  $.ajax({
    type: 'post',
    url: '../../../licoes/ver/' + id,
    success: function (r) {
      waitingDialog.hide();
      $('#jsModalLabel').html('Lista de lições');
      $('#jsModal .modal-body').html(r);
      $('#jsModal').modal('show');
    },
  });
}

function ver_card(id) {
  waitingDialog.show('', { progressType: 'danger' });
  $.ajax({
    type: 'post',
    url: '../../../licoes/aCard/' + id,
    success: function (r) {
      waitingDialog.hide();
      $('#jsModalLabel').html('');
      $('#jsModal .modal-body').html(r);
      if(id == 6){
        var myCarousel = document.querySelector('#carouselExampleSlidesOnly')
        var carousel = new bootstrap.Carousel(myCarousel)

      }
      $('#jsModal').modal('show');
    },
  });
}

function troca_tipo_licao(valor,tipo){

  //console.log(valor + ' - ' + tipo);
  reset_tipo_licao();

  if(valor == 1){
    $('#pergunta').prop('required',true);
    $('#resposta1').prop('required',true);
    $('#resposta2').prop('required',true);
    $('#resposta3').prop('required',true);
    $('#resposta4').prop('required',true);
    $('#resposta5').prop('required',true);
    $('.pergunta').show();
  } else if(valor == 2){
    //$('#leitura').prop('required',true);
    $('.leitura').show();
  } else if(valor == 3){
    //$('#recomendacao_txt').prop('required',true);
    if(tipo == 'add'){
      $('#recomendacao_img').prop('required',true);
    }
    $('.recomedacao').show();
  } else if(valor == 4){
    $('#video').prop('required',true);
    $('.video').show();
  } else if(valor == 5){
    $('#pergunta_desc').prop('required',true);
    $('.pergunta_desc').show();
  } else if(valor == 6){
    if(tipo == 'add'){
      $('#card1_img').prop('required',true);
    }
    $('#card1_alt').prop('required',true);
    $('.cards').show();
  } else if(valor == 7){
    $('.ordenacao').show();

    $('.ordenacao input').each(function() {
      $(this).prop('required',true);
    });
  } else if(valor == 8){
    $('.vouf_label').show();

    $('#vouf_pergunta').prop('required',true);
    $('#vouf_v').prop('required',true);
  }
}


function reset_tipo_licao(){
  $('.tipo_licao').hide();

  $('#pergunta').prop('required',false);
  $('#resposta1').prop('required',false);
  $('#resposta2').prop('required',false);
  $('#resposta3').prop('required',false);
  $('#resposta4').prop('required',false);
  $('#resposta5').prop('required',false);

  $('#leitura').prop('required',false);

  $('#recomendacao_txt').prop('required',false);
  $('#recomendacao_img').prop('required',false);

  $('#video').prop('required',false);

  $('#pergunta_desc').prop('required',false);

  $('#card1_img').prop('required',false);
  $('#card1_alt').prop('required',false); 

  $('.ordenacao input').each(function() {
    $(this).prop('required',false);
  })

  $('#vouf_pergunta').prop('required',false);
  $('#vouf_v').prop('required',false);

}

function ver_inscricoes(id) {
  waitingDialog.show('', { progressType: 'danger' });
  $.ajax({
    type: 'post',
    url: '../../../cursantes/aInscricoes/' + id,
    success: function (r) {
      waitingDialog.hide();
      $('#jsModalLabel').html('Inscrições');
      $('#jsModal .modal-body').html(r);
      if(id == 6){
        var myCarousel = document.querySelector('#carouselExampleSlidesOnly')
        var carousel = new bootstrap.Carousel(myCarousel)

      }
      $('#jsModal').modal('show');
    },
  });
}

function cadastra_cursante(valor){
  if(valor == 'ADD'){
    $('#nome').prop('required',true);
    $('#email').prop('required',true);  
    $('.new').show();
  } else {
    $('#nome').prop('required',false);
    $('#email').prop('required',false);  
    $('.new').hide();
  }
}












function ver_cliente(id) {
  $.ajax({
    type: 'post',
    url: '../../../clientes/ver/' + id,
    success: function (r) {
      $('#jsModalLabel').html('Visualização do cliente');
      $('#jsModal .modal-body').html(r);
      $('#jsModal').modal('show');
    },
  });
}


function add_endereco(del, id) {
  waitingDialog.show('Processando. Por gentileza, aguarde.', { progressType: 'danger' });

  if (typeof id == 'undefined')
    id = null;

  $.ajax({
    type: 'post',
    url: '../../../Clientes/aCamposEndereco/' + id,
    success: function (r) {
      $('#enderecos').append(r);
      $('#qtd_enderecos').val(parseInt($('#qtd_enderecos').val()) + 1);
      maskAll();
      acionaTooltip();
      waitingDialog.hide();
    },
  });
}

function remover_endereco(id) {
  $('#endereco_' + id).remove();
  $('#qtd_enderecos').val(parseInt($('#qtd_enderecos').val()) - 1);
  $('#enderecos').append('<input type="hidden" name="remove_endereco[]" value="' + id + '" />');
}

function selectTpFrete(valor){
  if(valor == 3){
    $('.tp_frete_valor').show();
  } else {
    $('.tp_frete_valor').hide();
  }
}

function ver_importador(id) {
  $.ajax({
    type: 'post',
    url: '../../../importadores/ver/' + id,
    success: function (r) {
      $('#jsModalLabel').html('Visualização do pedido');
      $('#jsModal .modal-body').html(r);
      $('#jsModal').modal('show');
    },
  });
}

function add_contato(id) {
  waitingDialog.show('Processando. Por gentileza, aguarde.', { progressType: 'danger' });

  if (typeof id == 'undefined')
    id = null;

  $.ajax({
    type: 'post',
    url: '../../../Importadores/aCamposContato/' + id,
    success: function (r) {
      $('#contatos').append(r);
      maskAll();
      acionaTooltip();
      waitingDialog.hide();
    },
  });
}

function changeTelefone(item){
  if($('#telefone'+item).siblings('span').html() == '<i class="fab fa-whatsapp"></i>'){
    $('#telefone'+item).siblings('span').html('<i class="fas fa-phone-volume"></i>');
    $('#wpp_'+item).val(2);
  } else {
    $('#telefone'+item).siblings('span').html('<i class="fab fa-whatsapp"></i>');
    $('#wpp_'+item).val(1);
  }
}

function troca_contato(id_tipo, local){
  if(id_tipo == 1){
    $('#'+local).removeClass('phone_with_ddd');
  } else {
    $('#'+local).addClass('phone_with_ddd');
    maskAll();
  }
}

function remover_contato(id){
  $('#contato_' + id).remove();
}

function salvarEpedido(){
  $('#pedido').val('1');
  submitForm('formCadastro');
}

function filtraClientes(elemento){
  if($("#"+elemento).is(':checked')){
    tabelaPrincipal.column(6).search('1').draw();
  } else {
    tabelaPrincipal.column(6).search('').draw();
  }
}

function filtraVendedores(elemento){
  if($("#"+elemento).is(':checked')){
    tabelaPrincipal.column(4).search("1").draw();
  } else {
    tabelaPrincipal.column(4).search('').draw();
  }
}


function pedido_selectVendedor(valor){
  waitingDialog.show('Processando. Por gentileza, aguarde.', { progressType: 'danger' });

  $.ajax({
    type: 'post',
    url: '../../../pedidos/aSelectVendedor/' + valor,
    success: function (r) {
      $('#id_cliente_endereco').html(r).removeClass('form-select');

      $('#id_cliente_endereco').selectpicker({
        //iconBase : '',
        liveSearch: true,
        size: '3',
      });
      $('#id_cliente_endereco').selectpicker('refresh');   
      
      waitingDialog.hide();
    },
  });
}

function pedido_selectImportador(valor){
  waitingDialog.show('Processando. Por gentileza, aguarde.', { progressType: 'danger' });

  $.ajax({
    type: 'post',
    url: '../../../pedidos/aSelectImportador/' + valor,
    success: function (r) {
      $('#id_tabela').html(r);
      waitingDialog.hide();
    },
  });
}

function clientesCarteira(){
  if($("#checkClientesCarteira").is(':checked')){
    pedido_selectVendedor($('#id_vendedor').val());
    $('.motivo').hide();
    $('#motivo').prop('required',false);
  } else {
    pedido_selectVendedor('');
    $('.motivo').show();
    $('#motivo').prop('required',true);
    maskAll();
  }
}

function alteraDataPedido(){
  if($("#checkAlteraDataPedido").is(':checked')){
    $('#dt_pedido').attr('readonly',false);
    $('.motivoDT').show();
    $('#motivoDT').prop('required',true);
  } else {
    $('#dt_pedido').attr('readonly',true);
    $('#dt_pedido').val($('#dt_pedido').data('reset'));
    $('.motivoDT').hide();
    $('#motivoDT').prop('required',false);    
  }
  maskAll();
}

function add_produto(novo=false) {
  if(novo != true){
    waitingDialog.show('Processando. Por gentileza, aguarde.', { progressType: 'danger' });
  }
  

  if($('#desconto_').val() != ''){
    $.cookie('PDdesconto', $('#desconto_').val(), { expires: 300, path: '/' });
    $.cookie('PDtp_desconto_', $('#tp_desconto_').val(), { expires: 300, path: '/' });
  }

  $.ajax({
    type: 'post',
    url: '../../../pedidos/aAddProduto',
    data: {
      tp_desconto: $('#tp_desconto_').val(),
      id_pedido: $('#id').val(),
      id_importador: $('#id_importador').val(),
      desconto: $('#desconto_').val(),
      multiplicador: $('#multiplicador').val(),
    },
    success: function (r) {
      $('#jsModalLabel').html('Adicionar produto');
      $('#jsModal .modal-body').html(r);
      $('#jsModal').modal('show');
      autocompleteperson();
      maskAll();
      acionaTooltip();
      waitingDialog.hide();
    },
  });
}

function editar_produto(id) {
  waitingDialog.show('Processando. Por gentileza, aguarde.', { progressType: 'danger' });

  $.ajax({
    type: 'post',
    url: '../../../pedidos/editProduto',
    data: {
      id_produto: id,
    },
    success: function (r) {
      $('#jsModalLabel').html('Adicionar produto');
      $('#jsModal .modal-body').html(r);
      $('#jsModal').modal('show');
      autocompleteperson();
      maskAll();
      acionaTooltip();
      waitingDialog.hide();
    },
  });
}

function salvar_produto(novo){

  if ($("#jsModal .modal-body form").valid()) {
    //pede pro usuario aguardar
    waitingDialog.show('Aguarde, processando', {
      dialogSize: 'lg',
      progressType: 'info'
    });

    //$('#tabelaProdutos #'+$('#id_pedido_produto').val()).remove();

    $.ajax({
      type: 'post',
      url: '../../../pedidos/aSalvaProduto',
      data: $('#jsModal .modal-body form').serialize(),
      success: function (r) {
        $('#jsModal').modal('hide');
        //$('#tabelaProdutos tbody').append(r);
        /*
        */
         
        rtn = JSON.parse(r);
        //console.log(rtn.id);
        //$('#tabelaProdutos #'+rtn.id).remove();
        tabelaProdutos.row('#'+rtn.id).remove().draw();
        tabelaProdutos.row.add([
            parseInt($('#qtd_produtos').val()) + 1,
            rtn.codigo,
            rtn.produto,
            rtn.preco,
            rtn.desconto,
            rtn.preco_tabela,
            rtn.quantidade,
            rtn.total_tabela,
            rtn.total,
            function(){rtn.id
              return '<a href="javascript:editar_produto(\''+rtn.id+'\')" title="Editar produto"><i class="far fa-edit"></i></a> <a href="javascript:remover_produto(\''+rtn.id+'\')" title="Excluir produto"><i class="fas fa-minus-circle"></i></a>';
            }
          ]).draw().node().id = rtn.id;
        //tabelaProdutos.draw();
        //numerar('tabelaProdutos');
        $('#qtd_produtos').val(parseInt($('#qtd_produtos').val()) + 1);
        
        if(novo){
          add_produto(true);
        } else {
          waitingDialog.hide();
        }
      },
    });

  } else {
    Swal.fire({
      icon: 'error',
      title: 'Verifique os campos em vermelho.',
      text: 'Preencha todos os dados corretamente',
      confirmButtonColor: '#d33'
    });
  }


}
/*
não utilizado mais
function calcula_tabela(rand){
  preco = $('#preco'+rand).val().replaceAll('.','').replace(',','.');
  $('#preco_tabela'+rand).val(formatMoney(preco/$('#multiplicador').val(),2,',','.'));
}
*/

function calcula_subtotal(rand){
  preco = $('#preco'+rand).val().replaceAll('.','').replace(',','.');
  if($('#tp_desconto_'+rand).val() == 2){
    preco -= (preco * $('#desconto_'+rand).val().replaceAll('.','').replace(',','.') / 100);
  } else {
    preco -= $('#desconto_'+rand).val().replaceAll('.','').replace(',','.');
  }
  preco = preco*$('#multiplicador').val();
  subtotal = preco * $('#quantidade_'+rand).val();
  $('#subtotal'+rand).val(formatMoney(subtotal,2,',','.'));
  $('#preco_tabela'+rand).val(formatMoney(preco,2,',','.'));
}

function changeDesconto(item){
  if($('#desconto_'+item).siblings('span').html() == 'R$'){
    $('#desconto_'+item).siblings('span').html('%');
    $('#tp_desconto_'+item).val(2);
  } else {
    $('#desconto_'+item).siblings('span').html('R$');
    $('#tp_desconto_'+item).val(1);
  }
}

function autocompleteperson(){
  $('.cod_produto').autocomplete({
    minLength: 3,
    delay: 0,
    source: function( request, response ) { 
      $.ajax({
        url: '../../../pedidos/aAutocompleteCodProduto',
        type: "POST",
        data: {
          term: request.term,
          id_importador: $('#id_importador').val(),
          id_pedido: $('#id').val(),
        },
        dataType: "json",
        success: function (data) {
          response( $.map( data, function( item ) {
            return {label: item.codigo, obj: item} }));
        }
      });
    },
    select: function( event, ui ) {
      var id = $(this).attr('id').slice(11);

      $( "#id_produto"+id ).val( ui.item.obj.id_produto );
      $( "#produto"+id ).val( ui.item.obj.produto ).prop('readonly',true);
      $( "#id_embalagem"+id ).val( ui.item.obj.id_embalagem );
      $( "#id_embalagem"+id+" option:not(:selected)").attr('disabled', true);
      $( "#preco"+id ).val( formatMoney(ui.item.obj.preco,2,',','.') );
      $( "#ped_min"+id ).val( ui.item.obj.ped_min ).prop('readonly',true);
      $( "#preco_tabela"+id ).val( formatMoney(ui.item.obj.preco/$("#multiplicador").val(),2,',','.'));

      calcula_subtotal(id);
    }  
  });
}

function remover_produto(id){
  Swal.fire({
    icon: 'info',
    title: 'Está certo disto?',
    text: 'Essa operação terá efeito imediato e sem retorno',
    showCancelButton: true,
    cancelButtonText: 'Manter',
    confirmButtonText: 'Sim, deletar',
    confirmButtonColor: '#d33',
    reverseButtons: true
  }).then((result) => {
    if (result.isConfirmed) {
        waitingDialog.show('Processando. Por gentileza, aguarde.', { progressType: 'danger' });
        $.ajax({
          type: 'post',
          url: '../../../pedidos/aDelProduto/'+id,
          success: function (r) {
            //$('#tabelaProdutos tbody tr#'+id).remove();
            tabelaProdutos.row('#'+id).remove().draw();
            $('#jsModal').modal('hide');
            waitingDialog.hide();
          },
        });
    }
  })
}

function fSalvaAvanca(tp) {
  if(tp == 1) {//salva
    $('#salvaAvanca').val(1);
  } else {
    $('#salvaAvanca').val(2);
  }
  submitForm('formCadastro');
}

function ver_pedido(id) {
  waitingDialog.show('Processando. Por gentileza, aguarde.', { progressType: 'danger' });
  $.ajax({
    type: 'post',
    url: '../../../pedidos/ver/' + id,
    success: function (r) {
      $('#jsModalLabel').html('Visualização do pedido');
      $('#jsModal .modal-body').html(r);
      $('#jsModal').modal('show');
      maskAll();
      waitingDialog.hide();
    },
  });
}

function ver_historico_pedido(id) {
  waitingDialog.show('Processando. Por gentileza, aguarde.', { progressType: 'danger' });
  $.ajax({
    type: 'post',
    url: '../../../pedidos/ver_historico/' + id,
    success: function (r) {
      $('#jsModalLabel').html('Visualização do pedido');
      $('#jsModal .modal-body').html(r);
      $('#jsModal').modal('show');
      maskAll();
      //$('#tabelaHistorico').DataTable();
      waitingDialog.hide();
    },
  });
}


function selectCarteira(){
  $("#carteira2").val($("#id_carteira option:selected").data('nome'));

  waitingDialog.show('Processando. Por gentileza, aguarde.', { progressType: 'danger' });
  $.ajax({
    type: 'post',
    url: '../../../carteira/aGetClientesFromCarteira/'+$('#id_carteira').val(),
    success: function (r) {
      $('#tabelaMesclagem tbody').html(r);
      waitingDialog.hide();
    },
  });
}

function calculaDesconto(){
  var vl_produtos = parseFloat($('#vl_produtos').val().replace('.', '').replace(',', '.'));
  var vl_desconto = parseFloat($('#desconto_').val().replace('.', '').replace(',', '.'));
  var multiplicador = $("#multiplicador").val();
  var vl_final = 0;


  if($('#tp_desconto_').val() == 1){
    vl_final = vl_produtos - vl_desconto;
  } else {
    vl_final = vl_produtos - (vl_produtos * vl_desconto/100);
  }
  //console.log(vl_produtos+' - '+vl_desconto+' - '+multiplicador);
  $('#v_final').val(formatMoney(vl_final,2,',','.'));
  $('#v_final_t').val(formatMoney(vl_final*multiplicador,2,',','.'));
  $('#v_final_h').val(vl_final);
}

function cancelarPedido(id){
  Swal.fire({
    icon: 'info',
    title: 'Está certo disto?',
    text: 'Essa operação terá efeito imediato e sem retorno',
    showCancelButton: true,
    cancelButtonText: 'Manter',
    confirmButtonText: 'Sim, cancelar',
    confirmButtonColor: '#d33',
    reverseButtons: true,
    input: "textarea",
    inputPlaceholder: "Coloque o motivo do cancelamento aqui",
    inputAttributes: {
      "aria-label": "Coloque o motivo do cancelamento aqui",
      "required":true
    },
  }).then((result) => {
    if (result.isConfirmed) {
        waitingDialog.show('Processando. Por gentileza, aguarde.', { progressType: 'danger' });
        $.ajax({
          type: 'post',
          url: '../../../pedidos/aCancelaPedido',
          data: {
            id: id,
            motivo:$('.swal2-textarea').val()
          },
          success: function (r) {
            //waitingDialog.hide();
            location.href = '../../../pedidos/meuspedidos';
          },
        });
    }
  })
}


function avanca_pedido(st){
  if(st == 4 && $("#inconsistencias").val() == ''){
    Swal.fire({
      icon: 'error',
      title: 'Informe quais são as inconsistências do pedido',
      confirmButtonColor: '#d33'
    });
    return false;
  } else {
    //seta qual o status do pedido
    $('#st_destino').val(st);

    submitForm('formCadastro');
  }
}

function feedback_pedido(id, st){
  if(st == 7){
    retorno = $("#motivo_nconformidade").val();
    if($("#motivo_nconformidade").val() == ''){
      Swal.fire({
        icon: 'error',
        title: 'Informe o motivo da não conformidade',
        confirmButtonColor: '#d33'
      });
      return false;  
    }

  } else {
    retorno = null;
  }
  waitingDialog.show('Processando. Por gentileza, aguarde.', { progressType: 'danger' });
  $.ajax({
    type: 'post',
    data: {
      id: id,
      st: st,
      retorno: retorno
    },
    url: '../../../pedidos/aChangeStatus',
    success: function (r) {
      waitingDialog.hide();
      location.href = '../../../pedidos/meuspedidos';
    },
  });
}

function trocaFaturamento(valor){
  if(valor == '9'){
    $('.quantidades').attr('readonly',true);
    $('.quantidades').each(function() {
      $(this).val($(this).data('reset'));
    });
  } else {
    $('.quantidades').attr('readonly',false);
  }
}

function calculaFaturamento(id){
  $("#subtotal"+id).val(formatMoney($("#qntd"+id).val()*$("#preco"+id).val().replace('.', '').replace(',', '.'),2,',','.'));
  let total = 0;
  $('.subtotal').each(function() {
    total += parseFloat($(this).val().replace('.', '').replace(',', '.'));
  });
  $("#vl_produtos").val(formatMoney(total,2,',','.'));

}

function devolucao() {
  Swal.fire({
    icon: 'warning',
    title: 'Está certo disto?',
    text: 'Informe os produtos que serão devolvidos e revise as faturas antes de prosseguir.',
    showCancelButton: true,
    cancelButtonText: 'Cancelar operação',
    confirmButtonText: 'Sim, continuar',
    confirmButtonColor: '#d33',
    reverseButtons: true
  }).then((result) => {
    if (result.isConfirmed) {
      $('.quantidades').attr('readonly',false).attr('required', true);
      $('#mudastatus').val('D');
      $('#qtd_parcelas').removeClass('min_qtd');
      $('#btnSalvar').html('Processar devolução').removeClass('btn-personal').addClass('btn-warning');
      $('#btnDevolver').hide();
      $('html, body'). animate({ scrollTop: -2000 }, 10);
      $('#btndevtotal').show();

      /*
        waitingDialog.show('Processando. Por gentileza, aguarde.', { progressType: 'danger' });
        $.ajax({
          type: 'post',
          url: '../../../faturamento/aDelParcelaAll',
          data: {id_pedido: $('#id_pedido').val()},
          success: function (r) {
            $('.parcela').remove();
            $('#qtd_parcelas').val(0);
            $('.quantidades').attr('readonly',false).attr('required', true);
            $('#mudastatus').val('D');
            $('#qtd_parcelas').removeClass('min_qtd');
            $('#btnSalvar').html('Processar devolução').removeClass('btn-personal').addClass('btn-warning');
            $('#btnDevolver').hide();
            waitingDialog.hide();
          },
        });
        */
    }
  })
}

function devolucao_total(){
  $('#tabelaPrincipal input.quantidades').val(0);
  $('#tabelaPrincipal input.subtotal').val(0);
  $('#total').val(0);
}

function add_parcela() {
  waitingDialog.show('Processando. Por gentileza, aguarde.', { progressType: 'danger' });

  $.ajax({
    type: 'post',
    url: '../../../faturamento/aAddParcela/',
    success: function (r) {
      $('#parcelas').append(r);
      maskAll();
      acionaTooltip();
      $('#qtd_parcelas').val(parseInt($('#qtd_parcelas').val()) + 1);
      waitingDialog.hide();
    },
  });
}

function remover_parcela(id){
  Swal.fire({
    icon: 'info',
    title: 'Está certo disto?',
    text: 'Essa operação terá efeito imediato e sem retorno',
    showCancelButton: true,
    cancelButtonText: 'Manter',
    confirmButtonText: 'Sim, deletar',
    confirmButtonColor: '#d33',
    reverseButtons: true
  }).then((result) => {
    if (result.isConfirmed) {
      if($("#update_"+id).val() == 1){
        waitingDialog.show('Processando. Por gentileza, aguarde.', { progressType: 'danger' });
        $.ajax({
          type: 'post',
          url: '../../../faturamento/aDelParcela/'+id,
          success: function (r) {
            waitingDialog.hide();
          },
        });
        }
      $('#produto_'+id).remove();
      $('#qtd_parcelas').val(parseInt($('#qtd_parcelas').val()) - 1);
    }
  })
}

function envia_boleto(id) {
  Swal.fire({
    icon: 'warning',
    title: 'Deseja enviar?',
    text: 'O cliente receberá um email com o boleto.',	
    showCancelButton: true,
    cancelButtonText: 'Candelar envio',
    confirmButtonText: 'Sim, enviar',
    confirmButtonColor: '#d33',
    reverseButtons: true
  }).then((result) => {
    if (result.isConfirmed) {
      waitingDialog.show('Processando. Por gentileza, aguarde.', { progressType: 'danger' });
      $.ajax({
        method: 'POST',
        url: caminho+'public/faturamento/aEnviarBoleto',
        data: {
          id: id,
          email: $('#emlvendedor'+id).val()
        },
        headers: {'X-Requested-With': 'XMLHttpRequest'},
        success: function (r) {
          waitingDialog.hide();
        },
      });
    }
  })

}

function alterarStatus() {
  if($("#tabelaPrincipal input:checked:not(#selectAll)").length == 0){
    Swal.fire({
      icon: 'error',
      title: 'Marque, pelo menos, uma fatura.',
      confirmButtonColor: '#d33'
    });

  } else {
    waitingDialog.show('Processando. Por gentileza, aguarde.', { progressType: 'danger' });
    $.ajax({
      type: 'post',
      url: '../../../Comissoes/aAlterarStatus',
      data: $("#tabelaPrincipal input:checked").serialize(),
      success: function (r) {
        getCompetencia();
        waitingDialog.hide();
      },
    });
  }
}

function getRelatorio(idForm, tipo){
  $("#formato").val(tipo);
  if ($("#" + idForm).valid()) {
    Swal.fire({
      title: 'Aguarde, processando',
      //text: 'Após o download, feche essa janela no "X"',
      showCloseButton: true,
      timer: 4000,
      timerProgressBar: false,
      didOpen: () => {
        Swal.showLoading()
      }
    })
    $('#' + idForm).submit();
  } else {
    Swal.fire({
      icon: 'error',
      title: 'Verifique os campos em vermelho.',
      text: 'Preencha todos os dados corretamente',
      confirmButtonColor: '#d33'
    });
  }
}

function select_rel_lista() {
  $('.filtro').hide();
  $('.filtro select, .filtro input').removeAttr('required');

  if($('#tipo').val() == 1) { //clientes
    $('#status').parent('.filtro').show();
    $('#carteiras').parent('.filtro').show();
    $('#vendedores').parent('.filtro').show();
    $('#estado').parent('.filtro').show();
    $('#id_cidade').parent('.filtro').show();
  } else if($('#tipo').val() == 2) { //Representadas
    $('#estado').parent('.filtro').show();
    $('#id_cidade').parent('.filtro').show();
  } else if($('#tipo').val() == 3) { //Vendedores
    $('#status').parent('.filtro').show();
  }
}



function atualiza_comissao(tipo, valor){
  //function formatMoney(number, decPlaces, decSep, thouSep) {
  //valor = formatMoney(valor,2,'.','');
  valor = valor.replace(',','.');

  console.log(valor);
  $("#range_com_v_"+tipo).val(valor);
  $('#com_v_'+tipo).val(formatMoney(parseFloat(valor),2,',','.'));
  $('#com_c_'+tipo).val(formatMoney((100-parseFloat(valor)),2,',','.'));
}

function salvaAddTabela(formid){
  $('#nova').val(1);
  console.log($('#id_importador').val());
  submitForm(formid);
}


function editar_registros(id){
  waitingDialog.show('Processando. Por gentileza, aguarde.', { progressType: 'danger' });
  $.ajax({
    type: 'post',
    url: '../../../Pedidos/aEditaRegistros',
    data: { id: id },
    success: function (r) {
      waitingDialog.hide();

      $('#jsModalLabel').html('Comentários do pedido');
      $('#jsModal .modal-body').html(r);
      $('#jsModal').modal('show');
    },
  });
}

function salva_registros() {
  waitingDialog.show('Processando. Por gentileza, aguarde.', { progressType: 'danger' });
  $.ajax({
    type: 'post',
    url: '../../../Pedidos/aSalvaRegistros',
    data: { 
      id: $('#id_pedido').val(),
      n_pedido: $('#n_pedido').val(),
      observacoes: $('#observacoes').val(),
      reg_interno: $('#reg_interno').val(),
    },
    success: function (r) {
      $('#jsModal').modal('hide');
      waitingDialog.hide();
      Swal.fire("Salvo com sucesso!", "", "success");
    },
  });
}

function encolhe_menu(){
  let w = $(window).width();
  
  //console.log(w); console.log($.cookie('CLmenu'));
  $.removeCookie('CLmenu', { path: '/' });

    if ($('body').hasClass('sidebar-vertical-colapse')) {
      $('body').removeClass('sidebar-vertical-colapse');
      $('main').width('').addClass('col-md-9').addClass('col-lg-10').addClass('ms-sm-auto');
      $.cookie('CLmenu', 'expand', { expires: 300, path: '/' });
    } else {
      $('body').addClass('sidebar-vertical-colapse');
      $('main').removeClass('col-md-9').removeClass('col-lg-10').removeClass('ms-sm-auto');
      $('main').css('width',(w - 70));
      $.cookie('CLmenu', 'colapsed', { expires: 300, path: '/' });
    }
}

function numerar(tabela){
  /*
  if($('#'+tabela+' tbody tr').length > 1){
    $('#'+tabela+' tbody tr').each(function(){
      $(this).find('td').eq(0).html($(this).index() + 1);
    });
  }
  */
  $('#'+tabela+' tbody tr').each(function(){
    $(this).find('td').eq(0).html($(this).index() + 1);
  });
}

function checkRetracaoMenu(){
  //se estive mobile deixa sempre aberto
  if($(window).width() <= 500){
      $('body').removeClass('sidebar-vertical-colapse');
      $('main').width('').addClass('col-md-9').addClass('col-lg-10').addClass('ms-sm-auto');
  } else {
    if($.cookie('CLmenu') == 'expand' && $('body').hasClass('sidebar-vertical-colapse')){
      encolhe_menu();
    }
    if($.cookie('CLmenu') == 'colapsed' && !$('body').hasClass('sidebar-vertical-colapse')){
      encolhe_menu();
    }
  }

}
checkRetracaoMenu();

function requisitar_pedido(id,lnk){
  Swal.fire({
    icon: 'info',
    title: 'Você quer se tornar responsável por este pedido?',
    text: 'Você ficará encarregado de todo o processo até o faturamento',
    showCancelButton: true,
    cancelButtonText: 'Não',
    confirmButtonText: 'Sim',
    confirmButtonColor: '#d33',
    reverseButtons: true
  }).then((result) => {
    if (result.isConfirmed) {
      waitingDialog.show('Processando. Por gentileza, aguarde.', { progressType: 'danger' });
      $.ajax({
        type: 'post',
        url: '../../../Pedidos/aRequisitaPedido',
        data: { 
          id: id,
        },
        success: function (r) {
          waitingDialog.hide();
          Swal.fire({
            icon: 'info',
            title: r,
          }).then((result) => {
            if (result.isConfirmed) {
              location.href = lnk;
            }
          });
        },
      });
    }
  })
}

function pedidoIncompleto(id){
  Swal.fire({
    icon: 'info',
    title: 'O que está faltando?',
    text: 'Explique quais informações impedem o prosseguimento deste pedido',
    showCancelButton: true,
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Marcar como incompleto',
    confirmButtonColor: '#d33',
    reverseButtons: true,
    input: "textarea",
    inputPlaceholder: "Coloque o que impede o prosseguimento deste pedido aqui",
    inputAttributes: {
      "aria-label": "Coloque o que impede o prosseguimento deste pedido aqui",
      "required":true
    },
  }).then((result) => {
    if (result.isConfirmed) {
        waitingDialog.show('Processando. Por gentileza, aguarde.', { progressType: 'danger' });
        $.ajax({
          type: 'post',
          url: '../../../pedidos/aMarcaIncompleto',
          data: {
            id: id,
            pd_incompleto:$('.swal2-textarea').val(),
            n_pedido:$('#n_pedido').val()
          },
          success: function (r) {
            waitingDialog.hide();
            $('#pedido_incompleto').hide();
          },
        });
    }
  })
}

function troca_carteira() {
  if($('#id_carteira').val() == 'N'){
    $('#nova_carteira').attr('required', true).parent('.ocultar').show();
  } else {
    $('#nova_carteira').removeAttr('required').parent('.ocultar').hide();
  }
}

function buscaProdutos(){
  waitingDialog.show('Processando. Por gentileza, aguarde.', { progressType: 'danger' });
  $.ajax({
    type: 'post',
    url: '../../../dashboard/aBuscaProduto',
    success: function (r) {
      $('#jsModalLabel').html('Busca produto');
      $('#jsModal .modal-body').html(r);
      maskAll();
      acionaTooltip();
      waitingDialog.hide();
      $('#jsModal').modal('show');
    },
  });
}

function buscaProdutosDo(){
  if ($("#busca_produto").valid()) {
    //pede pro usuario aguardar
    waitingDialog.show('Aguarde, processando', {
      dialogSize: 'lg',
      progressType: 'info'
    });

    if ( $.fn.DataTable.isDataTable('#tbl_produtos') ) {
      $('#tbl_produtos').DataTable().destroy();
    }
    
    $('#tbl_produtos tbody').empty();

    $.ajax({
      type: 'post',
      url: '../../../dashboard/aBuscaProdutoDo',
      data: {
        produto:$('#produto').val(),
        quantidade:$('#quantidade').val(),
        desconto_:$('#desconto_').val(),
        tp_desconto_:$('#tp_desconto_').val(),
      },
      success: function (r) {
        waitingDialog.hide();
        $('#tbl_produtos tbody').empty();
        $('#tbl_produtos tbody').html(r);
        $('#tbl_produtos').DataTable({
          destroy: true,
          columnDefs: [
              { orderable: false, targets: 0 }
          ],
          order: [[1, 'asc']],
          fnDrawCallback: function (settings) {
              numerar('tbl_produtos');
          },
          });
      },
    });


  } else {
    Swal.fire({
      icon: 'error',
      title: 'Verifique os campos em vermelho.',
      text: 'Preencha todos os dados corretamente',
      confirmButtonColor: '#d33'
    });
  }

}

function checkNF(){
  if($('#n_nf').val() != ''){
    waitingDialog.show('Pesquisando documento. Por gentileza, aguarde.', { progressType: 'danger' });

    $.ajax({
      type: 'post',
      url: '../../../Faturamento/aCheckNF',
      data: {
        n_nf: $('#n_nf').val(),
        id_pedido: $('#id_pedido').val(),
      },
      success: function (r) {
        if(r > 0){
          Swal.fire({
            icon: 'error',
            title: 'Esta NF já está cadastrada.',
            confirmButtonColor: '#d33'
          });

          $('#n_nf').val('').focus();
        }
      },
    });
    
    waitingDialog.hide();
  
  }
}

function deleta_licao(id_licao){
  Swal.fire({
    icon: 'info',
    title: 'Está certo disto?',
    text: 'Essa operação terá efeito imediato e sem retorno',
    showCancelButton: true,
    cancelButtonText: 'Manter',
    confirmButtonText: 'Sim, deletar',
    confirmButtonColor: '#d33',
    reverseButtons: true
  }).then((result) => {
    if (result.isConfirmed) {
        waitingDialog.show('Processando. Por gentileza, aguarde.', { progressType: 'danger' });
        $.ajax({
          type: 'post',
          url: '../../../Licoes/aDelete/'+id_licao,
          success: function (r) {
            location.reload();
          },
        });
    }
  })
}
