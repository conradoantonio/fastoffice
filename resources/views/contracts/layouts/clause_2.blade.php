<p class="justify bold">2. Contraprestaciones:</p>
@if($contract->office->type->name == 'Física' || $contract->office->type->name == 'Virtual')
	<ul class="b-up-alpha less-li-he justify">
		<li class="one-line-sp">“EL CLIENTE” se obliga a pagar a “EL PRESTADOR” por concepto de prestación de servicios de este contrato y validando la promoción de pronto pago la cantidad mensual de ${{round( $contract->office->price * .90, PHP_ROUND_HALF_UP, 2 )}} ({{$contract->monthly_payment_str}}) más IVA al valor agregado la cual será válida realizando el pago el día puntual de la fecha de contratación entre el día {{$contract->payment_range_start}} y {{$contract->payment_range_end}} de cada mes.</li>
		<li class="one-line-sp">En caso de pagar días posteriores a la fecha estipulada EL CLIENTE se obliga a pagar la cantidad de ${{$contract->office->price}} ({{$contract->monthly_payment_delay_str}}) más IVA al valor agregado “EL PRESTADOR” o a quien su derecho represente en la oficina ubicada en la misma dirección. Aumentando anualmente según el índice nacional de precios al consumidor. Dicha cantidad incluye el uso de los servicios mencionados en el inciso “A-1, A-3, A-4, A-5, A-6, A-8,” de este contrato. Dichos servicios estarán disponibles para “EL CLIENTE” únicamente dentro de los horarios estipulados por “EL PRESTADOR” y conforme a las condiciones de este contrato. (Ver cláusula de pago)</li>
		
		<div class="new-page"></div>
		<br><br>
		<li class="one-line-sp">En caso de no cumplir con el pago 15 días posteriores a la fecha estipulada será negada la entrada a la oficina y se cambiará clave de alarma.</li>
	</ul>
@else
	<ul class="b-up-alpha less-li-he justify">
		<li class="one-line-sp">“EL CLIENTE” se obliga a pagar a “EL PRESTADOR” por concepto de prestación de servicios de este contrato y validando la promoción de pronto pago la cantidad por hora de ${{round( $contract->office->price * .90, PHP_ROUND_HALF_UP, 2 )}} ({{$contract->monthly_payment_str}}) la cual será válida realizando el pago el día puntual de la fecha de contratación.</li>
	</ul>
@endif