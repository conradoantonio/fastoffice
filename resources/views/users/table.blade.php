<div class="table-responsive">
	<table class="table table-hover table-condense datatable">
		<thead>
			<th class="hide">ID</th>
			<th>Foto de perfil</th>
			<th>Nombre</th>
			<th>Correo</th>
			<th>Rol</th>
			<th>Estatus</th>
			{{-- @if(Route::currentRouteName() == 'User.index1') --}}
			<th>Acciones</th>
			{{-- @endif --}}
		</thead>
		<tbody>
			@foreach($users as $user)
				<tr>
					<td class="hide">{{$user->id}}</td>
					<td width="15%">
						<img src="{{asset($user->photo)}}" alt="Foto de perfil" style="width:50%;border-radius: 100px;">
					</td>
					<td>{{$user->fullname}}</td>
					<td>{{$user->email}}</td>
					<td>{{$user->role->name}}</td>
					<td>
						@if($user->status)
							<span class="label label-success status" data-url="{{route('User.status')}}" data-id="{{$user->id}}" data-toggle="tooltip" data-placement="top" title="Cambiar status">Activo</span>
						@else
							<span class="label label-danger status" data-url="{{route('User.status')}}" data-id="{{$user->id}}" data-toggle="tooltip" data-placement="top" title="Cambiar status">Inactivo</span>
						@endif
					</td>

					{{-- @if( Route::currentRouteName() == 'User.index1' ) --}}
						<td>
							<a class="btn btn-xs btn-mini btn-primary" href="{{route('User.form',['type' => Route::currentRouteName() == 'User.index1' ? 'sistema' : 'app', 'id' => $user->id])}}" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil"></i></a>
							<a href="{{route('User.destroy',$user->id) }}" class="btn btn-xs btn-mini btn-danger delete_row" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fa fa-trash"></i></a>
							@php
							/*<a class="btn btn-xs btn-mini btn-default" href="{{route('User.show',$user->id)}}" data-toggle="tooltip" data-placement="top" title="Ver detalle"><i class="fa fa-eye"></i></a>*/
							@endphp
						</td>
					{{-- @endif --}}
				</tr>
			@endforeach
		</tbody>
	</table>
</div>