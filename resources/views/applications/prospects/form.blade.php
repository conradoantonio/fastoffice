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
        <form id="form-data" class="valid ajax-plus" action="{{url('crm/prospectos')}}/{{$prospect ? 'actualizar-prospecto' : 'guardar-prospecto'}}" onsubmit="return false;" enctype="multipart/form-data" method="POST" autocomplete="off" data-ajax-type="ajax-form" data-column="0" data-refresh="0" data-redirect="1" data-table_id="example3" data-container_id="table-container">
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
	                    <label class="required" for="branch_id">Franquicia</label>
		                <select name="branch_id" id="branch_id" class="form-control select2" data-name="Franquicia">
		                    <option value="" selected>MOSTRAR TODAS</option>
	                        @foreach($branches as $branch)
	                            <option value="{{$branch->id}}">{{$branch->name}}</option>
	                        @endforeach
		                </select>
	                </div>
	        	</div>
	        	<div class="row">
	        		<div class="form-group col-sm-12 col-xs-12">
	                    <label class="required" for="state_id">Estado</label>
		                <select name="state_id" id="state_id" class="form-control not-empty select2" data-name="Estado">
		                    <option value="" disabled selected>SELECCIONE UNA OPCIÓN</option>
		                    @if ($prospect)
		                        @foreach($states as $state)
		                            <option value="{{$state->id}}" {{$prospect->detail->state_id == $state->id ? 'selected' : ''}}>{{$state->name}}</option>
		                        @endforeach
		                    @else
		                        @foreach($states as $state)
		                            <option value="{{$state->id}}">{{$state->name}}</option>
		                        @endforeach
		                    @endif
		                </select>
	                </div>
	        	</div>
	        	<div class="row">
	        		<div class="form-group col-sm-12 col-xs-12">
	                    <label class="required" for="office_type_id">Tipo de oficina</label>
		                <select name="office_type_id" id="office_type_id" class="form-control not-empty select2" data-name="Tipo de oficina">
		                    <option value="" disabled selected>SELECCIONE UNA OPCIÓN</option>
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
		                <select name="office_id" id="office_id" class="form-control not-empty select2" data-name="Oficina">
		                    <option value="" disabled selected>SELECCIONE UNA OPCIÓN</option>
		                    @if ($prospect)
		                        @foreach($offices as $office)
		                            <option value="{{$office->id}}" {{$prospect->office_id == $office->id ? 'selected' : ''}}>{{$office->name}} ubicada en {{$office->address}} (Precio: ${{$office->price}})</option>
		                        @endforeach
		                    {{-- @else
		                        @foreach($offices as $office)
		                            <option value="{{$office->id}}">{{$office->name}}</option>
		                        @endforeach --}}
		                    @endif
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
	                <select name="user_id" id="user_id" class="form-control select2" data-name="Cliente">
	                    <option value="0" selected>Seleccione una opción</option>
	                    @if ($prospect)
	                        @foreach($customers as $customer)
	                            <option value="{{$customer->id}}" {{$prospect->user_id == $customer->id ? 'selected' : ''}}>{{$customer->fullname}} ({{$customer->email}} - {{$customer->rfc}})</option>
	                        @endforeach
	                    @else
	                        @foreach($customers as $customer)
	                            <option value="{{$customer->id}}">{{$customer->fullname}} ({{$customer->email}} - {{$customer->rfc}})</option>
	                        @endforeach
	                    @endif
	                </select>
	            </div>
        	</div>
        	<div class="row {{($prospect ? ($prospect->customer ? 'hide' : '') : '')}}">
        		<div class="form-group col-sm-12 col-xs-12">
                    <label class="required" for="fullname">Nombre completo</label>
                    <input type="text" class="form-control upper {{($prospect ? ($prospect->customer ? '' : 'not-empty') : 'not-empty')}}" value="{{$prospect ? $prospect->fullname : ''}}" id="fullname" name="fullname" data-name="Nombre completo">
                </div>
        	</div>
        	<div class="row {{($prospect ? ($prospect->customer ? 'hide' : '') : '')}}">
        		<div class="form-group col-sm-12 col-xs-12">
                    <label class="required" for="email">Correo</label>
                    <input type="text" class="form-control {{($prospect ? ($prospect->customer ? '' : 'email not-empty') : 'email not-empty')}}" value="{{$prospect ? $prospect->email : ''}}" id="email" name="email" data-name="Correo">
                </div>
        	</div>
        	<div class="row {{($prospect ? ($prospect->customer ? 'hide' : '') : '')}}">
        		<div class="form-group col-sm-12 col-xs-12">
                    <label class="required" for="phone">Teléfono</label>
                    <input type="text" class="form-control {{($prospect ? ($prospect->customer ? '' : 'numeric not-empty') : 'numeric not-empty')}}" value="{{$prospect ? $prospect->phone : ''}}" id="phone" name="phone" data-name="Teléfono">
                </div>
        	</div>
        	<div class="row {{($prospect ? ($prospect->customer ? 'hide' : '') : '')}}">
                <div class="form-group col-sm-12 col-xs-12">
                    <label for="rfc">RFC</label>
                    <input type="text" class="form-control upper {{($prospect ? ($prospect->customer ? '' : 'rfc') : 'rfc')}}" value="{{$prospect ? $prospect->rfc : ''}}" id="rfc" name="rfc" data-name="RFC">
                </div>
        	</div>
        	<div class="row {{($prospect ? ($prospect->customer ? 'hide' : '') : '')}}">
        		<div class="form-group col-sm-12 col-xs-12">
                    <label class="" for="address">Dirección</label>
                    <input type="text" class="form-control upper" value="{{$prospect ? $prospect->address : ''}}" id="address" name="address" data-name="Dirección">
                </div>
        	</div>
        	<div class="row {{($prospect ? ($prospect->customer ? 'hide' : '') : '')}}">
        		<div class="form-group col-sm-12 col-xs-12">
                    <label class="" for="business_activity">Giro empresarial</label>
                    <input type="text" class="form-control upper" value="{{$prospect ? $prospect->business_activity : ''}}" id="business_activity" name="business_activity" data-name="Giro empresarial">
                </div>
        	</div>
        	<div class="row">
        		<div class="{{($prospect ? ($prospect->customer ? 'hide' : '') : '')}}">
	        		<div class="form-group col-sm-6 col-xs-12">
	                    <label class="" for="identification_type">Tipo de identificación</label>
	                    <input type="text" class="form-control upper" value="{{$prospect ? $prospect->identification_type : ''}}" id="identification_type" name="identification_type" data-name="Tipo de identificación">
	                </div>
	        	</div>
	        	<div class="{{($prospect ? ($prospect->customer ? 'hide' : '') : '')}}">
	        		<div class="form-group col-sm-6 col-xs-12">
	                    <label class="" for="identification_num">Número de identificación</label>
	                    <input type="text" class="form-control upper" value="{{$prospect ? $prospect->identification_num : ''}}" id="identification_num" name="identification_num" data-name="Número de identificación">
	                </div>
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
					$('#fullname, #email, #phone, #rfc').addClass('not-empty');
					$('#email').addClass('email');
					$('#rfc').addClass('rfc');
					$('#fullname, #email, #phone, #rfc, #address, #business_activity, #identification_type, #identification_num').parent().parent().removeClass('hide');
				} else {
					$('#fullname, #email, #phone, #rfc').removeClass('not-empty');
					$('#email').removeClass('email');
					$('#rfc').removeClass('rfc');
					$('#fullname, #email, #phone, #rfc, #address, #business_activity, #identification_type, #identification_num').parent().parent().addClass('hide');
				}
			});

			$('.search').on('click', function() {
				config = {
                    'badget'         : $('#badget').val(),
                    'num_people'     : $('#num_people').val(),
                    'office_type_id' : $('#office_type_id').val(),
                    'state_id'		 : $('#state_id').val(),
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
