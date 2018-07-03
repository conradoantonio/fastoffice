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
	        	<div class="row">
	        		<div class="form-group col-sm-12 col-xs-12">
	                    <label class="required" for="payment_range">Rango de días para pagar</label>
	                    <input type="text" class="form-control not-empty" value="{{$contract ? $contract->payment_range : ''}}" placeholder="Ej. 15 y 19" id="payment_range" name="payment_range" data-name="Rango de días para pagar">
	                </div>
	        	</div>
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
	                    <input type="text" class="form-control not-empty" value="${{$prospect && $prospect->office ? ($prospect->office->price + 1000) : ''}}" id="monthly_payment_delay" name="monthly_payment_delay" data-name="Pago mensual por atraso $">
	                </div>
	        	</div>
	        	<div class="row">
	        		<div class="form-group col-sm-12 col-xs-12">
	                    <label class="required" for="monthly_payment_delay_str">Pago mensual por atraso (en palabras)</label>
	                    <input type="text" class="form-control not-empty" value="{{$contract ? $contract->monthly_payment_delay_str : ''}}" id="monthly_payment_delay_str" name="monthly_payment_delay_str" data-name="Pago mensual por atraso (en palabras)">
	                </div>
	        	</div>
	        	<div class="row">
	        		<div class="form-group col-sm-12 col-xs-12">
	                    <label class="required" for="guarantee_deposit">Depósito en garantía</label>
	                    <input type="text" class="form-control not-empty" disabled value="${{$prospect && $prospect->office ? $prospect->office->price : ''}}" id="guarantee_deposit" name="guarantee_deposit" data-name="Depósito en garantía $">
	                </div>
	        	</div>
	        	<div class="row">
	        		<div class="form-group col-sm-12 col-xs-12">
	                    <label class="required" for="guarantee_deposit_str">Depósito en garantía (en palabras)</label>
	                    <input type="text" class="form-control not-empty" value="{{$contract ? $contract->guarantee_deposit_str : ''}}" id="guarantee_deposit_str" name="guarantee_deposit_str" data-name="Depósito en garantía (en palabras)">
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
				clearBtn: true
			})
		});
	</script>
@endpush
@endsection
