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
			<th>Estatus de prospecto</th>
			<th>Tipo de plantilla</th>
			<th>Estatus</th>
			<th>Acciones</th>
		</thead>
		<tbody>
			@foreach($templates as $template)
				<tr>
					<td class="hide">{{$template->id}}</td>
					<td>
						<div class="checkbox check-success">
							<input id="checkbox{{$template->id}}" class="multiple-delete" type="checkbox" value="{{$template->id}}">
							<label for="checkbox{{$template->id}}"></label>
						</div>
					</td>
					<td>{{$template->name}}</td>
					<td>
						@if( $template->user_status_id == 0 )
							Prospecto
						@elseif( $template->user_status_id == 1 )
							Cliente
						@elseif( $template->user_status_id == 2 )
							Concretado
						@else
							No concretado
						@endif
					</td>
					<td>
						@if( $template->type_id == 1 )
							Manual
						@else
							Automática
						@endif
					</td>
					<td>
						@if($template->status)
						<span class="label label-success status" data-url="{{route('Template.status')}}" data-id="{{$template->id}}" data-toggle="tooltip" data-placement="top" title="Cambiar status">Activo</span>
						@else
						<span class="label label-danger status" data-url="{{route('Template.status')}}" data-id="{{$template->id}}" data-toggle="tooltip" data-placement="top" title="Cambiar status">Inactivo</span>
						@endif
					</td>
					<td>
						<a class="btn btn-xs btn-mini btn-primary" href="{{route('Template.form', $template->id)}}" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil"></i></a>
						<a href="{{route('Template.destroy', $template->id)}}" class="btn btn-xs btn-mini btn-danger delete_row" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fa fa-trash"></i></a>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>
