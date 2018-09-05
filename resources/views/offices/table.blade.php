<div class="table-responsive">
	<table class="table table-hover table-condense datatable">
		<thead>
			<th class="hide">ID</th>
			<th>
				<div class="checkbox check-success 	">
					<input id="checkboxParent" type="checkbox">
					<label for="checkboxParent"></label>
				</div>
			</th>
			<th>Nombre</th>
			<th>Franquicia</th>
			<th>Recepcionista</th>
			<th>Estado</th>
			<th>Municipio</th>
			<th>Tipo</th>
			<th>Estatus</th>
			<th>Acciones</th>
		</thead>
		<tbody>
			@foreach($offices as $office)
				<tr>
					<td class="hide">{{$office->id}}</td>
					<td>
						<div class="checkbox check-success">
							<input id="checkbox{{$office->id}}" class="multiple-delete" type="checkbox" value="{{$office->id}}">
							<label for="checkbox{{$office->id}}"></label>
						</div>
					</td>
					<td>{{$office->name}}</td>
					<td>{{$office->branch->name}}</td>
					<td>{{$office->user?$office->user->fullname : 'No asignado'}}</td>
					<td>{{$office->state?$office->state->name:'Sin especificar'}}</td>
					<td>{{$office->municipality?$office->municipality->name:'Sin especificar'}}</td>
					<td>{{$office->type ? $office->type->name : 'No asignado'}}</td>
					<td>
						@if($office->status == 0)
							<span class="label label-danger {{-- status --}}" data-url="{{route('Office.status')}}" data-id="{{$office->id}}" {{-- data-toggle="tooltip" data-placement="top" title="Cambiar status" --}}>Inactivo</span>
						@elseif($office->status == 1)
							<span class="label label-success {{-- status --}}" data-url="{{route('Office.status')}}" data-id="{{$office->id}}" {{-- data-toggle="tooltip" data-placement="top" title="Cambiar status" --}}>Disponible</span>
						@else
							<span class="label label-info {{-- status --}}" data-url="{{route('Office.status')}}" data-id="{{$office->id}}" {{-- data-toggle="tooltip" data-placement="top" title="Cambiar status" --}}>Rentada</span>
						@endif
					</td>
					<td>
						<a class="btn btn-xs btn-mini btn-primary" href="{{route('Office.form', $office->id)}}" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil"></i></a>
						<a href="{{route('Office.destroy',$office->id) }}" class="btn btn-xs btn-mini btn-danger delete_row" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fa fa-trash"></i></a>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>