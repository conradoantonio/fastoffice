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
		<br>
		<br>
		<p class="break bold center underline">RECIBO DE DINERO</p>
		<br>
		<br>
		<br>
		<span class="break justify uppercase">RECIBÍ DE: (NOMBRE DE CLIENTE O RAZON SOCIAL)</span>
		<span class="break justify uppercase">LA CANTIDAD DE $ (CANTIDAD CON NUMEROS) (CANTIDAD CON LETRA PESOS 00/100 MN) </span>
		<span class="break justify uppercase">EN </span>
		<span class="break justify uppercase">POR CONCEPTO DE:  RENTA DE OFICINA NUMERO O LETRA </span>
		<span class="break justify uppercase">DEL CONTRATO DE SERVICIOS A FAVOR DE “EL PRESTADOR” FAST OFFICE & BENS SA DE CV</span>
		<span class="break justify uppercase">SUCURSAL NOMBRE DE LA SUCURSAL</span>
		<span class="break justify uppercase">UBICADA EN:  DOMICILIIO COMPLETO DE SUCURSAL</span>
		<span class="break justify uppercase">CORRESPONDIENTES AL MES DE O MESES: MES QUE “EL CLIENTE” ESTA PAGANDO</span>

		<br><br><br>
		<p class="justify less-li-he note-fs">
			NOTA: “EL CLIENTE” debera conservar este recibo como comprobante de su pago, “EL PRESTADOR” puede solicitar este recibo en cualquier 
			momento como comprobante de su pago, de no contar con este recibo original, su pago no podrá ser abonado correspondientemente y 
			contará como pago no procesado.
		</p>

		<br><br><br>
		<div class="signature uppercase">
			<span class="bold">"EL PRESTADOR"</span>
			<br><br><br>
			_______________________________<br>
	        <span>{{$contract->office->branch->user->fullname}}</span>
		</div>
		<div class="signature uppercase">
			<span class="bold">"EL CLIENTE"</span>
			<br><br><br>
			_______________________________<br>
			<span class="">{{$contract->customer->fullname}}</span>
		</div>
		<br><br><br><br><br><br>
	</div>
</div>
</html>

