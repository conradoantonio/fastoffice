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
			<th>Fecha inicio</th>
			<th>Fecha término</th>
			<th>Estatus</th>
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
					<td>{{ucwords(strftime('%d %B %Y %H:%M', strtotime($meeting->datetime_start)))}}</td>
					<td>{{ucwords(strftime('%d %B %Y %H:%M', strtotime($meeting->datetime_end)))}}</td>
					<td>
						@if($meeting->status)
						<span class="label label-success status" data-url="{{route('Meeting.status')}}" data-id="{{$meeting->id}}" data-toggle="tooltip" data-placement="top" title="Cambiar status">Activo</span>
						@else
						<span class="label label-danger status" data-url="{{route('Meeting.status')}}" data-id="{{$meeting->id}}" data-toggle="tooltip" data-placement="top" title="Cambiar status">Inactiva</span>
						@endif
					</td>
					<td>
						<a class="btn btn-xs btn-mini btn-primary" href="{{route('Meeting.form', $meeting->id)}}" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil"></i></a>
						<a href="{{route('Meeting.destroy',$meeting->id) }}" class="btn btn-xs btn-mini btn-danger delete_row" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fa fa-trash"></i></a>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>