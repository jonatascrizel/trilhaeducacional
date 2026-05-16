$(document).ready(function () {
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


	jQuery.validator.addMethod("cnpj", function (value, element) {

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

		return (resultado == digitos.charAt(1));
	})

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
		'Informe um celular v�lido');

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
		'Informe um telefone v�lido');

	//Telefone generico
	jQuery.validator.addMethod('telefone', function (value, element) {
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
		'Informe um telefone v�lido');

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
		"Insira uma data v�lida"
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

});