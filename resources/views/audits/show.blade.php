@extends('layouts.main')
@section('pageTitle', 'Detalle auditoría')
@section('content')
@push('links')
<link rel="stylesheet" href="{{asset('plugins/fancybox/source/jquery.fancybox.css?v=2.1.7')}}" type="text/css" media="screen" />
<link rel="stylesheet" href="{{asset('plugins/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5')}}" type="text/css" media="screen" />
<link rel="stylesheet" href="{{asset('plugins/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7')}}" type="text/css" media="screen" />
@endpush
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
						<li><span class="bold">Nombre: </span>{{$audit->user->fullname}}</li>
						<li><span class="bold">Teléfono: </span>{{$audit->user->phone}}</li>
						<li><span class="bold">Correo: </span>{{$audit->user->email}}</li>
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
					<img src="{{@asset($audit->office->pictures->first()->path?:'img/default_office.png')}}" data-src="{{@asset($audit->office->pictures->first()->path?:'img/default_office.png')}}" alt="Imagen portada" width="60%" class="profile_img">
				</div>
				<div class="col-md-9 col-sm-8">
					<ul>
						<li><span class="bold">Nombre: </span>{{$audit->office->name}}</li>
						<li><span class="bold">Teléfono: </span>{{$audit->office->phone}}</li>
						<li><span class="bold">Dirección: </span>{{$audit->office->address}} {{$audit->office->municipality->name}}, {{$audit->office->state->name}}</li>
						<li><span class="bold">Status: </span>
							@if($audit->office->status == 0)
								<span class="label label-danger">Inactivo</span>
							@elseif($audit->office->status == 1)
								<span class="label label-success">Disponible</span>
							@else
								<span class="label label-info">Rentada</span>
							@endif
						</li>
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
							<td colspan="3">
								<span class="bold">{{$key}}</span>
							</td>
							<td>
								{{ $total_questions . '/' . count($auditDetails) }}
							</td>
							<td>
								{{ 100 * $total_questions / count($auditDetails) . "%"}}
							</td>
						</tr>
						@foreach( $auditDetails as $auditDetail)
							<tr>
								<td>{{$auditDetail->question->question}}</td>
								<td>
									@if( $auditDetail->answer == 0)
										No
									@elseif( $auditDetail->answer == 1)
										Si
									@else
										N/A
									@endif
								</td>
								<td>

								</td>
								<td>
									{{ nl2br($auditDetail->detail) }}
								</td>
								<td>
									@if( !$auditDetail->photos->isEmpty() )
										<a href="#" class="open-album" data-open-id="album-{{$auditDetail->id}}"><i class="fa fa-picture-o"></i> Ver galería</a>
										@foreach( $auditDetail->photos as $photo )
										<a href="{{asset($photo->path)}}" class="image-show hide" rel="album-{{$auditDetail->id}}"></a>
										@endforeach
									@else
										Sin imágenes
									@endif
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
@push('scripts')
<script type="text/javascript" src="{{asset('plugins/fancybox/source/jquery.fancybox.pack.js?v=2.1.7')}}"></script>
<script type="text/javascript" src="{{asset('plugins/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5')}}"></script>
<script type="text/javascript" src="{{asset('plugins/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6')}}"></script>
<script type="text/javascript" src="{{asset('plugins/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7')}}"></script>
<script type="text/javascript">
	$('.open-album').click(function(e) {
		var el, id = $(this).data('open-id');
		if(id){
			el = $('.image-show[rel=' + id + ']:eq(0)');
			e.preventDefault();
			el.click();
		}
	});
	$(".image-show").fancybox({
		prevEffect	: 'none',
			nextEffect	: 'none',
			helpers	: {
				title	: {
					type: 'outside'
				},
				thumbs	: {
					width	: 50,
					height	: 50
				}
			}
	});
</script>
@endpush
@endsection
