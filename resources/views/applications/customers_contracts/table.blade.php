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
					{{-- <a href="javascript:;" class="btn btn-xs btn-mini btn view-details" data-toggle="tooltip" data-parent-id="{{$contract->id}}" data-placement="top" title="Ver detalles"><i class="fa fa-info"></i></a> --}}
					<a href="" class="btn btn-xs btn-mini btn-edit edit-row" data-toggle="tooltip" data-parent-id="{{$contract->id}}" data-placement="top" title="Editar"><i class="fa fa-pencil"></i></a>
					{{-- <a href="javascript:;" class="btn btn-xs btn-mini btn-info view-comments" data-toggle="tooltip" data-parent-id="{{$contract->id}}" data-placement="top" title="Ver comentarios"><i class="fa fa-eye"></i></a> --}}
					<a class="btn btn-xs btn-mini btn-primary view-contract" href="{{route('Crm.prospects.view_contract', $contract->id)}}" data-toggle="tooltip" data-placement="top" title="Ver contrato"><i class="fa fa-eye"></i></a>
					<a href="javascript:;" class="btn btn-xs btn-mini btn-danger cancel-contract" data-toggle="tooltip" data-parent-id="{{$contract->id}}" data-placement="top" title="Cancelar contrato"><i class="fa fa-trash"></i></a>
				</td>
			</tr>
		@endforeach
	</tbody>
</table>
