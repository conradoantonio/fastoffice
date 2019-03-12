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
		<th>Status de pago</th>
		{{-- <th>Status de contrato</th> --}}
		<th>Monto a pagar</th>
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
				<td>{{$contract->office->name}} ({{$contract->office->type->name}})</td>
				<td>
                    {!!
                        ($contract->charges->sum('amount') == $contract->balance ? "<span class='label label-success'>Pagado</span>" :
                            (($contract->charges->sum('amount') - $contract->balance) <= round( $contract->office->price / 1.10, PHP_ROUND_HALF_UP, 2 ) ? "<span class='label label-warning'>Por pagar</span>" :
                                ($contract->charges->sum('amount') >= round( $contract->office->price / 1.10, PHP_ROUND_HALF_UP, 2 )  ? "<span class='label label-danger'>Pago atrasado</span>" : "<span class='label label-info'>Desconocido</span>")
                            )
                        )
                    !!}
                </td>
                {{-- <td>{!! ($contract->cancelation ? "<span class='label label-danger'>Cancelado</span>" : "<span class='label label-info'>Normal</span>") !!}</td> --}}
                <td>${{ ($contract->charges->sum('amount') - $contract->balance) }}</td>
                <td class="hide">{{$contract->office->price / 1.10}}</td>
                <td class="hide">{{$contract->monthly_payment_str}}</td>
                <td class="hide">{{$contract->office->price}}</td>
                <td class="hide">{{$contract->monthly_payment_delay_str}}</td>
                <td>{{$contract->office->type->name == 'Física' || $contract->office->type->name == 'Virtual' ? $contract->payment_range_start.' y '.$contract->payment_range_end.' de cada mes' : 'No aplica'}}</td>
				<td>
					{{-- <a href="javascript:;" class="btn btn-xs btn-mini btn view-details" data-toggle="tooltip" data-parent-id="{{$contract->id}}" data-placement="top" title="Ver detalles"><i class="fa fa-info"></i></a> --}}
					<a href="{{route('Crm.contracts.form', [$contract->application->id, $contract->id])}}" class="btn btn-xs btn-mini btn-edit edit-row" data-toggle="tooltip" data-parent-id="{{$contract->id}}" data-placement="top" title="Editar"><i class="fa fa-pencil"></i></a>
					<a href="javascript:;" class="btn btn-xs btn-mini btn-info show-money-receipt" data-toggle="tooltip" data-parent-id="{{$contract->id}}" data-placement="top" title="Descargar recibo de pago"><i class="fa fa-money"></i></a>
					<a href="javascript:;" class="btn btn-xs btn-mini btn-warning view-payments" data-toggle="tooltip" data-parent-id="{{$contract->id}}" data-placement="top" title="Ver historial de pago"><i class="fa fa-clock-o"></i></a>
					<a class="btn btn-xs btn-mini btn-primary view-contract" href="{{route('Crm.prospects.show_contract', $contract->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Ver contrato"><i class="fa fa-eye"></i></a>
					@if ((($contract->charges->sum('amount')-$contract->balance)>0))
						<a class="btn btn-xs btn-mini btn-success mark-as-paid" href="javascript:;" data-toggle="tooltip" data-placement="top" title="Realizar pago"><i class="fa fa-check"></i></a>
					@endif
					@if ($contract->cancelation)
						<a href="javascript:;" class="btn btn-xs btn-mini btn-danger cancel-contract" data-toggle="tooltip" data-parent-id="{{$contract->id}}" data-cancelled="1" data-placement="top" title="Ver doc. de cancelación"><i class="fa fa-eye"></i></a>
					@else
						<a href="javascript:;" class="btn btn-xs btn-mini btn-danger cancel-contract" data-toggle="tooltip" data-parent-id="{{$contract->id}}" data-placement="top" title="Cancelar contrato"><i class="fa fa-times"></i></a>
					@endif
					@if (auth()->user()->role_id == 2 && $contract->suggested_price){{-- Branch user --}}
						<a href="javascript:;" class="btn btn-xs btn-mini btn-review view-new-price" data-office="{{$contract->office->name}}" data-receptionist="{{$contract->suggested_price->user->fullname}}" data-price="{{$contract->suggested_price->new_price}}" data-toggle="tooltip" data-parent-id="{{$contract->id}}" data-placement="top" title="Ver precio sugerido"><i class="fa fa-dollar"></i></a>
					@endif
					<a href="javascript:;" class="btn btn-xs btn-mini btn-cancel finish-contract" data-toggle="tooltip" data-parent-id="{{$contract->id}}" data-placement="top" title="Finalizar contrato"><i class="fa fa-flag-checkered"></i></a>
				</td>
			</tr>
		@endforeach
	</tbody>
</table>
