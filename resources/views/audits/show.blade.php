@extends('layouts.main')
@section('pageTitle', 'Detalle auditoría')
@section('content')
<div class="container-fluid content-body">
	<div class="page-title">
		<h1>Detalle <span class="semi-bold">{{$audit->title}}</span></h1>
	</div>
	<ul class="list-group">
		<li class="list-group-item active">Datos del auditor</li>
		<li class="list-group-item">
			<div class="row">
				<div class="col-md-3 col-sm-4 text-center">
					<img src="{{asset($audit->user->photo)}}" data-src="{{asset($audit->user->photo)}}" alt="Foto de perfil" width="60%" class="profile_img">
				</div>
				<div class="col-md-9 col-sm-8">
					<ul>
						<li><strong>Nombre: </strong>{{$audit->user->fullname}}</li>
						<li><strong>Teléfono: </strong>{{$audit->user->phone}}</li>
						<li><strong>Correo: </strong>{{$audit->user->email}}</li>
					</ul>
				</div>
			</div>
		</li>
	</ul>
	<ul class="list-group">
		<li class="list-group-item active">Datos de la oficina</li>
		<li class="list-group-item">
			<div class="row">
				<div class="col-md-3 col-sm-4 text-center">
					<img src="{{@asset($audit->office->pictures->first()->path)}}" data-src="{{@asset($audit->office->pictures->first()->path)}}" alt="Imagen portada" width="60%" class="profile_img">
				</div>
				<div class="col-md-9 col-sm-8">
					<ul>
						<li><strong>Nombre: </strong>{{$audit->office->name}}</li>
						<li><strong>Teléfono: </strong>{{$audit->office->phone}}</li>
						<li><strong>Dirección: </strong>{{$audit->office->address}} {{$audit->office->municipality->name}}, {{$audit->office->state->name}}</li>
						<li><strong>Estado: </strong>{{$audit->office->status}}</li>
					</ul>
				</div>
			</div>
		</li>
	</ul>
	<ul class="list-group">
		<li class="list-group-item active">Datos de la auditoría</li>
		<li class="list-group-item">
			<table class="table table-hover table-condense">
				<tbody>
					@foreach( $details as $key => $auditDetails )
						@php
							$total_questions = count(collect($auditDetails)->where('answer', 1));
						@endphp
						<tr>
							<td colspan="2">
								<strong>{{$key}}</strong>
							</td>
							<td>
								{{ $total_questions . '/' . count($auditDetails) }}
							</td>
							<td>
								{{ 100 / $total_questions . "%	"}}
							</td>
						</tr>
						@foreach( $auditDetails as $auditDetail)
							<tr>
								<td>{{$auditDetail->question->question}}</td>
								<td>
									@if( $auditDetail->answer == 1)
										Si
									@else
										No
									@endif
								</td>
								<td>

								</td>
								<td>
									{{$auditDetail->detail}}
								</td>
							</tr>
						@endforeach
					@endforeach
				</tbody>
			</table>

			@if( $audit->auditDetail->isEmpty() )
				<h4>No hay respuestas</h4>
			@endif
		</li>
	</ul>
	<a href="{{route('Audit')}}" class="btn btn-danger">Regresar</a>
</div>
@endsection
