<!DOCTYPE html>
<html>
<head>
	<title>Contrato para oficina virtual premium de persona física a persona física</title>
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
		<li class="one-line-sp">Este contrato inicia su vigencia el día {{strftime('%d', strtotime($contract->start_date_validity))}} de {{strtoupper(strftime('%B', strtotime($contract->start_date_validity)))}} del {{strftime('%Y', strtotime($contract->start_date_validity))}} y finaliza el {{strftime('%d', strtotime($contract->end_date_validity))}} de {{strtoupper(strftime('%B', strtotime($contract->end_date_validity)))}} del {{strftime('%Y', strtotime($contract->end_date_validity))}}.</li>
		<li class="one-line-sp">En caso de que “EL CLIENTE” quisiere renovar el presente contrato deberá de dar aviso cuando al menos 60 días anteriores a la fecha de terminación del contrato y deberá de haber cumplido cabalmente con cada una de sus obligaciones establecidas en el presente contrato, además de que se deberá de realizar y formar un nuevo contrato. “EL CLIENTE” tiene conocimiento que estará sujeto a cumplir cualquier otra obligación que “EL PRESTADOR” le estipule en su nuevo contrato.</li>
		<li class="one-line-sp">“EL CLIENTE” acepta que, en caso de no desear la renovación de su contrato, deberá dar aviso por escrito a “EL PRESTADOR” por lo menos 30 días antes del vencimiento de su contrato vigente, de lo contrario, “EL PRESTADOR” tendrá la libertad de aplicar la penalización correspondiente.</li>
		<li class="one-line-sp">Las partes convienen que, al término de la vigencia de este contrato, “EL CLIENTE” sin necesidad de intervención judicial, se obliga a entregar a “EL PRESTADOR” la oficina en las mismas condiciones en que la recibió. si existieran reparaciones mayores al momento de la desocupación, “EL PRESTADOR” las realizará y presentará la factura correspondiente a “EL CLIENTE”, quien se obliga a cubrirla (s) en su totalidad.</li>
	</ul>

	<br>
	<p class="break justify bold">2. Contraprestaciones:</p>
	<ul class="b-up-alpha less-li-he justify">
		<li class="one-line-sp">“EL CLIENTE” se obliga a pagar a “EL PRESTADOR” por concepto de prestación de servicios de este contrato y validando la promoción de pronto pago la cantidad mensual de ${{$contract->office->price}} ({{$contract->monthly_payment_str}}) más IVA al valor agregado la cual será válida realizando el pago el día puntual de la fecha de contratación entre el día {{$contract->payment_range_start}} y {{$contract->payment_range_end}} de cada mes.</li>
		<li class="one-line-sp">En caso de pagar días posteriores a la fecha estipulada EL CLIENTE se obliga a pagar la cantidad de ${{$contract->office->price * 1.10}} ({{$contract->monthly_payment_str}}) más IVA al valor agregado “EL PRESTADOR” o a quien su derecho represente en la oficina ubicada en la misma dirección. Aumentando anualmente según el índice nacional de precios al consumidor. Dicha cantidad incluye el uso de los servicios mencionados en el inciso “A-1, A-3, A-4, A-5, A-6, A-7, A-8,” de este contrato. Dichos servicios estarán disponibles para “EL CLIENTE” únicamente dentro de los horarios estipulados por “EL PRESTADOR” y conforme a las condiciones de este contrato. (Ver cláusula de pago)</li>
		
		<div class="new-page"></div>
		<br><br>
		<li class="one-line-sp">En caso de no cumplir con el pago 15 días posteriores a la fecha estipulada será negado todos los servicios otorgados por “EL PRESTADOR” y será retenida la documentación y/o correspondencia de “EL CLIENTE” hasta contar con el pago total a la fecha de los servicios prestados.</li>
	</ul>

	<br>
	<p class="break justify bold">3. Obligaciones de EL PRESTADOR de servicios:</p>
	<ul class="b-up-alpha less-li-he justify">
		<li class="one-line-sp">De los servicios en general:
			<ul class="no-style no-padding no-margin">
				<li>“EL PRESTADOR” se obliga a mantener disponibles para “EL CLIENTE” los servicios siguientes:</li>
				<li><br></li>
				<li>A-1) Domicilio fiscal. </li>
				<li>A-2) Control de llamadas y correspondencia. (incluye línea telefónica) </li>
				<li>A-3) Atención a departamentos gubernamentales con atención personalizada.</li>
				<li>A-4) Sala de juntas con servicio de proyección (8 horas mensuales de acuerdo a disponibilidad). Las horas de sala de juntas no son acumulables</li>
				<li>A-5) Estación de café ilimitada</li>
				<li>A-6) Acceso de instalaciones a cualquier centro de negocios FAST OFFICE en horario de recepción. (lunes a viernes de 9:00 am a 3:00 pm – 4:00 pm a 7:00 pm y sábados 9:00 am a 2:00 pm)</li>
				<li>A-7) Planes de negocio y desarrollo (Networking).</li>
				<li>A-8) Línea telefónica</li>
				<li class="white-space-5">A-8.1. Llamadas nacionales e internacionales ilimitadas.</li>
				<li class="white-space-5">A-8.2. 50 min a celular.</li>
				<li><br></li>
				<li>Cada uno de los anteriores puntos es un servicio prestado por “EL PRESTADOR” de acuerdo al objeto de este contrato.</li>
			</ul>
		</li>
		<li class="one-line-sp">“EL PRESTADOR” otorga en prestación de servicios la oficina ubicada en {{$contract->office->address}} en {{$contract->office->municipality->name.' '.$contract->office->state->name}}.</li>
		<li class="one-line-sp">El personal que labora para “EL PRESTADOR”, recibirá la correspondencia de “EL CLIENTE” cuando éste se lo solicite. la entrega se hará de forma responsable cuando “EL CLIENTE” recoja oportunamente (previo aviso del personal) su correspondencia</li>
		<li class="one-line-sp">El servicio de prestación de servicios de oficina, se prestará únicamente a “EL CLIENTE” contratante.</li>
		<li class="one-line-sp">“EL PRESTADOR” no recibirá ningún paquete superior a 4,5 kg. (10 libras) de peso, 46 cm (18 pulgadas) de cualquier dimensión, 0,03 metros cúbicos (1 pie cubico) del volumen o si contiene cualquier mercaderías peligrosas, vivas o perecederas y EL PRESTADOR tendrá derecho, a su absoluta discreción, para devolver cualquier paquete o negarse a aceptar cualquier cantidad de paquetes que considere irrazonable o ilegal. paquetes de mayor tamaño solo serán aceptados por mutuo acuerdo previo. EL PRESTADOR no garantiza ni asume responsabilidad por cualquiera de los servicios proporcionados.</li>
		<li class="one-line-sp">EL PRESTADOR se reserva el derecho de suspender inmediatamente los servicios y/o rescindir el contrato si determina que la instalación o la dirección se utiliza en relación con una posible actividad fraudulenta o actividad que pueda constituir una violación de las leyes o regulaciones gubernamentales.</li>
		<li class="one-line-sp">“EL PRESTADOR” no se hace responsable por robo total o parcial de los artículos, pertenencias, equipo de cómputo, electrónico, así como dinero en efectivo, papeles, cheques dentro de la oficina del “EL CLIENTE”, áreas comunes o cualquier dentro de las instalaciones dentro del domicilio en el que se presta el servicio.</li>
		
		<div class="new-page"></div>
		
		<br><br>
		<li class="one-line-sp">“Horario de prestación de servicios”:
			<ul class="no-style no-padding no-margin">
				<li><br></li>
				<li>“EL PRESTADOR” brindará los servicios mencionados en este contrato únicamente en el horario y dentro de sus instalaciones, de lunes a viernes de 9:00 am a 3:00 pm y de 4:00 a 7:00 pm y sábados de 9:00 am a 2:00 pm, salvo los días siguientes:</li>
				<li><br></li>
				<li>
					<ul class="b-up-disc">
						<li>Enero 1</li>
						<li>Primer lunes de febrero (conmemoración al 5 de febrero)</li>
						<li>Tercer lunes de marzo (conmemoración al 21 de marzo)</li>
						<li>Jueves, viernes y sábado (semana santa)</li>
						<li>Mayo 1</li>
						<li>Septiembre 16</li>
						<li>Tercer lunes de noviembre (conmemoración al 20 de noviembre)</li>
						<li>Diciembre 25</li>
						<li>Cualquier otro día que marque excepcional el “dos” (diario oficial de la federación) o la legislatura del estado de Jalisco.</li>
					</ul>
				</li>
			</ul>
		</li>
	</ul>

	@include('contracts.layouts.clause_4')

	@include('contracts.layouts.clause_5')

	@include('contracts.layouts.clause_6')

	<div class="new-page"></div>
	<br><br>

	@include('contracts.layouts.clause_7')

	@include('contracts.layouts.clause_8')

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