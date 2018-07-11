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
		<br>
		<p class="break bold center">RECIBO DE DINERO</p>
		<br>
		<br>
		<br>
		<br>
		<p class="break justify uppercase">RECIBÍ DE: (NOMBRE DE CLIENTE O RAZON SOCIAL)</p>
		<br>
		<p class="break justify uppercase">RECIBÍ DE: (NOMBRE DE CLIENTE O RAZON SOCIAL)</p>
		<p class="break bold center">DECLARACIONES:</p>
		<br>
		<p class="break justify">I.<span class="white-space-5">DECLARA “EL PRESTADOR”</span></p>
		<ul class="b-up-alpha justify">
			<li class="one-line-sp">Es una persona física con actividad empresarial, mayor de edad con facultad para suscribir el presente instrumento y que representa en este acto para identificarse con la credencial del Instituto Federal Electoral número {{$contract->provider_ine_number}}.</li>
			<li class="one-line-sp">Que se encuentra autorizado para disponer del bien inmueble para oficinas de representación comercial que se ubica en {{$contract->office->address}} en <span class="capitalize">{{$contract->office->municipality->name}} {{$contract->office->state->name}}</span></li>
			<li class="one-line-sp">Que señala como domicilio para efectos de este contrato, el ubicado en el domicilio de {{$contract->office->address}} en {{$contract->office->municipality->name}} {{$contract->office->state->name}}</li>
			<li class="one-line-sp">Que tiene como registro federal de contribuyentes: {{$contract->office->branch->user->rfc}}</li>
		</ul>

		<br>
		<p class="break justify">II.<span class="white-space-5">DECLARA “EL CLIENTE”</span></p>
		<ul class="b-up-alpha justify">
			<li class="one-line-sp">Que es una persona física con actividad empresarial, mayor de edad, con facultad para suscribir el presente instrumento y que presenta en este acto para identificarse la credencial del instituto federal electoral con número {{$contract->customer_ine_number}}</li>
			<li class="one-line-sp">Que su primordial actividad es la siguiente: {{$contract->customer_activity}}.</li>
			<li class="one-line-sp">Que señala como domicilio para efectos de este contrato, el ubicado en {{$contract->office->address}} <span class="capitalize">{{$contract->office->municipality->name}} {{$contract->office->state->name}}</span>.</li>
			<li class="one-line-sp">Que tiene como registro federal de contribuyentes: {{$contract->customer_ine_number}}.</li>
		</ul>
	</div>
</div>
</html>

