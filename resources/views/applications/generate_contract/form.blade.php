@extends('layouts.main')
@section('pageTitle', 'CRM')
@section('content')
<div class="container-fluid content-body">
	@if(session('msg'))
	<div class="alert alert-danger">
		{{session('msg')}}
	</div>
	@endif
	<div class="page-title">
		<h1>{{$contract ? 'Generar' : 'Crear'}} <span class="semi-bold">Contrato</span></h1>
	</div>
	<div class="row-fluid">
        <form id="form-data" class="valid ajax-plus" action="{{url('crm/prospectos')}}/{{$contract ? 'actualizar-contrato' : 'guardar-contrato'}}" onsubmit="return false;" enctype="multipart/form-data" method="POST" autocomplete="off" data-ajax-type="ajax-form" data-column="0" data-refresh="0" data-redirect="1" data-table_id="example3" data-container_id="table-container">
        	<div class="row">
        	 	<div class="form-group col-sm-6 col-xs-12 hide">
	                <label class="required" for="id">ID</label>
	                <input type="text" class="form-control" value="{{$contract ? $contract->id : ''}}" id="id" name="id">
	            </div>
        	</div>
        	{{-- Application details data --}}
        	<div class="row">
        	 	<div class="form-group col-sm-6 col-xs-12 hide">
	                <label for="user_id">User ID</label>
	                <input type="text" class="form-control" value="{{$prospect && $prospect->customer ? $prospect->user_id : ''}}" id="user_id" name="user_id">
	            </div>
        	</div>
        	<div class="row">
        	 	<div class="form-group col-sm-6 col-xs-12 hide">
	                <label for="application_id">Application ID</label>
	                <input type="text" class="form-control" value="{{$prospect ? $prospect->id : ''}}" id="application_id" name="application_id">
	            </div>
        	</div>
        	<div class="row">
        	 	<div class="form-group col-sm-6 col-xs-12 hide">
	                <label for="office_id">Office ID</label>
	                <input type="text" class="form-control" value="{{$prospect && $prospect->office ? $prospect->office_id : ''}}" id="office_id" name="office_id">
	            </div>
        	</div>
        	<div class="row">
        		<div class="form-group col-sm-12 col-xs-12">
                    <label class="required" for="contract_date">Fecha de contrato</label>
                    <input type="text" class="form-control input-date-c not-empty" value="{{$contract ? $contract->contract_date : date('Y-m-d')}}" id="contract_date" name="contract_date" data-name="Fecha de contrato">
                </div>
        	</div>
        	<div class="row">
        	 	<div class="form-group col-sm-12 col-xs-12">
	                <label for="office_data">Oficina</label>
	                <input type="text" class="form-control" disabled value="{{$prospect && $prospect->office ? $prospect->office->name. ' ubicada en '. $prospect->office->address : ''}}" id="office_data" name="office_data">
	            </div>
        	</div>
        	<div class="row">
        		<div class="form-group col-sm-12 col-xs-12">
                    <label class="required" for="provider_name">Nombre del prestador</label>
                    <input type="text" class="form-control not-empty" value="{{auth()->user() ? auth()->user()->fullname : ''}}" id="provider_name" name="provider_name" data-name="Nombre de prestador">
                </div>
        	</div>
        	<div class="row">
        		<div class="form-group col-sm-12 col-xs-12">
                    <label class="required" for="customer_ine_number">Número de INE del cliente</label>
                    <input type="text" class="form-control not-empty numeric" value="{{$contract ? $contract->customer_ine_number : ''}}" id="customer_ine_number" name="customer_ine_number" data-name="Número de INE del cliente">
                </div>
        	</div>
        	<div class="row">
        		<div class="form-group col-sm-12 col-xs-12">
                    <label class="required" for="customer_activity">Actividad del cliente</label>
                    <input type="text" class="form-control not-empty" value="{{$contract ? $contract->customer_activity : ''}}" id="customer_activity" name="customer_activity" data-name="Actividad del cliente">
                </div>
        	</div>
        	<div class="row">
        		<div class="form-group col-sm-12 col-xs-12">
                    <label class="required" for="customer_address">Dirección del cliente</label>
                    <input type="text" class="form-control not-empty" value="{{$contract ? $contract->customer_address : ''}}" id="customer_address" name="customer_address" data-name="Dirección del cliente">
                </div>
        	</div>
			<div class="row">
        		<div class="form-group col-sm-12 col-xs-12">
                    <label class="required" for="start_date_validity">Inicio de vigencia del contrato</label>
                    <input type="text" class="form-control input-date-c not-empty" value="{{$contract ? $contract->start_date_validity : date('Y-m-d')}}" id="start_date_validity" name="start_date_validity" data-name="Inicio de vigencia del contrato">
                </div>
        	</div>
        	<div class="row">
        		<div class="form-group col-sm-12 col-xs-12">
                    <label class="required" for="end_date_validity">Fin de vigencia del contrato</label>
                    <input type="text" class="form-control input-date-c not-empty" value="{{$contract ? $contract->end_date_validity : ''}}" id="end_date_validity" name="end_date_validity" data-name="Fin de vigencia del contrato">
                </div>
        	</div>
        	@if($contract)
	        	<div class="row">
	        		<div class="form-group col-sm-6 col-xs-12">
	                    <label class="required" for="payment_range_start">Primer día de pago</label>
	                    <input type="text" class="form-control not-empty" disabled value="{{$contract ? $contract->payment_range_start : ''}}" id="payment_range_start" name="payment_range_start" data-name="Primer día de pago">
	                </div>
	                <div class="form-group col-sm-6 col-xs-12">
	                    <label class="required" for="payment_range_end">Último día de pago</label>
	                    <input type="text" class="form-control not-empty" disabled value="{{$contract ? $contract->payment_range_end : ''}}" id="payment_range_end" name="payment_range_end" data-name="Primer día de pago">
	                </div>
	        	</div>
	        @endif
        	<div class="row">
        		<div class="form-group col-sm-12 col-xs-12">{{-- Don't save in contract --}}
                    <label class="required" for="monthly_payment">Pago mensual $</label>
                    <input type="text" class="form-control not-empty" disabled value="${{$prospect && $prospect->office ? $prospect->office->price : ''}}" id="monthly_payment" name="monthly_payment" data-name="Pago mensual">
                </div>
        	</div>
			<div class="row">
        		<div class="form-group col-sm-12 col-xs-12">
                    <label class="required" for="monthly_payment_str">Pago mensual (en palabras)</label>
                    <input type="text" class="form-control not-empty" value="{{$contract ? $contract->monthly_payment_str : ''}}" id="monthly_payment_str" name="monthly_payment_str" data-name="Pago mensual (en palabras)">
                </div>
        	</div>
        	<div class="row">
        		<div class="form-group col-sm-12 col-xs-12">
                    <label class="required" for="monthly_payment_delay">Pago mensual por atraso $</label>
                    <input type="text" class="form-control not-empty" disabled value="${{$prospect && $prospect->office ? ($prospect->office->price * 1.10) : ''}}" id="monthly_payment_delay" name="monthly_payment_delay" data-name="Pago mensual por atraso $">
                </div>
        	</div>
        	<div class="row">
        		<div class="form-group col-sm-12 col-xs-12">
                    <label class="required" for="monthly_payment_delay_str">Pago mensual por atraso (en palabras)</label>
                    <input type="text" class="form-control not-empty" value="{{$contract ? $contract->monthly_payment_delay_str : ''}}" id="monthly_payment_delay_str" name="monthly_payment_delay_str" data-name="Pago mensual por atraso (en palabras)">
                </div>
        	</div>
        	<hr>

        	<a href="{{route('Crm.prospects')}}"><button type="button" class="btn btn-danger">Regresar</button></a>
            <button type="submit" class="btn btn-success guardar" data-target="form-data">Guardar</button>
        </form>
	</div>
</div>
@push('scripts')
	<script type="text/javascript">
		$(function() {
			$(".input-date-c").datepicker({
				language: 'es',
				autoclose: true,
				todayHighlight: true,
				format: "yyyy-mm-dd",
				clearBtn: true,
			});/*.on('changeDate', function() {
				in_da = $(this);
				if (in_da.attr('id') == 'start_date_validity' && in_da.val() != '') {

					var init_date = in_da.val();
					var fecha = new Date(Date.UTC(init_date.substring(0,4), init_date.substring(5,7), init_date.substring(8,10)));
					var utcTime = fecha.getUTCHours();
					fecha.setHours(utcTime-5);
					console.log(fecha);
					dia_inicio = fecha.getUTCDate();
					var dias = 4;
					//console.warn(fecha.getDate());
					fecha.setDate(fecha.getUTCDate() + dias);
					dia_fin = fecha.getUTCDate();

					$('#payment_range_start').val(dia_inicio);
					$('#payment_range_end').val(dia_fin);
				}
			})*/
		});

	/*$('#start_date_validity').change(function() {
	});*/
	</script>
@endpush
@endsection
