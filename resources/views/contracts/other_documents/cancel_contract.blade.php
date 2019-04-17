<!DOCTYPE html>
<html>
<head>
	<title>Documento de cancelación</title>
	<link rel="stylesheet" type="text/css" href="{{asset('css/cancel_contract.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('css/bootstrapv4.min.css')}}">
</head>
<div class="fixed-middle">
	<img class="water-mark" src="{{asset('img/fa_icon.png')}}">
</div>
<div class="start-page border">
	<div class="{{-- fixed-top --}}">
		<img class="logo-big" src="{{asset('img/fa_of_logo.png')}}">
	</div>
	<div class="container">
		<p class="break bold center">CARTA DE TERMINACIÓN DE CONTRATO</p>
		<br>

		<p class="break right">{{$contract->office->branch->municipality->name}} {{$contract->office->branch->state->name}} {{strftime('%d', strtotime($contract->cancelation->created_at))}} de {{strftime('%B', strtotime($contract->cancelation->created_at))}} del año {{strftime('%Y', strtotime($contract->cancelation->created_at))}}</p>
		
		<br><br>

		<span class="break justify">Atención <span class="bold underline uppercase">{{$contract->office->branch->user->fullname}}</span> </span>

		<br>
		<p class="justify less-li-he">
			A través de este documento damos por terminado de común acuerdo el contrato de prestación de servicios que tenemos celebrado en {{$contract->office->branch->address}}, 
			bajo la denominación de {{$contract->customer->fullname}} y {{$contract->office->branch->user->fullname}} 
			mismo que vence el próximo {{strftime('%d', strtotime($contract->end_date_validity))}} de {{strftime('%B', strtotime($contract->end_date_validity))}} del {{strftime('%Y', strtotime($contract->end_date_validity))}}.
		</p>

		<br>
		<p class="justify less-li-he">
			De la misma manera acuerdan las partes que no existe ningún adeudo bajo ningún concepto derivado de la firma de este contrato y servicios adicionales 
			y libero al prestador de cualquier responsabilidad de esta naturaleza por lo que me comprometo a presentar una copia del trámite de baja o cambio de 
			domicilio ante el SAT (en caso de estar registrado) y entregar comprobantes de no adeudo en servicios adicionales que contraté por mi cuenta (teléfonos, etc en caso de tenerlos).
		</p>

		<br>

		<p class="break center">Atentamente:</p>

		<br><br>
			<div class="signature signature-fs uppercase center">
				<br><br>
				____________________________<br>
		        <span>{{$contract->office->branch->user->fullname}}</span>
			</div>
			<div class="signature signature-fs uppercase center">
				<br><br>
				____________________________<br>
				<span class="">{{$contract->customer->fullname}}</span>
			</div>
		
		<br><br><br><br><br>
	</div>
</div>
</html>
