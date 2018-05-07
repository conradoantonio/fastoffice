$(function(){
	createTable();
	$('[data-toggle="tooltip"]').tooltip()
	$("select.select2").select2();
	$("#s2id_byUser").addClass('col-md-12').css('padding','0')
	$("#start_date").datepicker({
		language: 'es',
		autoclose: true,
		todayHighlight: true,
		format: "dd M yyyy",
		clearBtn: true
	}).on("changeDate", function(e) {
		$("#end_date").datepicker('setStartDate', e.date);
	});

	$("#end_date").datepicker({
		language: 'es',
		autoclose: true,
		todayHighlight: true,
		format: "dd M yyyy",
		clearBtn: true
	}).on("changeDate", function(e) {
		$("#start_date").datepicker('setEndDate', e.date);
	});

	$(".clockpicker").clockpicker({
		autoclose: true,
	});

	$(".input-date").datepicker({
		language: 'es',
		autoclose: true,
		todayHighlight: true,
		format: "dd M yyyy",
		clearBtn: true
	})

	$(".length").each(function(){
		$(this).siblings('span.display-counter').find('span').text( $(this).val().length )
	})

	$(".tagsinput").tagsinput();
})

$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	},
	cache: false
});

$('#photo').change(function(){
	/*readURL(this)*/
	$('#foto_perfil').croppie('destroy');
	var img = this;

	$('#foto_perfil').croppie({
		url: readURL(img),
		mouseWheelZoom: false,
		viewport: {
			width: 200,
			height: 200,
			type: 'circle',
		},
		boundary: {
			width: 300,
			height: 300
		},
		update: function (data) {
			$('#foto_perfil').croppie('result', {
				type : 'base64',
				quality: '0.9',
				size: {
					width: 640,
					height: 605
				},
				circle: false
			}).then(function(res) {
				res = res.replace(/^data\:image\/\w+\;base64\,/, '');
				$('input[name=base64]').val(res);
			});
		}
	});
})

$(".logout").on('click',function(e){
	var ele = $(this);
	e.preventDefault()
	swal({
		title: '¿Quieres cerrar sesión?',
		icon: "warning",
		buttons: ["Cancelar", "Salir"],
		dangerMode: true,
	}).then((accept) => {
		if (accept) {
			loadAnimation('Cerrando sesión');
			$(".logout-form").submit();
		}
	}).catch(swal.noop)
})

$(document).delegate('.delete_row','click',function(e){
	var ele = $(this);
	e.preventDefault()
	swal({
		title: '¿Quieres eliminar este registro?',
		icon: "warning",
		buttons: ["Cancelar", "Eliminar"],
		dangerMode: true,
	}).then((accept) => {
		if (accept) {
			$.ajax({
				url: ele.attr('href'),
				method: "DELETE",
				type: "DELETE",
				beforeSend:function(){
					loadAnimation('Eliminando')
				},
				success:function(response){
					if (response.delete == "true"){
						swal({
							title: 'Registro eliminado exitosamente',
							icon: 'success',
						}).then((accept) => {
							if (accept) {
								refreshTable(window.location.href)
							}
						})
					} else {
						if ( response.delete == "occupied" ) {
							swal("Error","Este registro esta siendo usado, cambie la categoria que esta asignada ene esta ciudad","error")
						} else {
							swal("Ha ocurrido un error","","error")
						}
					}
				}
			})
		}
	}).catch(swal.noop)
})

$(document).delegate("span.label.status",'click',function(e){
	e.preventDefault()
	var ele = $(this);
	var status = ele.hasClass(':label-success')?"activar":"desactivar";
	var url = ele.data('url');
	var id = ele.data('id');

	swal({
		title: '¿Quieres '+status+' este registro?',
		icon: 'warning',
		buttons:["Cancelar", "Aceptar"],
		dangerMode: false,
	}).then((accept) => {
		if (accept){
			$.ajax({
				url: url,
				type:"PATCH",
				data:{
					id:id
				},
				beforeSend:function(){
					loadAnimation()
				},
				success:function(response){
					if (response.status){
						swal("Se ha modificado el estatus","","success");
						if ( ele.hasClass('label-success') ){
							ele.removeClass("label-success").addClass("label-danger").text("Inactivo");
						} else{
							ele.removeClass("label-danger").addClass("label-success").text("Activo");
						}
					} else {
						swal("Ha ocurrido un error","","error");
					}
				}
			})
		}
	})
})

$(document).delegate('#checkboxParent', "click", function(){
	var checked = false;
	if ( $(this).attr('checked') ) {
		checked = true;
	}
	$(".multiple-delete").each(function(){
		$(this).attr('checked', checked);
	})

	if ( $('.multiple-delete:checked').length ) {
		$('.multiple-delete-btn').attr('disabled', false).removeClass('disabled');
	} else {
		$('.multiple-delete-btn').attr('disabled', true).addClass('disabled');
	}
})

$(document).delegate('.multiple-delete','click',function(){
	if ( $('.multiple-delete:checked').length ) {
		$('.multiple-delete-btn').attr('disabled', false).removeClass('disabled');
	} else {
		$('.multiple-delete-btn').attr('disabled', true).addClass('disabled');
	}

	if ( $('.multiple-delete:checked').length == $('.multiple-delete').length ){
		$("#checkboxParent").attr('checked', true);
	} else {
		$("#checkboxParent").attr('checked', false);
	}
})

$('.multiple-delete-btn').on('click', function(e){
	e.preventDefault();
	var url = $(this).attr('href')
	var ids = [];
	$('.multiple-delete:checked').each(function(){
		ids.push($(this).val());
	})
	swal({
		title: 'Se eliminarán '+ids.length+' registro(s), ¿Estás seguro?',
		icon: 'warning',
		buttons:["Cancelar", "Aceptar"],
		dangerMode: true,
	}).then((accept) => {
		if (accept){
			$.ajax({
				url: url,
				type:"DELETE",
				data:{
					ids: ids
				},
				beforeSend:function(){
					loadAnimation('Eliminando');
				},
				success:function(response){
					if (response.delete == "true"){
						swal({
							title: 'Registro eliminado exitosamente',
							icon: 'success',
						}).then((accept) => {
							if (accept) {
								$('.multiple-delete-btn').attr('disabled', true).addClass('disabled');
								refreshTable(window.location.href)
							}
						})
					} else {
						if ( response.delete == "occupied" ) {
							swal("Error","Este registro esta siendo usado, cambie la categoria que esta asignada ene esta ciudad","error")
						} else {
							swal("Ha ocurrido un error","","error")
						}
					}
				}
			})
		}
	}).catch(swal.noop)
})

$("#filtrar").on('click',function(){
	url = "";
	if ( $("#byUser").length ){
		if ( $("#byUser").val() != 0 ){
			url = "/"+$("#byUser").val();
		} else {
			url = "/0"
		}
	} else {
			url = "/0"
	}

	if ( $("#start_date").val() != "" ){
		var date = $("#start_date").datepicker('getDate');
		var start = date.getFullYear() + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' +  ("0" + (date.getDate())).slice(-2);
		url = url+'/'+start;
	} else {
		url = url+'/0';
	}

	if ( $("#end_date").val() != "" ){
		var date = $("#end_date").datepicker('getDate');
		var end = date.getFullYear() + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' +  ("0" + (date.getDate())).slice(-2)
		url = url+'/'+end;
	} else {
		url = url+'/0';
	}
	refreshTable($(this).data('url') +url)
})

$("#search").on('click', function(){
	var url = $(this).data('url');
	$('.fields').find('.form-control').each(function(){
		if ( $(this).val() && $(this).val() != 0 ) {
			if ( $(this).hasClass('input-date') ) {
				var date = $(this).datepicker('getDate');
				var d = $(this)[0].id+':'+$(this).data('operator')+':'+date.getFullYear() + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' +  ("0" + (date.getDate())).slice(-2);
				url = url+'/'+d;
			} else {
				url = url+'/'+$(this)[0].id+':'+$(this).data('operator')+':'+$(this).val();
			}
		}
	})
	refreshTable(url)
})

$("#export").on('click',function(){
	var url = $(this).data('url');
	$('.fields').find('.form-control').each(function(){
		if ( $(this).val() && $(this).val() != 0 ) {
			if ( $(this).hasClass('input-date') ) {
				var date = $(this).datepicker('getDate');
				var d = $(this)[0].id+':'+$(this).data('operator')+':'+date.getFullYear() + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' +  ("0" + (date.getDate())).slice(-2);
				url = url+'/'+d;
			} else {
				url = url+'/'+$(this)[0].id+':'+$(this).data('operator')+':'+$(this).val();
			}
		}
	})
	window.location = url
})

$("#exportar").on('click',function(){
	url = "";
	if ( $("#byUser").length )  {
		if ( $("#byUser").val() != 0 ){
			url = "/"+$("#byUser").val();
		} else {
			url = "/0"
		}
	} else {
			url = "/0"
	}

	if ( $("#start_date").val() != "" ){
		var date = new Date($("#start_date").datepicker('getDate'));
		var start = date.getFullYear() + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' +  ("0" + (date.getDate())).slice(-2);
		url = url+'/'+start;
	} else {
		url = url+'/0';
	}

	if ( $("#end_date").val() != "" ){
		var date = new Date($("#end_date").datepicker('getDate'));
		var end = date.getFullYear() + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' +  ("0" + (date.getDate())).slice(-2)
		url = url+'/'+end;
	} else {
		url = url+'/0';
	}
	window.location = $(this).data('url') +url;
})

$(document).delegate(".change_status",'click',function(e){
	e.preventDefault()
	var ele = $(this);
	var status = ele.is(':checked')?"marcar":"desmarcar";

	swal({
		title: '¿Quieres '+status+' este registro?',
		icon: 'warning',
		buttons:true
	}).then((accept) => {
		if (accept) {
			$.ajax({
				url: ele.data('url'),
				method: "PUT",
				success:function(response){
					if (response.status){
						swal({
							title: 'Registro cambiado exitosamente',
							type: 'success',
							showCancelButton: false,
							confirmButtonColor: '#3085d6',
							cancelButtonColor: '#d33',
							confirmButtonText: 'Ok',
							cancelButtonText: 'Cancelar'
						}).then(function () {
							if ( status == "marcar" ) {
								ele.attr('checked',true)
							} else {
								ele.attr('checked',false)
							}
							checkProgress();
						})
					} else {
						swal("Ha ocurrido un error","","error")
					}
				}
			})
		}
	}).catch(swal.noop)
})

function refreshTable(url, tarjet){
	var table = $(".datatable").dataTable();
	$('#body-content').fadeOut();
	$('#body-content').empty();
	table.fnDestroy();
	$('#body-content').load(url, function() {
		$('#body-content').fadeIn();
		createTable()
		checkProgress();
	});
}

function loadAnimation(title = null){
	if ( !title ){
		title = 'Guardando';
	}
	swal({
		title: title,
		buttons: false,
		closeOnEsc: false,
		closeOnClickOutside: false,
		content: {
			element: "div",
			attributes: {
				innerHTML:"<i class='fa fa-circle-o-notch fa-spin fa-3x fa-fw'></i>"
			},
		}
	}).catch(swal.noop);
}

function readURL(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function (e) {
			$('.cr-image').attr('src', e.target.result);
		}

		reader.readAsDataURL(input.files[0]);
	}
}

function checkProgress(){
	var progress = 0;
	var total = 0;
	var checked = 0;
	$("tbody tr").each(function(){
		var check = $(this).find('.change_status')

		if ( check.is(':checked') ){
			total += 1;
			checked += 1;
		} else {
			total += 1;
		}

	})
	if (checked != 0){
		progress = checked*100/total;
	} else {
		progress = 0;
	}
	$("#progress_checklist").css('width',progress+"%")
	$("#porcentaje").text(parseFloat(progress).toFixed(0)+"% de mis tareas completadas")
}

function createTable(){
	$(".datatable").dataTable({
		"aaSorting": [[ 0, "desc" ]],
		"oLanguage": {
			"sProcessing":     "Procesando...",
			"sLengthMenu":     "_MENU_",
			"sZeroRecords":    "No se encontraron resultados",
			"sEmptyTable":     "Ningún registro disponible en esta tabla",
			"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
			"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
			"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
			"sInfoPostFix":    "",
			"sSearch":         "Buscar:",
			"sUrl":            "",
			"sInfoThousands":  ",",
			"sLoadingRecords": "Cargando...",
			"oPaginate": {
				"sFirst":    "Primero",
				"sLast":     "Último",
				"sNext":     "Siguiente",
				"sPrevious": "Anterior"
			},
			"oAria": {
				"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			}
		}
	});
}