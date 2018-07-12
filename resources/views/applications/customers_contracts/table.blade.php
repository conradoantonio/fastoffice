<table class="table table-hover table-condense datatable" id="rows">
	<thead>
		<th class="hide">ID</th>
		<th>
			<div class="checkbox check-success 	">
				<input id="checkboxParent" type="checkbox">
				<label for="checkboxParent"></label>
			</div>
		</th>
		<th>Nombre del contracto</th>
		<th>Email</th>
		<th>Teléfono</th>
		<th>Oficina rentada</th>
		<th>Status de pago</th>
		<th>Monto de pago</th>
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
				<td>
                    {!!
                        ($contract->status == '0' ? "<span class='label label-warning'>Por pagar</span>" : 
                            ($contract->status == '1' ? "<span class='label label-success'>Pagado</span>" : 
                                ($contract->status == '2' ? "<span class='label label-danger'>Pago retrasado</span>" : "<span class='label label-info'>Desconocido</span>")
                            )
                        )
                    !!}
                </td>
                <td>${{ $contract->status == 2 ? $contract->office->price * 1.10 : $contract->office->price }}</td>
                <td>{{ $contract->payment_range_start }} y {{ $contract->payment_range_end }} de cada mes</td>
				<td>
					{{-- <a href="javascript:;" class="btn btn-xs btn-mini btn view-details" data-toggle="tooltip" data-parent-id="{{$contract->id}}" data-placement="top" title="Ver detalles"><i class="fa fa-info"></i></a> --}}
					<a href="{{route('Crm.contracts.form', [$contract->application->id, $contract->id])}}" class="btn btn-xs btn-mini btn-edit edit-row" data-toggle="tooltip" data-parent-id="{{$contract->id}}" data-placement="top" title="Editar"><i class="fa fa-pencil"></i></a>
					<a href="javascript:;" class="btn btn-xs btn-mini btn-info show-money-receipt" data-toggle="tooltip" data-parent-id="{{$contract->id}}" data-placement="top" title="Descargar recibo de pago"><i class="fa fa-money"></i></a>
					<a class="btn btn-xs btn-mini btn-primary view-contract" href="{{route('Crm.prospects.show_contract', $contract->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Ver contrato"><i class="fa fa-eye"></i></a>
					<a href="javascript:;" class="btn btn-xs btn-mini btn-danger cancel-contract" data-toggle="tooltip" data-parent-id="{{$contract->id}}" data-placement="top" title="Cancelar contrato"><i class="fa fa-trash"></i></a>
				</td>
			</tr>
		@endforeach
	</tbody>
</table>
