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
			<th>Estatus</th>
			<th>Acciones</th>
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
					<td>
						@if($branch->status)
						<span class="label label-success status" data-url="{{route('Branch.status')}}" data-id="{{$branch->id}}" data-toggle="tooltip" data-placement="top" title="Cambiar status">Activo</span>
						@else
						<span class="label label-danger status" data-url="{{route('Branch.status')}}" data-id="{{$branch->id}}" data-toggle="tooltip" data-placement="top" title="Cambiar status">Inactivo</span>
						@endif
					</td>
					<td>
						<a class="btn btn-xs btn-mini btn-primary" href="{{route('Branch.form', $branch->id)}}" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil"></i></a>
						<a href="{{route('Branch.destroy',$branch->id) }}" class="btn btn-xs btn-mini btn-danger delete_row" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fa fa-trash"></i></a>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>