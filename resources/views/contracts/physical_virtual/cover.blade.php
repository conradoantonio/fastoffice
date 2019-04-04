<p class="break bold center">CARÁTULA DEL CONTRATO DE PRESTACIÓN DE SERVICIOS</p>
<p class="break">
	<br>
	<ul class="no-style left no-padding no-margin uppercase">
		<li>Fecha: {{strftime('%d', strtotime($contract->contract_date))}} de {{strftime('%B', strtotime($contract->contract_date))}} de {{strftime('%Y', strtotime($contract->contract_date))}}</li>
		<li>Ciudad: {{$contract->municipality->name}}</li>
		<li>Estado: {{$contract->state->name}}</li>
		<li>País: {{$contract->country}}</li>
	</ul>
</p>

<br>
<br>
<p class="break bold center">DOMICILIO DONDE SE LLEVA A CABO LA PRESTACION DE SERVICIOS</p>
<p>
	<ul class="no-style left no-padding no-margin uppercase">
		<li>Calle: {{$contract->office->branch->address}}</li>
		<li>Interior: {{$contract->office->num_int}}</li>
		<li>Colonia: {{$contract->office->branch->colony}}</li>
		<li>C.P.: {{$contract->office->branch->zip_code}}</li>
		<li>Ciudad: {{$contract->office->branch->municipality->name}}</li>
		<li>Estado: {{$contract->office->branch->state->name}}</li>
		<li>País: {{$contract->country}}</li>
	</ul>
</p>

<br>
<br>
<br>
<p class="break bold center">CONCONDICIONES DEL CONTRATO DE SERVICIOS</p>
<p>
	<ul class="no-style left no-padding no-margin uppercase">
		<li>Destino o uso: {{$contract->usage}}</li>
		<li>Fecha de inicio de contrato: {{strftime('%d', strtotime($contract->start_date_validity))}} de {{strftime('%B', strtotime($contract->start_date_validity))}} de {{strftime('%Y', strtotime($contract->start_date_validity))}}</li>
		<li>Fecha de fin de contrato: {{strftime('%d', strtotime($contract->end_date_validity))}} de {{strftime('%B', strtotime($contract->end_date_validity))}} de {{strftime('%Y', strtotime($contract->end_date_validity))}}</li>
		<li>Días de pago puntual: Del {{$contract->payment_range_start}}  al {{$contract->payment_range_end}}</li>
		<li>Depósito en garantía: ${{$contract->office->monthly_price}} pesos</li>
		<li>Oficina amueblada para: {{$contract->office->num_people}}</li>
		<li>Personas adicionales: {{$contract->additional_people}}</li>
		<li>Nota: Si el cliente desea agregar más personas a su oficina cada persona tendrá un pago mensual de $580.00 pesos</li>
		<li>Sala de juntas: {{$contract->meeting_room_hours >= 0 ? $contract->meeting_room_hours.' horas' : 'Horas ilimitadas'}}</li>
		<li>Línea telefónica: {{$contract->telephone_line ? 'Si' : 'No'}}</li>
		<li>Estación de cómputo: {{$contract->computer_station ? 'Si' : 'No'}}</li>
		<li>Referencia bancaria: {{$contract->bank_reference}}</li>
	</ul>
</p>