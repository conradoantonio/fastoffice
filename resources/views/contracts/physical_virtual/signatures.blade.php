<br>
<table id="" class="table table-bordered table-sm">
	<thead class="left">
		<tr>
			<th colspan="2">DATOS DEL "PRESTADOR"</th>
		</tr>
	</thead>
	<tbody class="left">
		<tr>
			<td scope="col">NOMBRE O RAZÓN SOCIAL</td>
			<td scope="col">{{@$contract->office->branch->user->fullname}}</td>
		</tr>
		<tr>
			<td scope="col">RFC</td>
			<td scope="col">{{@$contract->office->branch->user->rfc}}</td>
		</tr>
		<tr>
			<td scope="col">Firma "EL PRESTADOR"</td>
			<td scope="col"><br><br><br><br><br></td>
		</tr>
	</tbody>
</table>

<br><br><br><br>
<table id="" class="table table-bordered table-sm">
	<thead class="left">
		<tr>
			<th colspan="2">DATOS DE "CLIENTE"</th>
		</tr>
	</thead>
	<tbody class="left">
		<tr>
			<td scope="col">NOMBRE O RAZÓN SOCIAL</td>
			<td scope="col">{{$contract->customer->fullname}}</td>
		</tr>
		<tr>
			<td scope="col">RFC</td>
			<td scope="col">{{$contract->customer->rfc}}</td>
		</tr>
		<tr>
			<td scope="col">DOMICILIO</td>
			<td scope="col">{{$contract->customer->address}}</td>
		</tr>
		<tr>
			<td scope="col">GIRO DE LA EMPRESA</td>
			<td scope="col">{{$contract->customer->business_activity}}</td>
		</tr>
		<tr>
			<td scope="col">TIPO DE IDENTIFICACIÓN</td>
			<td scope="col">{{$contract->customer->identification_type}}</td>
		</tr>
		<tr>
			<td scope="col">NO. DE IDENTIFICACIÓN</td>
			<td scope="col">{{$contract->customer->identification_num}}</td>
		</tr>
		<tr>
			<td scope="col">TELÉFONO</td>
			<td scope="col">{{$contract->customer->phone}}</td>
		</tr>
		<tr>
			<td scope="col">EMAIL</td>
			<td scope="col">{{$contract->customer->email}}</td>
		</tr>
		<tr>
			<td scope="col">Firma "EL PRESTADOR"</td>
			<td scope="col"><br><br><br><br><br></td>
		</tr>
	</tbody>
</table>
	