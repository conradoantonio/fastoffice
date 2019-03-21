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
			<th>Franquiciatario</th>
			<th>Teléfono</th>
			<th>Estado</th>
			<th>Municipio</th>
			<th>Dirección</th>
			<th>Colonia</th>
			<th>Código postal</th>
			<th>Status</th>
			@if(auth()->user()->role->name != 'Recepcionista')
			<th>Acciones</th>
			@endif
		</thead>
		<tbody>
			@foreach($branches as $branch)
				<tr>
					<td class="hide">{{$branch->id}}</td>
					<td>
						<div class="checkbox check-success">
							<input id="checkbox{{$branch->id}}" class="multiple-delete" type="checkbox" value="{{$branch->id}}">
							<label for="checkbox{{$branch->id}}"></label>
						</div>
					</td>
					<td>{{$branch->name}}</td>
					<td>{{$branch->user?$branch->user->fullname:'No asignado'}}</td>
					<td>{{$branch->phone}}</td>
					<td>{{$branch->state ? $branch->state->name : 'Sin especificar'}}</td>
					<td>{{$branch->municipality ? $branch->municipality->name : 'Sin especificar'}}</td>
					<td>{{$branch->address}}</td>
					<td>{{$branch->colony}}</td>
					<td>{{$branch->zip_code}}</td>
					<td>
						@if($branch->status)
						<span class="label label-success status" data-url="{{route('Branch.status')}}" data-id="{{$branch->id}}" data-toggle="tooltip" data-placement="top" title="Cambiar status">Activo</span>
						@else
						<span class="label label-danger status" data-url="{{route('Branch.status')}}" data-id="{{$branch->id}}" data-toggle="tooltip" data-placement="top" title="Cambiar status">Inactivo</span>
						@endif
					</td>
					@if(auth()->user()->role->name != 'Recepcionista')
					<td>
						<a class="btn btn-xs btn-mini btn-primary" href="{{route('Branch.form', $branch->id)}}" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil"></i></a>
						<a href="{{route('Branch.destroy',$branch->id) }}" class="btn btn-xs btn-mini btn-danger delete_row" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fa fa-trash"></i></a>
					</td>
					@endif
				</tr>
			@endforeach
		</tbody>
	</table>
</div>