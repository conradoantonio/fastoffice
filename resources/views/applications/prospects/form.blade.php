@extends('layouts.main')
@section('pageTitle', 'Erp')
@section('content')
<div class="container-fluid content-body">
	@if(session('msg'))
	<div class="alert alert-danger">
		{{session('msg')}}
	</div>
	@endif
	<div class="page-title">
		<h1>{{$prospect ? 'Actualizar' : 'Crear'}} <span class="semi-bold">Prospecto</span></h1>
	</div>
	<div class="row-fluid">
        <form id="form-data" class="valid ajax-plus" action="{{url('crm/prospectos/guardar-prospecto')}}" onsubmit="return false;" enctype="multipart/form-data" method="POST" autocomplete="off" data-ajax-type="ajax-form" data-column="0" data-refresh="0" data-redirect="1" data-table_id="example3" data-container_id="table-container">
	        <div>
	        	<h3>Buscar disponibilidad de oficina</h3>
	        	<div class="row">
	        	 	<div class="form-group col-sm-6 col-xs-12 hide">
		                <label class="required" for="id">ID</label>
		                <input type="text" class="form-control" value="{{$prospect ? $prospect->id : ''}}" id="id" name="id">
		            </div>
	        	</div>
	        	{{-- Application details data --}}
	        	<div class="row">
	        		<div class="form-group col-sm-12 col-xs-12">
	                    <label class="required" for="badget">Presupuesto del cliente</label>
	                    <input type="text" class="form-control not-empty execute-search numeric" value="{{$prospect ? $prospect->detail->badget : ''}}" id="badget" name="badget" data-name="Presupuesto">
	                </div>
	        	</div>
	        	<div class="row">
	        		<div class="form-group col-sm-12 col-xs-12">
	                    <label class="required" for="num_people">Número de personas</label>
	                    <input type="text" class="form-control not-empty execute-search numeric" value="{{$prospect ? $prospect->detail->num_people : ''}}" id="num_people" name="num_people" data-name="Número de personas">
	                </div>
	        	</div>
	        	<div class="row">
	        		<div class="form-group col-sm-12 col-xs-12">
	                    <label class="required" for="office_type_id">Tipo de oficina</label>
		                <select name="office_type_id" id="office_type_id" class="form-control not-empty" data-name="Tipo de oficina">
		                    <option value="0" disabled selected>Seleccione una opción</option>
		                    @if ($prospect)
		                        @foreach($officeTypes as $type)
		                            <option value="{{$type->id}}" {{$prospect->detail->office_type_id == $type->id ? 'selected' : ''}}>{{$type->name}}</option>
		                        @endforeach
		                    @else
		                        @foreach($officeTypes as $type)
		                            <option value="{{$type->id}}">{{$type->name}}</option>
		                        @endforeach
		                    @endif
		                </select>
	                </div>
	        	</div>
	        	<div class="row">
		        	<div class="form-group col-md-12 col-xs-12">
		                <label class="required" for="office_id">Oficina</label>
		                <select name="office_id" id="office_id" class="form-control not-empty" data-name="Oficina">
		                    <option value="0" disabled selected>Seleccione una opción</option>
		                    {{-- @if ($prospect)
		                        @foreach($offices as $office)
		                            <option value="{{$office->id}}" {{$prospect->office_id == $office->id ? 'selected' : ''}}>{{$office->name}}</option>
		                        @endforeach
		                    @else
		                        @foreach($offices as $office)
		                            <option value="{{$office->id}}">{{$office->name}}</option>
		                        @endforeach
		                    @endif --}}
		                </select>
		            </div>
	        	</div>

	            <button type="button" class="btn btn-primary search">Buscar oficinas</button>
	            <button type="button" class="btn btn-default reset-select">Reiniciar filtros</button>
	        </div>

        	<hr>

        	<h3>Datos de cliente</h3>
        	{{-- Application data --}}
        	<div class="row">
	        	<div class="form-group col-md-12 col-xs-12">
	                <label class="" for="user_id">Cliente</label>
	                <select name="user_id" id="user_id" class="form-control" data-name="Cliente">
	                    <option value="0" selected>Seleccione una opción</option>
	                    @if ($prospect)
	                        @foreach($customers as $customer)
	                            <option value="{{$customer->id}}" {{$prospect->user_id == $customer->id ? 'selected' : ''}}>{{$customer->fullname}}</option>
	                        @endforeach
	                    @else
	                        @foreach($customers as $customer)
	                            <option value="{{$customer->id}}">{{$customer->fullname}}</option>
	                        @endforeach
	                    @endif
	                </select>
	            </div>
        	</div>
        	<div class="row">
        		<div class="form-group col-sm-12 col-xs-12">
                    <label class="required" for="fullname">Nombre completo</label>
                    <input type="text" class="form-control not-empty" value="{{$prospect ? $prospect->fullname : ''}}" id="fullname" name="fullname" data-name="Nombre completo">
                </div>
        	</div>
        	<div class="row">
        		<div class="form-group col-sm-12 col-xs-12">
                    <label class="required" for="email">Correo</label>
                    <input type="text" class="form-control email not-empty" value="{{$prospect ? $prospect->email : ''}}" id="email" name="email" data-name="Correo">
                </div>
        	</div>
        	<div class="row">
        		<div class="form-group col-sm-12 col-xs-12">
                    <label class="required" for="phone">Teléfono</label>
                    <input type="text" class="form-control not-empty numeric" value="{{$prospect ? $prospect->phone : ''}}" id="phone" name="phone" data-name="Teléfono">
                </div>
        	</div>
        	<div class="row">
        		<div class="form-group col-sm-6 col-xs-12">
                    <label class="required" for="regime">Régimen</label>
	                <select id="regime" name="regime" class="form-control not-empty" data-name="Régimen">
	                    <option value="0" selected>Seleccione una opción</option>
	                    <option value="Persona física" {{($prospect ? ($prospect->regime == 'Persona física' ? 'selected' : '') : '')}}>Persona física</option>
	                    <option value="Persona moral" {{($prospect ? ($prospect->regime == 'Persona moral' ? 'selected' : '') : '')}}>Persona moral</option>
	                </select>
                </div>
                <div class="form-group col-sm-6 col-xs-12">
                    <label class="required" for="rfc">RFC</label>
                    <input type="text" class="form-control not-empty rfc" value="{{$prospect ? $prospect->rfc : ''}}" id="rfc" name="rfc" data-name="RFC">
                </div>
        	</div>
        	<a href="{{route('Crm.prospects')}}"><button type="button" class="btn btn-danger">Regresar</button></a>
            <button type="submit" class="btn btn-success guardar" data-target="form-data">Guardar</button>
        </form>
	</div>
</div>
@push('scripts')
	<script type="text/javascript">
		$(function() {
			$('select#user_id').on('change', function() {
				if ($(this).val() == 0) {
					console.log('borra la clase');
					$('#fullname, #email, #phone, #rfc, #regime').addClass('not-empty');
					$('#email').addClass('email');
					$('#rfc').addClass('rfc');
					$('#fullname, #email, #phone, #rfc, #regime').parent().parent().removeClass('hide');
				} else {
					$('#fullname, #email, #phone, #rfc, #regime').removeClass('not-empty');
					$('#email').removeClass('email');
					$('#rfc').removeClass('rfc');
					$('#fullname, #email, #phone, #rfc, #regime').parent().parent().addClass('hide');
					console.log('agrega la clase');
				}
			});

			$('.search').on('click', function() {
				config = {
                    'badget'         : $('#badget').val(),
                    'num_people'     : $('#num_people').val(),
                    'office_type_id' : $('#office_type_id').val(),
                    'route'          : "{{route('Crm.prospects.filter_offices')}}",
                    'method'         : 'POST',
                    'callback'       : 'fill_prospect_offices',
                }

				loadAnimation('Buscando oficinas...');
                ajaxSimple(config);
			});

			/*$('#badget, #num_people').on('blur', function() {
				if (!$('#badget').val() || !$('#num_people').val()) {
					clearSelect($('#office_id'), true);
				}
			});

			$('#office_type_id').on('change', function() {
				clearSelect($('#office_id'), true);
			});*/

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
		});
	</script>
@endpush
@endsection
