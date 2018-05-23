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
			<th>Nombre del prospecto</th>
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
					@if ($prospect->user){{-- Toma los datos directamente del usuario registrado --}}
						<td>{{$prospect->user->fullname}}</td>
						<td>Registrado</td>
						<td>{{$prospect->user->email}}</td>
						<td>{{$prospect->user->phone}}</td>
					@else{{-- Toma los datos directamente de la aplicación --}}
						<td>{{$prospect->fullname}}</td>
						<td>Sin registrar</td>
						<td>{{$prospect->email}}</td>
						<td>{{$prospect->phone}}</td>
					@endif
					
					<td>{{$prospect->office->name}}</td>
					<td>
						<a class="btn btn-xs btn-mini btn-primary" href="{{-- {{route('prospect.form', $prospect->id)}} --}}" data-toggle="tooltip" data-placement="top" title="Aceptar prospecto"><i class="fa fa-check"></i></a>
						<a class="btn btn-xs btn-mini btn-info" href="{{-- {{route('prospect.form', $prospect->id)}} --}}" data-toggle="tooltip" data-placement="top" title="Envíar plantilla"><i class="fa fa-envelope"></i></a>
						<a href="{{-- {{route('prospect.destroy',$prospect->id) }} --}}" class="btn btn-xs btn-mini btn-danger delete_row" data-toggle="tooltip" data-placement="top" title="Descartar prospecto"><i class="fa fa-trash"></i></a>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>