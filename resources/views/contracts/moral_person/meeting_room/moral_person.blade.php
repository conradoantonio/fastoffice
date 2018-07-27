<!DOCTYPE html>
<html>
<head>
	<title>Contrato para sala de juntas de persona moral a persona moral</title>
	<link rel="stylesheet" type="text/css" href="{{asset('css/contracts_pdf.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('css/bootstrapv4.min.css')}}">
	{{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous"> --}}
</head>

{{-- <body> --}}
<div class="fixed-top">
	<img class="logo" src="{{asset('img/fa_of_logo.png')}}">
</div>
<div class="fixed-middle">
	<img class="water-mark" src="{{asset('img/fa_icon.png')}}">
</div>
<div class="start-page">
	@include('contracts.layouts.prefix')
		
	<br>
	@include('contracts.layouts.statements')

	<br>
	<p class="bold center">CLÁUSULAS</p>
	<p class="break justify bold">1. Duración:</p>
	<ul class="b-up-alpha less-li-he justify">
		<li>Este contrato inicia su vigencia el día {{strftime('%d', strtotime($contract->start_date_validity))}} de {{strtoupper(strftime('%B', strtotime($contract->start_date_validity)))}} del {{strftime('%Y', strtotime($contract->start_date_validity))}} y finaliza el {{strftime('%d', strtotime($contract->end_date_validity))}} de {{strtoupper(strftime('%B', strtotime($contract->end_date_validity)))}} del {{strftime('%Y', strtotime($contract->end_date_validity))}}.</li>
		<li>Horario: {{$contract->start_hour.' - '.$contract->end_hour}}</li>
		<li>Total de horas contratadas: {{$contract->total_hours}}</li>
	</ul>

	<br>
	<p class="break justify bold">2. Contraprestaciones:</p>
	<ul class="b-up-alpha less-li-he justify">
		<li class="one-line-sp">“EL CLIENTE” se obliga a pagar a “EL PRESTADOR” por concepto de prestación de servicios de este contrato y validando la promoción de pronto pago la cantidad por hora de ${{$contract->office->price}} ({{$contract->monthly_payment_str}}) la cual será válida realizando el pago el día puntual de la fecha de contratación.</li>
	</ul>

	<br>
	<p class="break justify bold">3. Obligaciones de EL PRESTADOR de servicios:</p>
	<ul class="b-up-alpha less-li-he justify">
		<li class="one-line-sp">De los servicios en general:
			<ul class="no-style no-padding no-margin">
				<li>“EL PRESTADOR” se obliga a mantener disponibles para “EL CLIENTE” los servicios siguientes:</li>
				<li><br></li>
				<li>A-1) Sala de juntas amueblada para {{$contract->office->num_people}} personas. </li>
				<li>A-2) servicios de energía eléctrica, agua potable, limpieza.</li>
				<li>A-3) recepción de llamadas, mensajes, correspondencia en horario de (lunes a viernes de 9:00 am a 3:00 pm – 4:00 pm a 7:00 pm y sábados 9:00 am a 2:00 pm)</li>
				<li>A-4) internet inalámbrico</li>
				<li>A-5) servicio de impresora, copiadora (costo adicional)</li>
				<li><br></li>
				<li>Cada uno de los anteriores puntos es un servicio prestado por “EL PRESTADOR” de acuerdo al objeto de este contrato.</li>
			</ul>
		</li>
		<li class="one-line-sp">“EL PRESTADOR” otorga en prestación de servicios la sala de juntas en {{$contract->office->address}} en {{$contract->office->municipality->name.' '.$contract->office->state->name}}.</li>
		<li class="one-line-sp">El servicio de prestación de servicios de sala de juntas, se prestará únicamente a “EL CLIENTE” contratante y los clientes que “EL CLIENTE” asigne.</li>
	</ul>

	<div class="new-page"></div>
	<br><br>

	<p class="break justify bold">4. Obligaciones de “EL CLIENTE”:</p>
	<ul class="b-up-alpha less-li-he justify">
		<li class="one-line-sp">“EL CLIENTE” se compromete a no fumar dentro de las instalaciones, no introducir animales, combustibles o cualquier otra sustancia que pueda provocar algún percance.</li>
		<li class="one-line-sp">Los empleados e invitados de “EL CLIENTE” se comportarán de una manera apropiada para el entorno de negocios; en todo momento deberán de vestirse de manera adecuada para negocios; el nivel de ruido se mantendrá en un nivel adecuado para no interferir con el ambiente de trabajo de los demás y “EL CLIENTE” cumplirá con las directivas de “EL PRESTADOR” con respecto a la seguridad, llaves, estacionamiento, no fumar dentro del establecimiento, así como también no ingerir o introducir bebidas alcohólicas y otros asuntos comunes para todos los ocupantes.</li>
		<li class="one-line-sp">“EL CLIENTE” no podrá realizar negocios en los pasillos, área de recepción o alguna otra área excepto en su oficina designada sin la previa autorización escrita de “EL PRESTADOR”.</li>
		<li class="one-line-sp">“EL CLIENTE” o sus funcionarios, directores, empleados, accionistas, socios, agentes, representantes, contratistas, de cualquier clase de acoso o comportamiento de índoles hostil, discriminatoria o abusiva, ya sea físico o verbal, hacia los integrantes de “EL PRESTADOR”, otros clientes o sus invitados que se encuentren en el centro de negocios. Toda violación de esta regla se considerará un incumplimiento de su contrato (sin posibilidad de ser subsanado) y, en consecuencia, su contrato podrá ser rescindido de inmediato y los servicios podrán ser suspendidos sin previo aviso.</li>
		<li class="one-line-sp">“EL CLIENTE” está obligado a entregar documentación oficial (IFE-INE, pasaporte o cedula profesional) de cada uno de los empleados que laboren en la ubicación señalada en este contrato por “EL PRESTADOR”.</li>
		<li class="one-line-sp">Queda prohibido para “EL CLIENTE” mantener sonidos o música a alto volumen que pueda molestar a los demás clientes, así mismo, deberá evitarse la permanencia de niños dentro de las instalaciones, en caso contrario, “EL CLIENTE” será responsable de los percances que pudieran provocar ya sea al mobiliario o a los demás clientes de las oficinas.</li>
		<li class="one-line-sp">“EL CLIENTE” se obliga a conservar el buen estado del inmueble y dar aviso de cualquier situación que pudiera afectar al mismo, de lo contrario se hará responsable de los daños y perjuicios que pudieran ocasionarse por tal motivo</li>
	</ul>

	<p class="break justify bold">5. Depósito en garantía:</p>
	<ul class="b-up-alpha less-li-he justify">
		<li class="one-line-sp">“EL CLIENTE” entrega en este acto la suma de ${{$contract->office->price}} ({{$contract->monthly_payment_str}}), cantidad que “EL PRESTADOR” conservará en depósito hasta la terminación del presente contrato y queda autorizado para aplicar dicha cantidad al pago de saldos insolutos que “EL CLIENTE” pudiera adeudar. En caso de que “EL CLIENTE” no adeude cantidad alguna, la suma depositada en garantía le será devuelta sin necesidad de ningún trámite adicional.</li>
	</ul>

	@include('contracts.layouts.clause_6')

	<div class="new-page"></div>
	<br><br><br>
	
	@include('contracts.layouts.clause_9')

	@include('contracts.layouts.signatures')

	<div class="new-page"></div>
	
	@include('contracts.layouts.appendix')
</div>

{{-- </body> --}}
@include('contracts.layouts.footer')
</html>
