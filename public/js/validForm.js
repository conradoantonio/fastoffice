/*
* Script de validaciones de un formulario
* Luis Castañeda
* v 2.7.3
*
* not-empty: El input no puede estar vacio
* file: El input es de tipo file
* numeric: El campo solo permite enteros
* decimals: El campo solo permite enteros y decimales
* character: El campo solo permite letras
* length: El campo solo debe cumplir con un minimo y/o máximo de caracteres
* value: El campo solo debe cumplir con un minimo y/o máximo respecto a su valor
* email: El campo debe ser un correo
*/

var regEmail = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
var regExprRfc = /^([A-Z a-z,Ñ ñ,&]{3,4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[A-Z a-z|\d]{3})$/;
var regDecimals = /^[0-9]+([.][0-9]{1,2})?$/

/* ----- KEYPRESS SECTION ----- */
$('.numeric').keypress(function(e) {
	if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
		return false;
	}
});

$('.decimals').keypress(function() {
	if(!decimals.test($(this).val())) {
		if ( !$(this).parent().hasClass("has-error") ){
			$(this).parent().addClass('has-error')
		}
	} else {
		$(this).parent().removeClass('has-error')
	}
});

$('.character').keypress(function(e) {
	if (e.which > 48 && e.which < 57) {
		return false;
	}
});

$('.length').keyup(function(){
	$(this).siblings('span.display-counter').find('span').text( $(this).val().length )
})

/* ----- BLUR SECTION ----- */
$(".not-empty").blur(function() {
	if ( !$(this).parent().hasClass('has-error') ){
		if ( !$(this).val() || $(this).val() == 0 || $(this).select2('val') == 0 ){
			$(this).parent().addClass('has-error')
		} else {
			$(this).parent().removeClass('has-error')
		}
	} else {
		if ( !$(this).val() || $(this).val() == 0 || $(this).select2('val') == 0 ){
			$(this).parent().addClass('has-error')
		} else {
			$(this).parent().removeClass('has-error')
		}
	}
});

$('.length').blur(function(){
	if ( $(this).hasClass('not-empty') ){
		if ( !$(this).parent().hasClass("has-error") ){
			if ( $(this).data('min') ){
				if ( $(this).val().length >= $(this).data('min') ){
					$(this).parent().removeClass('has-error')
				} else {
					$(this).parent().addClass('has-error')
				}
			}
		}
		if ( !$(this).parent().hasClass("has-error") ){
			if ( $(this).data('max') ){
				if ( $(this).val().length <= $(this).data('max') ){
					$(this).parent().removeClass('has-error')
				} else {
					$(this).parent().addClass('has-error')
				}
			}
		}
		if ( !$(this).parent().hasClass("has-error") ){
			if ( $(this).data('equal') ){
				if ( $(this).val().length == $(this).data('equal') ){
					$(this).parent().removeClass('has-error')
				} else {
					$(this).parent().addClass('has-error')
				}
			}
		}
	}
})

$('.value').blur(function(){
	if ( !$(this).parent().hasClass("has-error") ){
		if ( $(this).data('min') ){
			if ( $(this).val() >= $(this).data('min') ){
				$(this).parent().removeClass('has-error')
			} else {
				$(this).parent().addClass('has-error')
			}
		}
	}
	if ( !$(this).parent().hasClass("has-error") ){
		if ( $(this).data('max') ){
			if ( $(this).val() <= $(this).data('max') ){
				$(this).parent().removeClass('has-error')
			} else {
				$(this).parent().addClass('has-error')
			}
		}
	}
})

$(".email").blur(function() {
	if(!$(this).val().match(regEmail)) {
		if ( !$(this).parent().hasClass("has-error") ){
			$(this).parent().addClass('has-error')
		}
	} else {
		$(this).parent().removeClass('has-error')
	}
});

$('.decimals').blur(function() {
	if(!regDecimals.test($(this).val())) {
		if ( !$(this).parent().hasClass("has-error") ){
			$(this).parent().addClass('has-error')
		}
	} else {
		$(this).parent().removeClass('has-error')
	}
});

/* ----- ADD ELEMENTS SECTION ----- */
$(".length").each(function(){
	$(this).siblings('label').addClass('with-counter');
	var selector = '';
	var reach = 0;
	if ( $(this).data('min') ){
		selector = '>';
		reach = $(this).data('min')
	}
	if ( $(this).data('max') ){
		if ( reach ) {
			selector = "/";
			reach = "("+reach +" al "+$(this).data('max')+")"
		} else {
			selector = "<";
			reach = $(this).data('max')
		}
	}
	if ( $(this).data('equal') ){
		selector = "/";
		reach = $(this).data('equal')
	}
	$(this).before("<span class='display-counter'><span class='counter'>0</span>"+selector+reach+" caracteres</span>")
})

$(".value").each(function(){
	if ( $(this).data('min') && $(this).data('max') ){
		$(".value").parent().find('label').text( $(".value").parent().find('label').text()+" (Entre: "+$(this).data('min')+" - "+$(this).data('max')+")" )
	} else if ( $(this).data('min') ){
		$(".value").parent().find('label').text( $(".value").parent().find('label').text()+" (Mínimo: "+$(this).data('min')+")" )
	} else if ( $(this).data('max') ){
		$(".value").parent().find('label').text( $(".value").parent().find('label').text()+" (Máximo: "+$(this).data('max')+")" )
	}
})

/* ----- VALID FORM ON CLICK BUTTON ----- */
$(".guardar").on('click',function(e){
	e.preventDefault();
	var btn = $(this);
	var formId = $(this).data('target');
	var errors_count = 0;
	var msg = "";
	var fileExtension = ['jpg','jpeg','png','gif'];
	var pdfExtension = ['pdf'];
	var excelExtension = ['xls','xlsx'];
	var wordtension = ['docx'];
	var mb = 0;
	var max_mb = 3;
	var kilobyte = 0;
	var actual = new Date();

	btn.prop('disabled',true).addClass('disabled');
	$('form#'+formId).find('input, select, textarea').each(function(i,e){
		if ( $(this).hasClass('not-empty') ) {
			if ( $(this).is(':checkbox') ){
				if ( !$(this).is(':checked') ){
					$(this).parent().addClass('has-error')
					errors_count += 1;
					msg = msg +"<li>"+$(this).data('name')+": Campo vacio</li>";
				}
			}

			if ( !$(this).val() || $(this).val() == 0 || $(this).select2('val') == 0 ){
				$(this).parent().addClass('has-error')
				errors_count += 1;
				msg = msg +"<li>"+$(this).data('name')+": Campo vacio</li>";
			} else {
				$(this).parent().removeClass('has-error')
			}
		}

		if ( $(this).hasClass('length') ) {
			if ( $(this).hasClass('not-empty') ){
				if ( !$(this).parent().hasClass("has-error") ){
					if ( $(this).data('min') ){
						if ( $(this).val().length >= $(this).data('min') ){
							$(this).parent().removeClass('has-error')
						} else {
							errors_count += 1;
							msg = msg +"<li>"+$(this).data('name')+": Mínimo de "+$(this).data('min')+" caracteres</li>";
							$(this).parent().addClass('has-error')
						}
					}
				}
				if ( !$(this).parent().hasClass("has-error") ){
					if ( $(this).data('max') ){
						if ( $(this).val().length <= $(this).data('max') ){
							$(this).parent().removeClass('has-error')
						} else {
							errors_count += 1;
							msg = msg +"<li>"+$(this).data('name')+": Máximo de "+$(this).data('max')+" caracteres</li>";
							$(this).parent().addClass('has-error')
						}
					}
				}
				if ( !$(this).parent().hasClass("has-error") ){
					if ( $(this).data('equal') ){
						if ( $(this).val().length == $(this).data('equal') ){
							$(this).parent().removeClass('has-error')
						} else {
							errors_count += 1;
							msg = msg +"<li>"+$(this).data('name')+": Total de "+$(this).data('equal')+" caracteres</li>";
							$(this).parent().addClass('has-error')
						}
					}
				}
			}
		}

		if ( $(this).hasClass('value') ) {
			if ( !$(this).parent().hasClass("has-error") ){
				if ( $(this).data('min') ){
					if ( $(this).val() >= $(this).data('min') ){
						$(this).parent().removeClass('has-error')
					} else {
						errors_count += 1;
						msg = msg +"<li>"+$(this).data('name')+": Valor mínimo posible "+$(this).data('min')+"</li>";
						$(this).parent().addClass('has-error')
					}
				}
			}
			if ( !$(this).parent().hasClass("has-error") ){
				if ( $(this).data('max') ){
					if ( $(this).val() <= $(this).data('max') ){
						$(this).parent().removeClass('has-error')
					} else {
						errors_count += 1;
						msg = msg +"<li>"+$(this).data('name')+": Valor máximo posible "+$(this).data('max')+" caracteres</li>";
						$(this).parent().addClass('has-error')
					}
				}
			}
		}

		if ( $(this).hasClass('email') ) {
			if(!$(this).val().match(regEmail)) {
				if ( !$(this).parent().hasClass("has-error") ){
					$(this).parent().addClass('has-error')
					errors_count += 1;
					msg = msg +"<li>"+$(this).data('name')+": Correo inválido</li>";
				}
			}
		}

		if ( $(this).hasClass('decimals') ){
			if(!regDecimals.test($(this).val())) {
				if ( !$(this).parent().hasClass("has-error") ){
					$(this).parent().addClass('has-error')
					errors_count += 1;
					msg = msg +"<li>"+$(this).data('name')+": Valor entero o decimal requerido</li>";
				}
			} else {
				$(this).parent().removeClass('has-error')
			}
		}

		if ( $(this).hasClass('file') ){
			archivo = $(this).val();
			extension = archivo.split('.').pop().toLowerCase();
			var allowedExtensions = [];

			if ( $(this).hasClass('image') ){
				allowedExtensions = $.merge(allowedExtensions, fileExtension)
			}

			if ( $(this).hasClass('excel') ){
				allowedExtensions = $.merge(allowedExtensions, excelExtension)
			}

			if ( $(this).hasClass('word') ){
				allowedExtensions = $.merge(allowedExtensions, wordtension)
			}

			if ( $(this).hasClass('pdf') ){
				allowedExtensions = $.merge(allowedExtensions, pdfExtension)
			}

			if ( $(this).val() ) {
				if ( !$(this).parent().hasClass("has-error") ){
					kilobyte = ( $(this)[0].files[0].size / 1024 );
					mb = kilobyte / 1024;

					if ($.inArray(extension, allowedExtensions) == -1 || mb > max_mb) {
						if ( !$(this).parent().hasClass("has-error") ){
							if ( $.inArray(extension, allowedExtensions) == -1 ) {
								type_error = "Extensiones permitidas: "+allowedExtensions;
							} else {
								type_error = "El arhivo debe ser menor a "+max_mb+" mb";
							}
							$(this).parent().addClass("has-error");
							errors_count += 1;
							msg = msg +"<li>"+$(this).data('name')+": "+type_error+"</li>";
						}
					} else {
						$(this).parent().removeClass("has-error");
					}
				}
			}
		}
	})

	if ( errors_count > 0 ) {
		swal({
			title: 'Verifique los siguientes campos: ',
			icon: 'error',
			content: {
				element: "div",
				attributes: {
					innerHTML:"<ul id='errores_list'>"+msg+"</ul>"
				},
			}
		}).catch(swal.noop);
		$(".guardar").prop( "disabled", false ).removeClass('disabled');
	} else {
		loadAnimation();
		if ( $('form#'+formId).hasClass('ajax') ) {
			$.ajax({
				url:$("form#"+formId).attr('action'),
				type:$("form#"+formId).attr('method'),
				data:new FormData($("form#"+formId)[0]),
				processData: false,
				contentType: false,
				success:function(response){
					$(".guardar").prop( "disabled", false ).removeClass('disabled');
					if (response.status) {
						swal(response.msg,"","success");
						refreshTable(window.location.href);
						$('.modal').modal('hide')
					} else {
						swal("Error al guardar","","error");
						btn.prop('disabled',false).removeClass('disabled');
					}
				},
				error:function(response, status, text){
					if ( response.status == 500 || response.status == 404 ){
						swal(response.status+" "+text, "Contacte con el administrador de sistema para mayor información", "error");
					} else { // status 422
						$("form#"+formId+" div").find('span.errors').remove();
						swal.close()
						$.each(JSON.parse(response.responseText), function(key, item) {
							$("#"+key).parent().append("<span class='errors'>"+item+"</span>").fadeIn().addClass('has-error');
						});
					}
					btn.prop('disabled',false).removeClass('disabled');
				}
			})
		} else {
			$('form#'+formId).submit();
		}
		return true;
	}
})

/*
* En este evento se limpia la información del formulario
*/
$("#limpiar").on('click',function(){
	clean($('form.valid'))
})

$('.modal').on('hidden.bs.modal', function (e) {
	clean($(this))
})

function clean(ele){
	ele.find('form').find('input.form-control, textarea.form-control').val(null).parent().removeClass('has-error')
	$('form#'+ele.find('form')[0].id+' select').val(0);
	$('form#'+ele.find('form')[0].id+' select').parent().removeClass('has-error');
	$('form#'+ele.find('form')[0].id).select2("val", 0);
}