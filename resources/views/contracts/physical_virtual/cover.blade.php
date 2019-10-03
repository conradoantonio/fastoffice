<p class="break bold center">CARÁTULA DEL CONTRATO DE PRESTACIÓN DE SERVICIOS</p>
<table id="" class="table table-bordered table-sm uppercase">
	{{-- <thead class="left">
		<tr>
			<th colspan="2">DATOS DEL "PRESTADOR"</th>
		</tr>
	</thead> --}}
	<tbody class="left">
		<tr>
			<td scope="col">FECHA</td>
			<td scope="col">{{ strftime('%d', strtotime($contract->contract_date) ).' de '. strftime('%B', strtotime($contract->contract_date)) .' de '. strftime('%Y', strtotime($contract->contract_date) ) }}</td>
		</tr>
		<tr>
			<td scope="col">CIUDAD</td>
			<td scope="col">{{$contract->municipality->name}}</td>
		</tr>
		<tr>
			<td scope="col">ESTADO</td>
			<td scope="col">{{$contract->state->name}}</td>
		</tr>
		<tr>
			<td scope="col">PAÍS</td>
			<td scope="col">{{$contract->country}}</td>
		</tr>
	</tbody>
</table>

<br>
<table id="" class="table table-bordered table-sm">
	<thead>
		<tr>
			<th colspan="3">DOMICILIO DONDE SE LLEVA A CABO LA PRESTACION DE SERVICIOS</th>
		</tr>
	</thead>
	<tbody class="left">
		<tr>
			<td scope="col">CALLE</td>
			<td scope="col" colspan="2">{{$contract->office->branch->address}}</td>
		</tr>
		<tr>
			<td scope="col">INTERIOR</td>
			<td scope="col" colspan="2">{{$contract->office->num_int}}</td>
		</tr>
		<tr>
			<td scope="col">COLONIA</td>
			<td scope="col" colspan="2">{{$contract->office->branch->colony}}</td>
		</tr>
		<tr>
			<td scope="col">C.P.</td>
			<td scope="col" colspan="2">{{$contract->office->branch->zip_code}}</td>
		</tr>
		<tr>
			<td scope="col">CIUDAD</td>
			<td scope="col" colspan="2">{{$contract->office->branch->municipality->name}}</td>
		</tr>
		<tr>
			<td scope="col">ESTADO</td>
			<td scope="col" colspan="2">{{$contract->office->branch->state->name}}</td>
		</tr>
		<tr>
			<td scope="col">PAÍS</td>
			<td scope="col" colspan="2">{{$contract->country}}</td>
		</tr>
	</tbody>
</table>

<br>
<table id="" class="table table-bordered table-sm ">
	<thead>
		<tr>
			<th colspan="4">CONDICIONES DEL CONTRATO DE SERVICIOS</th>
		</tr>
	</thead>
	<tbody class="left">
		<tr>
			<td scope="col">Destino o uso</td>
			<td scope="col" colspan="3">{{$contract->usage}}</td>
		</tr>
		<tr>
			<td scope="col">Fecha de inicio de contrato</td>
			<td scope="col">Del {{strftime('%d', strtotime($contract->start_date_validity))}} de {{strftime('%B', strtotime($contract->start_date_validity))}} de {{strftime('%Y', strtotime($contract->start_date_validity))}}</td>
			<td scope="col">Fecha de fin de contrato</td>
			<td scope="col">Al {{strftime('%d', strtotime($contract->end_date_validity))}} de {{strftime('%B', strtotime($contract->end_date_validity))}} de {{strftime('%Y', strtotime($contract->end_date_validity))}}</td>
		</tr>
		<tr>
			<td scope="col">Pago mensual</td>
			<td scope="col">${{$contract->office->price}} pesos</td>
			<td scope="col">Pago puntual</td>
			<td scope="col">${{$contract->office->monthly_price}} pesos</td>
		</tr>
		<tr>
			<td scope="col">Días de pago puntual</td>
			<td scope="col" colspan="3">Del {{$contract->payment_range_start}} Al {{$contract->payment_range_end}} de cada mes</td>
		</tr>
		<tr>
			<td scope="col">Depósito en garantía</td>
			<td scope="col" colspan="3">${{$contract->guarantee_deposit}} pesos</td>
		</tr>
		<tr>
			<td scope="col">Oficina amueblada para:</td>
			<td scope="col" colspan="3">{{$contract->office->num_people}}</td>
		</tr>
		<tr>
			<td scope="col">Personas adicionales:</td>
			<td scope="col" colspan="3">{{$contract->additional_people}}</td>
		</tr>
		<tr>
			<td scope="col" colspan="4">Nota: Si el cliente desea agregar más personas a su oficina cada persona tendrá un pago mensual de $580.00 pesos</td>
		</tr>
		<tr>
			<td scope="col">Sala de juntas</td>
			<td scope="col" colspan="3">{{$contract->meeting_room_hours == null ? 'Horas ilimitadas, aplican restricciones y disponibilidad' : $contract->meeting_room_hours.' horas'}}</td>
		</tr>
		<tr>
			<td scope="col">Línea telefónica</td>
			<td scope="col" colspan="3">{{$contract->telephone_line ? 'Si' : 'No'}}</td>
		</tr>
		<tr>
			<td scope="col">Estación de cómputo</td>
			<td scope="col" colspan="3">{{$contract->computer_station ? 'Si' : 'No'}}</td>
		</tr>
		<tr>
			<td scope="col">Referencia bancaria</td>
			<td scope="col" colspan="3">{{$contract->bank_reference}}</td>
		</tr>
	</tbody>
</table>
