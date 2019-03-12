<table class="table table-hover table-condense datatable" id="rows">
	<thead>
		<th class="hide">ID</th>
		<th>
			<div class="checkbox check-success 	">
				<input id="checkboxParent" type="checkbox">
				<label for="checkboxParent"></label>
			</div>
		</th>
		<th>Nombre del cliente</th>
		<th>Email</th>
		<th>Teléfono</th>
		<th>Oficina rentada</th>
		<th>Status de contrato</th>
		<th>Monto de pago</th>
		<th class="hide">Monto de pago normal</th>
		<th class="hide">Monto de pago normal cadena</th>
		<th class="hide">Monto de pago por atraso cadena</th>
		<th class="hide">Monto de pago por atraso</th>
		<th>Rango de días de pago</th>
		<th>Acciones</th>
	</thead>
	<tbody>
		@foreach($contracts as $contract)
			<tr>
				<td class="hide">{{$contract->id}}</td>
				<td>
					<div class="checkbox check-success">
						<input id="checkbox{{$contract->id}}" class="multiple-delete" type="checkbox" value="{{$contract->id}}">
						<label for="checkbox{{$contract->id}}"></label>
					</div>
				</td>
				<td>{{$contract->customer->fullname}}</td>
				<td>{{$contract->customer->email}}</td>
				<td>{{$contract->customer->phone}}</td>
				<td>{{$contract->office->name}}</td>
                <td>{!! ($contract->cancelation ? "<span class='label label-danger'>Cancelado</span>" : "<span class='label label-info'>Finalizado</span>") !!}</td>
                <td>${{ $contract->status == 2 ? $contract->office->price : $contract->office->price / 1.10 }}</td>
                <td class="hide">{{$contract->office->price / 1.10}}</td>
                <td class="hide">{{$contract->monthly_payment_str}}</td>
                <td class="hide">{{$contract->office->price}}</td>
                <td class="hide">{{$contract->monthly_payment_delay_str}}</td>
                <td>{{ $contract->payment_range_start }} y {{ $contract->payment_range_end }} de cada mes</td>
				<td>
					<a href="javascript:;" class="btn btn-xs btn-mini btn-warning view-payments" data-toggle="tooltip" data-parent-id="{{$contract->id}}" data-placement="top" title="Ver historial de pago"><i class="fa fa-clock-o"></i></a>
					<a class="btn btn-xs btn-mini btn-primary view-contract" href="{{route('Crm.prospects.show_contract', $contract->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Ver contrato"><i class="fa fa-eye"></i></a>
					@if ($contract->cancelation)	
						<a href="javascript:;" class="btn btn-xs btn-mini btn-danger cancel-contract" data-toggle="tooltip" data-parent-id="{{$contract->id}}" data-cancelled="1" data-placement="top" title="Ver doc. de cancelación"><i class="fa fa-eye"></i></a>
					@endif
				</td>
			</tr>
		@endforeach
	</tbody>
</table>
