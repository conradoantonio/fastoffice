<!DOCTYPE html>
<html>
<head>
	<title>Formulario prospecto</title>
	<link href="{{asset('/plugins/pace/pace-theme-flash.css')}}" rel="stylesheet" type="text/css" media="screen"/>
	<!-- BEGIN CORE CSS FRAMEWORK -->
	<link href="{{asset('/plugins/boostrapv3/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
	<link href="{{asset('/plugins/boostrapv3/css/bootstrap-theme.min.css')}}" rel="stylesheet" type="text/css"/>
	<link href="{{asset('/plugins/font-awesome/css/font-awesome.css')}}" rel="stylesheet" type="text/css"/>
<!-- BEGIN CSS TEMPLATE -->
	<link href="{{asset('/css/themes/coporate/style.css')}}" rel="stylesheet" type="text/css"/>
	<link href="{{asset('/css/themes/coporate/responsive.css')}}" rel="stylesheet" type="text/css"/>
	<link href="{{asset('/css/custom-icon-set.css')}}" rel="stylesheet" type="text/css"/>
	<link href="{{asset('plugins/boostrap-clockpicker/bootstrap-clockpicker.min.css')}}" rel="stylesheet" type="text/css" media="screen"/>
	<link href="{{asset('plugins/bootstrap-datepicker/css/datepicker.min.css')}}" rel="stylesheet" type="text/css" media="screen"/>
	<link href="{{asset('plugins/bootstrap-tag/bootstrap-tagsinput.min.css')}}" rel="stylesheet" type="text/css" media="screen"/>

	<!-- CSS PROPIOS -->
	<link href="{{asset('/css/plugins/sweetalert.min.css')}}" rel="stylesheet" type="text/css"/>
	<link href="{{asset('/css/plugins/croppie.css')}}" rel="stylesheet" type="text/css"/>
	<link href="{{asset('/css/custom.css')}}" rel="stylesheet" type="text/css"/>
	<link href="{{asset('/css/plugins/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
	<script src="{{asset('/plugins/jquery-1.8.3.min.js')}}" type="text/javascript"></script>
</head>
<body>

<div class="container-fluid content-body">
	<div class="page-title">
		{{-- <h1>Guardar <span class="semi-bold">Prospecto</span></h1> --}}
	</div>
	<div class="row-fluid">
        <form id="form-data" class="valid ajax-plus" action="{{url('apiv1/guardar-prospecto')}}" onsubmit="return false;" enctype="multipart/form-data" method="POST" autocomplete="off" data-ajax-type="ajax-form" data-column="0" data-refresh="0" data-redirect="" data-table_id="example3" data-container_id="table-container">
	        <div>
	        	<h3>Buscar disponibilidad de oficina</h3>
	        	<div class="row">
	        	 	<div class="form-group col-sm-6 col-xs-12 hide">
		                <label class="required" for="id">ID</label>
		                <input type="text" class="form-control" name="id">
		            </div>
	        	</div>
	        	{{-- Application details data --}}
	        	<div class="row">
	        		<div class="form-group col-sm-12 col-xs-12">
	                    <label class="required" for="badget">Presupuesto del cliente</label>
	                    <input type="text" class="form-control not-empty execute-search numeric" name="badget" data-name="Presupuesto">
	                </div>
	        	</div>
	        	<div class="row">
	        		<div class="form-group col-sm-12 col-xs-12">
	                    <label class="required" for="num_people">Número de personas</label>
	                    <input type="text" class="form-control not-empty execute-search numeric" name="num_people" data-name="Número de personas">
	                </div>
	        	</div>
	        	<div class="row">
	        		<div class="form-group col-sm-12 col-xs-12">
	                    <label class="required" for="state_id">Estado</label>
		                <select name="state_id" id="state_id" class="form-control not-empty" data-name="Estado">
		                    <option value="" disabled selected>Seleccione una opción</option>
	                        @foreach($states as $state)
	                            <option value="{{$state->id}}">{{$state->name}}</option>
	                        @endforeach
		                </select>
	                </div>
	        	</div>
	        	<div class="row">
	        		<div class="form-group col-sm-12 col-xs-12">
	                    <label class="required" for="office_type_id">Tipo de oficina</label>
		                <select name="office_type_id" id="office_type_id" class="form-control not-empty" data-name="Tipo de oficina">
		                    <option value="" disabled selected>Seleccione una opción</option>
	                        @foreach($officeTypes as $type)
	                            <option value="{{$type->id}}">{{$type->name}}</option>
	                        @endforeach
		                </select>
	                </div>
	        	</div>

	        	<div class="row">
		        	<div class="form-group col-md-12 col-xs-12">
			        	<button type="button" class="btn btn-primary search">Buscar oficinas</button>
			            <button type="button" class="btn btn-default reset-select">Reiniciar filtros</button>
					</div>
	        	</div>

	        	<div class="row">
		        	<div class="form-group col-md-12 col-xs-12">
		                <label class="required" for="office_id">Oficina</label>
		                <select name="office_id" id="office_id" class="form-control not-empty" data-name="Oficina">
		                    <option value="" disabled selected>Seleccione una opción</option>
		                </select>
		            </div>
	        	</div>
	        </div>

        	<hr>

        	<h3>Datos personales</h3>
        	{{-- Application data --}}
        	
        	<div class="row">
        		<div class="form-group col-sm-12 col-xs-12">
                    <label class="required" for="fullname">Nombre completo</label>
                    <input type="text" class="form-control not-empty" name="fullname" data-name="Nombre completo">
                </div>
        	</div>
        	<div class="row">
        		<div class="form-group col-sm-12 col-xs-12">
                    <label class="required" for="email">Correo</label>
                    <input type="text" class="form-control email not-empty" name="email" data-name="Correo">
                </div>
        	</div>
        	<div class="row">
        		<div class="form-group col-sm-12 col-xs-12">
                    <label class="required" for="phone">Teléfono</label>
                    <input type="text" class="form-control numeric not-empty" name="phone" data-name="Teléfono">
                </div>
        	</div>
        	<div class="row">
                <div class="form-group col-sm-12 col-xs-12">
                    <label for="rfc">RFC</label>
                    <input type="text" class="form-control rfc" name="rfc" data-name="RFC">
                </div>
        	</div>
            <button type="submit" class="btn btn-success guardar" data-target="form-data">Guardar</button>
        </form>
	</div>
</div>
<script src="{{asset('/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('plugins/boostrapv3/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{asset('/plugins/breakpoints.js')}}" type="text/javascript"></script>
<script src="{{asset('/plugins/jquery-unveil/jquery.unveil.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/plugins/jquery-block-ui/jqueryblockui.js')}}" type="text/javascript"></script>
<!-- END CORE JS FRAMEWORK -->
<!-- BEGIN PAGE LEVEL JS -->
<script src="{{asset('/plugins/jquery-scrollbar/jquery.scrollbar.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/plugins/pace/pace.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/plugins/jquery-numberAnimate/jquery.animateNumbers.js')}}" type="text/javascript"></script>
<script src="{{asset('/plugins/select2/select2.min.js')}}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN CORE TEMPLATE JS -->
<script src="{{asset('/js/core.js')}}" type="text/javascript"></script>

<!-- JS PROPIOS -->
<script src="{{asset('/js/plugins/sweetalert.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/js/validForm.js')}}" type="text/javascript"></script>
<script src="{{asset('/js/generalAjax.js')}}" type="text/javascript"></script>
<!-- END CORE TEMPLATE JS -->
<script type="text/javascript">
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
	$(function() {
		$('.search').on('click', function() {
			config = {
                'badget'         : $('#badget').val(),
                'num_people'     : $('#num_people').val(),
                'office_type_id' : $('#office_type_id').val(),
                'state_id'		 : $('#state_id').val(),
                'route'          : "{{url('apiv1/filtrar-oficinas')}}",
                'method'         : 'POST',
                'callback'       : 'fill_prospect_offices',
            }

			loadAnimation('Buscando oficinas...');
            ajaxSimple(config);
		});

		$(".execute-search").keydown(function (e) {
		  	if (e.keyCode == 13) {
		    	$('button.search').click();
		  	}
		});

		$('.reset-select').on('click', function() {
			$('#badget, #num_people').val('');
			$('#office_type_id').val(0);
			clearSelect($('#office_id'), true);
		});

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
	});
</script>
</body>
</html>