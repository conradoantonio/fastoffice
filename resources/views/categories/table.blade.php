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
			<th>Tipo</th>
			<th>Estatus</th>
			<th>Acciones</th>
		</thead>
		<tbody>
			@foreach($categories as $category)
				<tr>
					<td class="hide">{{$category->id}}</td>
					<td>
						<div class="checkbox check-success">
							<input id="checkbox{{$category->id}}" class="multiple-delete" type="checkbox" value="{{$category->id}}">
							<label for="checkbox{{$category->id}}"></label>
						</div>
					</td>
					<td>{{$category->name}}</td>
					<td>
						@if($category->type == 1)
						<span class="label label-info">Ingreso</span>
						@else
						<span class="label label-info">Egreso</span>
						@endif
					</td>
					<td>
						@if($category->status)
						<span class="label label-success status" data-url="{{route('Category.status')}}" data-id="{{$category->id}}" data-toggle="tooltip" data-placement="top" title="Cambiar status">Activo</span>
						@else
						<span class="label label-danger status" data-url="{{route('Category.status')}}" data-id="{{$category->id}}" data-toggle="tooltip" data-placement="top" title="Cambiar status">Inactivo</span>
						@endif
					</td>
					<td>
						<a class="btn btn-xs btn-mini btn-primary" href="{{route('Category.form', $category->id)}}" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil"></i></a>
						<a href="{{route('Category.destroy', $category->id)}}" class="btn btn-xs btn-mini btn-danger delete_row" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fa fa-trash"></i></a>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>
