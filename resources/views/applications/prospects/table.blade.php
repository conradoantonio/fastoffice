<table class="table table-hover table-condense datatable" id="rows">
	<thead>
		<th class="hide">ID</th>
		<th>
			<div class="checkbox check-success 	">
				<input id="checkboxParent" type="checkbox">
				<label for="checkboxParent"></label>
			</div>
		</th>
		<th>Nombre del prospecto</th>
		<th>Atendido por</th>
		<th>¿Registrado?</th>
		<th>Email</th>
		<th>Teléfono</th>
		<th>Oficina interesada</th>
		<th>Acciones</th>
	</thead>
	<tbody>
		@foreach($prospects as $prospect)
			<tr>
				<td class="hide">{{$prospect->id}}</td>
				<td>
					<div class="checkbox check-success">
						<input id="checkbox{{$prospect->id}}" class="multiple-delete" type="checkbox" value="{{$prospect->id}}">
						<label for="checkbox{{$prospect->id}}"></label>
					</div>
				</td>
				@if ($prospect->customer){{-- Toma los datos directamente del usuario registrado --}}
					<td>{{$prospect->customer->fullname}}</td>
					<td>{!!$prospect->owner ? "<span class='label label-danger'>".$prospect->fullname->name."</span>" : '<span class="label label-danger">Sin atender</span>'!!}</td>
					<td>Registrado</td>
					<td>{{$prospect->customer->email}}</td>
					<td>{{$prospect->customer->phone}}</td>
				@else{{-- Toma los datos directamente de la aplicación --}}
					<td>{{$prospect->fullname}}</td>
					<td>{{$prospect->regime}}</td>
					<td>Sin registrar</td>
					<td>{{$prospect->email}}</td>
					<td>{{$prospect->phone}}</td>
				@endif
				
				<td>{{$prospect->office->name}}</td>
				<td>
					@if(! $prospect->owner )
					<a href="javascript:;" class="btn btn-xs btn-mini btn-warning take-row" data-toggle="tooltip" data-parent-id="{{$prospect->id}}" data-placement="top" title="Tomar prospecto"><i class="fa fa-user"></i></a>
					@endif
					<a href="javascript:;" class="btn btn-xs btn-mini btn view-details" data-toggle="tooltip" data-parent-id="{{$prospect->id}}" data-placement="top" title="Ver detalles"><i class="fa fa-info"></i></a>
					<a href="{{route('Crm.prospects.form', $prospect->id)}}" class="btn btn-xs btn-mini btn-edit edit-row" data-toggle="tooltip" data-parent-id="{{$prospect->id}}" data-placement="top" title="Editar"><i class="fa fa-pencil"></i></a>
					<a href="javascript:;" class="btn btn-xs btn-mini btn-info view-comments" data-toggle="tooltip" data-parent-id="{{$prospect->id}}" data-placement="top" title="Ver comentarios"><i class="fa fa-eye"></i></a>
					<a href="javascript:;" class="btn btn-xs btn-mini btn-success add-comments" data-toggle="tooltip" data-parent-id="{{$prospect->id}}" data-placement="top" title="Agregar comentario"><i class="fa fa-comment"></i></a>
					<a class="btn btn-xs btn-mini btn-primary accept-prospect" href="javascript:;" data-toggle="tooltip" data-placement="top" title="Aceptar prospecto"><i class="fa fa-check"></i></a>
					{{-- <a class="btn btn-xs btn-mini btn-warning" href="" data-toggle="tooltip" data-placement="top" title="Envíar plantilla"><i class="fa fa-envelope"></i></a> --}}
					<a href="javascript:;" class="btn btn-xs btn-mini btn-danger reject-prospect" data-toggle="tooltip" data-parent-id="{{$prospect->id}}" data-placement="top" title="Descartar prospecto"><i class="fa fa-trash"></i></a>
				</td>
			</tr>
		@endforeach
	</tbody>
</table>
