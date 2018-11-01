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
			<th>Oficina</th>
			<th>Fecha inicio</th>
			<th>Fecha término</th>
			<th>Comentario</th>
			<th>Estatus</th>
			<th>Progreso</th>
			<th>Acciones</th>
		</thead>
		<tbody>
			@foreach($meetings as $meeting)
				<tr>
					<td class="hide">{{$meeting->id}}</td>
					<td>
						<div class="checkbox check-success">
							<input id="checkbox{{$meeting->id}}" class="multiple-delete" type="checkbox" value="{{$meeting->id}}">
							<label for="checkbox{{$meeting->id}}"></label>
						</div>
					</td>
					<td>{{$meeting->title}}</td>
					<td>{{$meeting->office->name}}</td>
					<td>{{ucwords(strftime('%d %B %Y %H:%M', strtotime($meeting->datetime_start)))}}</td>
					<td>{{ucwords(strftime('%d %B %Y %H:%M', strtotime($meeting->datetime_end)))}}</td>
					<td>{{$meeting->description}}</td>
					<td>
						@if($meeting->status)
						<span class="label label-success status" data-url="{{route('Meeting.status')}}" data-id="{{$meeting->id}}" data-toggle="tooltip" data-placement="top" title="Cambiar status">Activo</span>
						@else
						<span class="label label-danger status" data-url="{{route('Meeting.status')}}" data-id="{{$meeting->id}}" data-toggle="tooltip" data-placement="top" title="Cambiar status">Inactiva</span>
						@endif
					</td>
					<td>
						@if($meeting->proccess == 1)
						<span class="label label-success progress-val">Completado</span>
						@elseif( $meeting->proccess == 0 )
						<span class="label label-warning progress-val">Por hacer</span>
						@else
						<span class="label label-danger progress-val">Incompleto</span>
						@endif
					</td>
					<td>
						<a class="btn btn-xs btn-mini btn-primary" href="{{route('Meeting.form', $meeting->id)}}" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil"></i></a>
						<a href="{{route('Meeting.destroy',$meeting->id) }}" class="btn btn-xs btn-mini btn-danger delete_row" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fa fa-trash"></i></a>
						<button class="btn btn-mini btn-xs btn-info proccess" data-url="{{route('Meeting.progress')}}" data-id="{{$meeting->id}}" title="Tarea completada"><i class="fa fa-check"></i></button>
						<button class="btn btn-mini btn-xs btn-warning proccess" data-url="{{route('Meeting.progress')}}" data-id="{{$meeting->id}}" title="Tarea incompleta"><i class="fa fa-times"></i></button>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>