@extends('layouts.main')
@section('pageTitle', 'Documentacion')
@section('content')
<div class="container-fluid content-body">
	<div class="page-title">
		<h1>Enviar <span class="semi-bold">Documentos</span></h1>
	</div>
	<div class="row-fluid">
		@if(session('msg'))
		<div class="alert alert-info">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
			{{session('msg')}}
		</div>
		@endif
		<table class="table text-center table-bordered" style="margin-bottom: 5%">
			<thead>
				<th>Identificación</th>
				<th>Tarjeta de circulación</th>
				<th>Póliza de seguro</th>
				<th>Factura</th>
				<th>Endoso de factura</th>
			</thead>
			<tbody>
				<td>
					@if($user->Identification)
						{{@$user->Identification->status}}
					@endif
				</td>
				<td>
					@if($user->CirculationCard)
						{{ $user->CirculationCard->status }}
					@endif
				</td>
				<td>
					@if($user->InsurancePolicy)
						{{ $user->InsurancePolicy->status }}
					@endif
				</td>
				<td>
					@if($user->Bill)
						{{ $user->Bill->status }}
					@endif
				</td>
				<td>
					@if($user->Endorsement)
						{{ $user->Endorsement->status }}
					@endif
				</td>
			</tbody>
		</table>
		{{ Form::model($user, ['url' => route('Documents.save',$user->id), 'class' => 'form valid', 'id' => 'DocuementsForm' ,'autocomplete' => 'off', 'files' => true]) }}
			@if(!$user->Identification || $user->Identification->status == 'Rechazada' || $user->Identification->status == 'Pendiente')
			<div class="row">
				<div class="form-group col-md-12">
					{{Form::label('identification', 'Identificación (IFE o pasaporte) (jpg, jpeg, png)', ['class' => 'control-label required'])}}
					{{Form::file('identification', ['class' => 'form-control not-empty image', 'data-name' => 'Identificación'])}}
					{{@$user->Identification->comment}}
				</div>
			</div>
			@endif
			@if(!$user->CirculationCard || $user->CirculationCard->status == 'Rechazada' || $user->CirculationCard->status == 'Pendiente' )
			<div class="row">
				<div class="form-group col-md-12">
					{{Form::label('circulation_card', 'Tarjeta de circulación (jpg, jpeg, png)', ['class' => 'control-label required'])}}
					{{Form::file('circulation_card', ['class' => 'form-control not-empty image', 'data-name' => 'Tarjeta de circulación'])}}
					{{@$user->CirculationCard->comment}}
				</div>
			</div>
			@endif
			@if(!$user->InsurancePolicy || $user->InsurancePolicy->status == 'Rechazada' || $user->InsurancePolicy->status == 'Pendiente')
				<div class="row">
					<div class="form-group col-md-12">
						{{Form::label('insurance_policy', 'Póliza de seguro (jpg, jpeg, png)', ['class' => 'control-label required'])}}
						{{Form::file('insurance_policy', ['class' => 'form-control not-empty image', 'data-name' => 'Póliza de seguro'])}}
						{{@$user->InsurancePolicy->comment}}
					</div>
				</div>
			@endif
			@if(!$user->Bill || $user->Bill->status == 'Rechazada' || $user->Bill->status == 'Pendiente')
				<div class="row">
					<div class="form-group col-md-12">
						{{Form::label('bill', 'Factura (jpg, jpeg, png)', ['class' => 'control-label required'])}}
						{{Form::file('bill', ['class' => 'form-control not-empty image', 'data-name' => 'Factura'])}}
						{{@$user->Bill->comment}}
					</div>
				</div>
			@endif
			@if(!$user->Endorsement || $user->Endorsement->status == 'Rechazada' || $user->Endorsement->status == 'Pendiente')
				<div class="row">
					<div class="form-group col-md-12">
						{{Form::label('endorsement', 'Endoso de factura (jpg, jpeg, png)', ['class' => 'control-label required'])}}
						{{Form::file('endorsement', ['class' => 'form-control not-empty image', 'data-name' => 'Endoso de factura'])}}
					</div>
				</div>
			@endif
			<div class="row">
				<h3 class="text-center">Cuenta bancaria</h3>
				<div class="form-group col-md-4">
					{{Form::label('bank_id', 'Banco', ['class' => 'control-label  required'])}}
					{!!Form::select('bank_id', $banks, @$user->bankAccount->bank_id?$user->bankAccount->bank_id:0, ['class' => 'select2 form-control not-empty', 'id' => 'bank_id', 'name' => 'bank_id', 'data-name' => 'Banco'] )!!}
				</div>
				<div class="form-group col-md-4">
					{{Form::label('clabe', 'Clabe', ['class' => 'control-label required with-counter'])}}
					<span class="display-counter"><span class="counter">0</span>/18</span>
					{{Form::text('clabe', @$user->bankAccount->clabe?$user->bankAccount->clabe:null,['class' => 'form-control not-empty numeric length', 'data-name' => "Clabe", 'data-equal' => 18])}}
				</div>
				<div class="form-group col-md-4">
					{{Form::label('account_number', 'Número de cuenta', ['class' => 'control-label required with-counter'])}}
					<span class="display-counter"><span class="counter">0</span>/10</span>
					{{Form::text('account_number', @$user->bankAccount->account_number?$user->bankAccount->account_number:null,['class' => 'form-control not-empty numeric length', 'data-name' => "Número de cuenta", 'data-equal' => 10])}}
				</div>
			</div>
			@if( auth()->user()->confirm == 0 )
				<div class="row col-md-12">
					<div class="checkbox check-info">
						<input id="confirm" name="confirm" type="checkbox" class="not-empty" data-name="Terminos y condiciones" value=1>
						<label for="confirm">Acepto termino y condiciones</label>
					</div>
				</div>
			@endif
			<div class="row buttons-form">
				{{Form::submit('Guardar',['class' => 'btn btn-success guardar', 'data-target' => 'DocuementsForm'])}}
			</div>
		{{ Form::close() }}
	</div>
</div>
<script type="text/javascript">
	$(function(){
		$('#bank_id').select2();
	})
</script>
@endsection
