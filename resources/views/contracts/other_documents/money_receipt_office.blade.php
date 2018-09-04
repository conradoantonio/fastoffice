<!DOCTYPE html>
<html>
<head>
	<title>Recibo de dinero</title>
	<link rel="stylesheet" type="text/css" href="{{asset('css/payment_receipt.css')}}">
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
		<br><br>

		<p class="break bold center underline">RECIBO DE DINERO</p>
		<br><br><br>

		<span class="break justify uppercase">RECIBÍ DE: <span class="bold">{{$contract->customer->fullname}}</span> </span>
		{{-- Corregir esta cantidad --}}
		<span class="break justify uppercase">LA CANTIDAD DE <span class="bold">${{$status == 2 ? $contract->office->price * 1.10 : $contract->office->price}} ({{$status == 2 ? $contract->monthly_payment_delay_str : $contract->monthly_payment_str}}) </span> </span>
		<span class="break justify uppercase">EN: {{$type_payment}}</span>
		<span class="break justify uppercase">POR CONCEPTO DE:  RENTA DE OFICINA {{$contract->office->name}} </span>
		<span class="break justify uppercase">DEL CONTRATO DE SERVICIOS A FAVOR DE “EL PRESTADOR” {{$contract->office->branch->user->regime == 'Persona moral' ? 'FAST OFFICE & BENS SA DE CV' : $contract->office->branch->user->fullname}}</span>
		<span class="break justify uppercase">SUCURSAL {{$contract->office->branch->name}}</span>
		<span class="break justify uppercase">UBICADA EN:  {{$contract->office->branch->address}} en {{$contract->office->branch->locality}}</span>
		<span class="break justify uppercase">CORRESPONDIENTES AL MES DE {{strftime('%B', strtotime(date('Y-m-d')))}} O MESES QUE “EL CLIENTE” ESTÁ PAGANDO</span>

		<br><br>
		<p class="justify less-li-he note-fs">
			NOTA: “EL CLIENTE” debera conservar este recibo como comprobante de su pago, “EL PRESTADOR” puede solicitar 
			este recibo en cualquier momento como comprobante de su pago, de no contar con este recibo original, su pago no 
			podrá ser abonado correspondientemente y contará como pago no procesado.
		</p>

		<br><br>

		<p class="break left">En {{$contract->office->municipality->name}} {{$contract->office->state->name}} a los {{date('d')}} días del mes {{strftime('%B', strtotime(date('Y-m-d')))}} del año {{date('Y')}}</p>

		<br><br><br><br>
			<div class="signature uppercase center">
				<br><br><br>
				_______________________________<br>
				<span class="bold">Recibí</span><br>
		        <span>{{$contract->office->branch->user->fullname}}</span>
			</div>
			<div class="signature uppercase center">
				<br><br><br>
				_______________________________<br>
				<span class="bold">Conformidad</span><br>
				<span class="">{{$contract->customer->fullname}}</span>
			</div>
		
		<br><br><br><br><br><br><br>
	</div>
</div>
</html>
