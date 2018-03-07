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
			<th>Título</th>
			<th>Estatus</th>
			<th>Acciones</th>
		</thead>
		<tbody>
			@foreach($news as $new)
				<tr>
					<td class="hide">{{$new->id}}</td>
					<td>
						<div class="checkbox check-success">
							<input id="checkbox{{$new->id}}" class="multiple-delete" type="checkbox" value="{{$new->id}}">
							<label for="checkbox{{$new->id}}"></label>
						</div>
					</td>
					<td>{{$new->title}}</td>
					<td>
						@if($new->status)
						<span class="label label-success status" data-url="{{route('News.status', $new->id)}}" data-toggle="tooltip" data-placement="top" title="Cambiar status">Activo</span>
						@else
						<span class="label label-danger status" data-url="{{route('News.status', $new->id)}}" data-toggle="tooltip" data-placement="top" title="Cambiar status">Inactivo</span>
						@endif
					</td>
					<td>
						<a class="btn btn-xs btn-mini btn-primary" href="{{route('News.form', $new->id)}}" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil"></i></a>
						<a href="{{route('News.destroy',$new->id) }}" class="btn btn-xs btn-mini btn-danger delete_row" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fa fa-trash"></i></a>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>