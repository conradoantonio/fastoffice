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
					<td>{{$office->type ? $office->type->name : 'No asignado'}}</td>
					<td>
						@if($office->status)
						<span class="label label-success status" data-url="{{route('Office.status')}}" data-id="{{$office->id}}" data-toggle="tooltip" data-placement="top" title="Cambiar status">Activo</span>
						@else
						<span class="label label-danger status" data-url="{{route('Office.status')}}" data-id="{{$office->id}}" data-toggle="tooltip" data-placement="top" title="Cambiar status">Inactivo</span>
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