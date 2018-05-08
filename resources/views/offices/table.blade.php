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
			@foreach($offices as $offices)
				<tr>
					<td class="hide">{{$offices->id}}</td>
					<td>
						<div class="checkbox check-success">
							<input id="checkbox{{$offices->id}}" class="multiple-delete" type="checkbox" value="{{$offices->id}}">
							<label for="checkbox{{$offices->id}}"></label>
						</div>
					</td>
					<td>{{$offices->name}}</td>
					<td>
						@if($offices->status)
						<span class="label label-success status" data-url="{{route('Office.status')}}" data-id="{{$offices->id}}" data-toggle="tooltip" data-placement="top" title="Cambiar status">Activo</span>
						@else
						<span class="label label-danger status" data-url="{{route('Office.status')}}" data-id="{{$offices->id}}" data-toggle="tooltip" data-placement="top" title="Cambiar status">Inactivo</span>
						@endif
					</td>
					<td>
						<a class="btn btn-xs btn-mini btn-primary" href="{{route('Office.form', $offices->id)}}" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil"></i></a>
						<a href="{{route('Office.destroy',$offices->id) }}" class="btn btn-xs btn-mini btn-danger delete_row" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fa fa-trash"></i></a>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>