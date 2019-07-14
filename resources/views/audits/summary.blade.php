<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb18030">
	<title>Resumen de auditoria {{$audit->branch->name}}</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="base-url" content="{{ url('') }}">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<meta content="" name="description" />
	<meta content="Fastoffice" name="author" />

	<link rel="shortcut icon" href="{{asset('img/favicon.png')}}">

	<link href="{{asset('/plugins/pace/pace-theme-flash.css')}}" rel="stylesheet" type="text/css" media="screen"/>
	<!-- BEGIN CORE CSS FRAMEWORK -->
	<link href="{{asset('/plugins/boostrapv3/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
	<link href="{{asset('/plugins/boostrapv3/css/bootstrap-theme.min.css')}}" rel="stylesheet" type="text/css"/>
	<link href="{{asset('/plugins/font-awesome/css/font-awesome.css')}}" rel="stylesheet" type="text/css"/>
	<link href="{{asset('/css/animate.min.css')}}" rel="stylesheet" type="text/css"/>
	<link href="{{asset('/plugins/jquery-scrollbar/jquery.scrollbar.css')}}" rel="stylesheet" type="text/css"/>
	{{-- <link href="{{ asset('/plugins/jquery-datatable/css/jquery.dataTables.css')}}" rel="stylesheet" type="text/css" media="screen"/>
	<link href="{{asset('/plugins/bootstrap-select2/select2.css')}}" rel="stylesheet" type="text/css" media="screen"/>
	<link href="{{asset('/plugins/ios-switch/ios7-switch.css')}}" rel="stylesheet" type="text/css" media="screen">
	<link href="{{asset('/plugins/boostrap-slider/css/slider.css')}}" rel="stylesheet" type="text/css"/>
	<link href="{{asset('/plugins/dropzone/css/dropzone.min.css')}}" rel="stylesheet" type="text/css"/> --}}
	<!-- END CORE CSS FRAMEWORK -->

	<!-- BEGIN CSS TEMPLATE -->
	<link href="{{asset('/css/themes/coporate/style.css')}}" rel="stylesheet" type="text/css"/>
	<link href="{{asset('/css/themes/coporate/responsive.css')}}" rel="stylesheet" type="text/css"/>
	<link href="{{asset('/css/custom-icon-set.css')}}" rel="stylesheet" type="text/css"/>
	{{-- <link href="{{asset('plugins/boostrap-clockpicker/bootstrap-clockpicker.min.css')}}" rel="stylesheet" type="text/css" media="screen"/>
	<link href="{{asset('plugins/bootstrap-datepicker/css/datepicker.min.css')}}" rel="stylesheet" type="text/css" media="screen"/>
	<link href="{{asset('plugins/bootstrap-tag/bootstrap-tagsinput.min.css')}}" rel="stylesheet" type="text/css" media="screen"/> --}}

	<!-- CSS PROPIOS -->
	<link href="{{asset('/css/plugins/sweetalert.min.css')}}" rel="stylesheet" type="text/css"/>
	<link href="{{asset('/css/plugins/croppie.css')}}" rel="stylesheet" type="text/css"/>
	<link href="{{asset('/css/audits.css')}}" rel="stylesheet" type="text/css"/>
	<link href="{{asset('/css/plugins/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
	<link href="{{asset('plugins/fancybox/source/jquery.fancybox.css?v=2.1.7')}}" rel="stylesheet" type="text/css" media="screen" />
	<link href="{{asset('plugins/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5')}}" rel="stylesheet" type="text/css" media="screen" />
	<link href="{{asset('plugins/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7')}}" rel="stylesheet" type="text/css" media="screen" />
	<script src="{{asset('/plugins/jquery-1.8.3.min.js')}}" type="text/javascript"></script>
</head>
<body class="upper">
	<div class="container-fluid content-body" style="padding: 50px!important;">
		<div class="page-title">
			<h1 class="white"><span class="semi-bold">Resumen {{$audit->title}}</span></h1>
		</div>
		<ul class="list-group">
			<li class="list-group-item active white">Datos del auditor</li>
			<li class="list-group-item">
				<div class="row">
					<div class="col-sm-4 text-center">
						<img src="{{asset($audit->user->photo)}}" data-src="{{asset($audit->user->photo)}}" alt="Foto de perfil" class="profile-pic">
					</div>
					<div class="col-sm-8">
						<table class="table table-hover table-condense">
							<tbody>
								<tr>
									<td><span class="bold">Nombre: </span></td>
									<td>{{$audit->user->fullname}}</td>
								</tr>
								<tr>
									<td><span class="bold">Teléfono: </span></td>
									<td>{{$audit->user->phone}}</td>
								</tr>
								<tr>
									<td><span class="bold">Correo: </span></td>
									<td style="text-transform: initial;">{{$audit->user->email}}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</li>
		</ul>
		<ul class="list-group">
			<li class="list-group-item active white">Datos de la franquicia (sucursal)</li>
			<li class="list-group-item">
				<div class="row">
					<div class="col-sm-4 text-center">
						<img src="{{@asset($audit->branch->pictures->first()->path?:'img/default_office.png')}}" data-src="{{@asset($audit->branch->pictures->first()->path?:'img/default_office.png')}}" alt="Imagen portada" class="profile-pic">
					</div>
					<div class="col-sm-8">
						<table class="table table-hover table-condense">
							<tbody>
								<tr>
									<td><span class="bold">Nombre: </span></td>
									<td>{{$audit->branch->name}}</td>
								</tr>
								<tr>
									<td><span class="bold">Teléfono: </span></td>
									<td>{{$audit->branch->phone}}</td>
								</tr>
								<tr>
									<td><span class="bold">Dirección: </span></td>
									<td>{{$audit->branch->address}}, {{$audit->branch->state->name}}</td>
								</tr>
								<tr>
									<td><span class="bold">Status: </span></td>
									<td>
										{!! ( $audit->branch->status == 0 ? '<span class="label label-danger">Deshabilitada</span>' : (
											$audit->branch->status == 1 ? '<span class="label label-success">Habilitada</span>' : '<span class="label label-info">Desconocido</span>'
										) )!!}
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</li>
		</ul>
		<ul class="list-group">
			<li class="list-group-item active white">Datos de la auditoría</li>
			<li class="list-group-item">
				<table class="table table-hover table-condense">
					<tbody>
						@foreach( $details as $key => $auditDetails )
							@php
								$approved_questions = count(collect($auditDetails)->where('answer', 1));
								$na_questions = count(collect($auditDetails)->where('answer', 2));
							@endphp
							<tr>
								<td colspan="3">
									<span class="bold">{{$key}}</span>
								</td>
								<td>
									{{ ($approved_questions + $na_questions) . '/' . count($auditDetails) }}
								</td>
								<td>
									{{ round((100 * ($approved_questions + $na_questions) / count($auditDetails)),2)}}%
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
	</div>
	<script src="{{asset('/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js')}}" type="text/javascript"></script>
	<script src="{{ asset('plugins/boostrapv3/js/bootstrap.min.js') }}" type="text/javascript"></script>
	<script src="{{asset('/plugins/breakpoints.js')}}" type="text/javascript"></script>
	<script src="{{asset('/plugins/jquery-unveil/jquery.unveil.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('/plugins/jquery-block-ui/jqueryblockui.js')}}" type="text/javascript"></script>
	<!-- END CORE JS FRAMEWORK -->
	<!-- BEGIN PAGE LEVEL JS -->
	<script src="{{asset('/plugins/jquery-scrollbar/jquery.scrollbar.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('/plugins/pace/pace.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('/plugins/jquery-numberAnimate/jquery.animateNumbers.js')}}" type="text/javascript"></script>
	<script src="{{asset('/plugins/select2/select2.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('/plugins/dropzone/dropzone.js')}}" type="text/javascript"></script>
	<!-- END PAGE LEVEL PLUGINS -->

	<!-- BEGIN CORE TEMPLATE JS -->
	<script src="{{asset('/js/core.js')}}" type="text/javascript"></script>

	<!-- JQUERY DATATABLE -->
	{{-- <script src="{{ asset('/plugins/jquery-datatable/js/jquery.dataTables.js') }}" type="text/javascript"></script>
	<script src="{{ asset('/plugins/jquery-datatable/extra/js/dataTables.tableTools.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('/plugins/datatables-responsive/js/datatables.responsive.js') }}" type="text/javascript"></script>
	<script src="{{ asset('/plugins/datatables-responsive/js/lodash.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('/js/datatables.js') }}"></script> --}}

	<!-- JS PROPIOS -->
	{{-- <script src="{{asset('/js/script.js')}}" type="text/javascript"></script>
	<script src="{{asset('/js/plugins/sweetalert.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('/js/plugins/croppie.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('/js/validForm.js')}}" type="text/javascript"></script>
	<script src="{{asset('plugins/boostrap-clockpicker/bootstrap-clockpicker.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}" type="text/javascript"></script>
	<script src="{{asset('plugins/bootstrap-tag/bootstrap-tagsinput.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('/js/plugins/toastr.min.js')}}" type="text/javascript"></script> --}}
	<script src="{{asset('/js/generalAjax.js')}}" type="text/javascript"></script>
	<script type="text/javascript" src="{{asset('plugins/fancybox/source/jquery.fancybox.pack.js?v=2.1.7')}}"></script>
	<script type="text/javascript" src="{{asset('plugins/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5')}}"></script>
	<script type="text/javascript" src="{{asset('plugins/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6')}}"></script>
	<script type="text/javascript" src="{{asset('plugins/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7')}}"></script>
</body>
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
