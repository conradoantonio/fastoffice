@extends('layouts.main')
@if( $user->role_id == 2 || $user->role_id == 4 )
	@section('pageTitle', 'Detalle de socio a validar')
@else
	@section('pageTitle', 'Detalle de cliente a validar')
@endif
@section('content')
<div class="container-fluid content-body">
	<div class="page-title">
		@if( !$user->valid )
			@if( $user->role_id == 2 || $user->role_id == 4 )
				<h1>Validar <span class="semi-bold">Socio</span></h1>
			@else
				<h1>Validar <span class="semi-bold">Cliente</span></h1>
			@endif
		@else
			<h1>Información <span class="semi-bold">
				@if( $user->role_id == 2 || $user->role_id == 4 )
					Socio
				@else
					Cliente
				@endif
			</span></h1>
		@endif
	</div>
	<div class="row-fluid">
		<div id="body-content">
			<ul class="list-group">
				<li class="list-group-item active">Datos del
				@if( $user->role_id == 2 || $user->role_id == 4 )
					Socio
				@elseif( $user->role_id == 3 )
					Cliente
				@endif
				</li>
				<li class="list-group-item">
					<div class="row">
						<div class="col-md-3 col-sm-4 text-center">
							<img src="{{!$user->photo?asset('/img/profiles/avatar_small.jpg'):asset('/img/profiles/'.$user->id.'/'.$user->photo)}}" alt="" data-src="{{!$user->photo?asset('/img/profiles/avatar_small.jpg'):asset('/img/profiles/'.$user->id.'/'.$user->photo)}}" data-src-retina="{{!$user->photo?asset('/img/profiles/avatar_small2x.jpg'):asset('/img/profiles/'.$user->id.'/'.$user->photo)}}" alt="Foto de perfil" data-src="{{asset('/img/profiles/avatar_small.jpg')}}" data-src-retina="{{asset('/img/profiles/avatar_small2x.jpg')}}" width="60%" class="profile_img">
						</div>
						<div class="col-md-9 col-sm-8">
							<ul>
								<li><strong>Nombre: </strong>{{$user->name}} {{$user->lastname}}</li>
								<li><strong>Teléfono: </strong>{{$user->phone}}</li>
								<li><strong>Dirección: </strong>{{$user->address}}</li>
								<li><strong>Correo: </strong>{{$user->email}}</li>
							</ul>
						</div>
					</div>
				</li>
			</ul>
			<ul class="list-group">
				<li class="list-group-item active">Documentos del socio</li>
				<li class="list-group-item">
					<div class="row">
						@if( $user->role_id == 2 || $user->role_id == 4 )
							@if($user->Identification && $user->CirculationCard && $user->InsurancePolicy)
								<div class="col-md-3 text-center">
									<h4>Identificación</h4>
									<a class="show" href="{{asset('img/docs/'.$user->id.'/'.$user->Identification->name)}}" {{strpos($user->Identification->name, 'pdf') === false?"rel=shadowbox":'target=_blank'}}>Ver documento</a>
									@if($user->Identification)
									<strong>Estatus: </strong><span class="status" {{$user->Identification->status!='Enviada'?'data-good=1':''}}>{{$user->Identification->status}}</span>
									@else
									<span><strong>Estatus: </strong>Sin enviar</span>
									@endif
									@if( $user->Identification->status != 'Aceptada' )
										<div class="row">
											<div class="col-md-offset-2 col-md-4">
												<button class="btn btn-primary accept reject accept" data-name="Identificación" data-url="{{route('Users.docs_valid', [$user->id, 1, 1])}}">Aceptar</button>
											</div>
											<div class="col-md-4">
												<button class="btn btn-danger accept reject reject" data-name="Identificación" data-url="{{route('Users.docs_valid', [$user->id, 2, 1])}}">Rechazar</button>
											</div>
										</div>
									@endif
								</div>
								<div class="col-md-3 text-center">
									<h4>Tarjeta de circulación</h4>
									<a class="show" href="{{asset('img/docs/'.$user->id.'/'.$user->CirculationCard->name)}}" {{strpos($user->CirculationCard->name, 'pdf') === false?"rel=shadowbox":'target=_blank'}} >Ver documento</a>
									@if($user->CirculationCard)
									<strong>Estatus: </strong><span class="status" {{$user->CirculationCard->status!='Enviada'?'data-good=1':''}}>{{$user->CirculationCard->status}}</span>
									@else
									<span><strong>Estatus: </strong>Sin enviar</span>
									@endif
									@if( $user->CirculationCard->status != 'Aceptada' )
										<div class="row">
											<div class="col-md-offset-2 col-md-4">
												<button class="btn btn-primary accept reject accept" data-name="Tarjeta de circulación" data-url="{{route('Users.docs_valid', [$user->id, 1, 2])}}">Aceptar</button>
											</div>
											<div class="col-md-4">
												<button class="btn btn-danger accept reject reject" data-name="Tarjeta de circulación" data-url="{{route('Users.docs_valid', [$user->id, 2, 2])}}">Rechazar</button>
											</div>
										</div>
									@endif
								</div>
								<div class="col-md-3 text-center">
									<h4>Póliza de seguro</h4>
									<a class="show" href="{{asset('img/docs/'.$user->id.'/'.$user->InsurancePolicy->name)}}" {{strpos($user->InsurancePolicy->name, 'pdf') === false?"rel=shadowbox":'target=_blank'}}>Ver documento</a>
									@if($user->InsurancePolicy)
									<strong>Estatus: </strong><span class="status"}} {{$user->InsurancePolicy->status!='Enviada'?'data-good=1':''}}>{{$user->InsurancePolicy->status}}</span>
									@else
									<span><strong>Estatus: </strong>Sin enviar</span>
									@endif
									@if( $user->InsurancePolicy->status != 'Aceptada' )
										<div class="row">
											<div class="col-md-offset-2 col-md-4">
												<button class="btn btn-primary accept reject accept" data-name="Póliza de seguro" data-url="{{route('Users.docs_valid', [$user->id, 1, 3])}}">Aceptar</button>
											</div>
											<div class="col-md-4">
												<button class="btn btn-danger accept reject reject" data-name="Póliza de seguro" data-url="{{route('Users.docs_valid', [$user->id, 2, 3])}}">Rechazar</button>
											</div>
										</div>
									@endif
								</div>
								<div class="col-md-3 text-center">
									<h4>Factura</h4>
									<a class="show" href="{{asset('img/docs/'.$user->id.'/'.$user->Bill->name)}}" {{strpos($user->Bill->name, 'pdf') === false?"rel=shadowbox":'target=_blank'}}>Ver documento</a>
									<a class="show" href="{{asset('img/docs/'.$user->id.'/'.$user->Endorsement->name)}}" {{strpos($user->Endorsement->name, 'pdf') === false?"rel=shadowbox":'target=_blank'}}>Endoso de factura</a>
									@if($user->Bill)
									<strong>Estatus: </strong><span class="status"}} {{$user->Bill->status!='Enviada'?'data-good=1':''}}>{{$user->Bill->status}}</span>
									@else
									<span><strong>Estatus: </strong>Sin enviar</span>
									@endif
									@if( $user->Bill->status != 'Aceptada' )
										<div class="row">
											<div class="col-md-offset-2 col-md-4">
												<button class="btn btn-primary accept reject accept" data-name="Factura" data-url="{{route('Users.docs_valid', [$user->id, 1, 5])}}">Aceptar</button>
											</div>
											<div class="col-md-4">
												<button class="btn btn-danger accept reject reject" data-name="Factura" data-url="{{route('Users.docs_valid', [$user->id, 2, 5])}}">Rechazar</button>
											</div>
										</div>
									@endif
								</div>
							@else
								<h5 class="text-center">No hay documentos del socio</h5>
							@endif
						@else
							@if($user->CirculationCard && $user->ProofAdress)
								<div class="col-md-4 text-center">
									<h4>Tarjeta de circulación</h4>
									<a class="show" href="{{asset('img/docs/'.$user->id.'/'.$user->CirculationCard->name)}}" {{strpos($user->CirculationCard->name, 'pdf') === false?"rel=shadowbox":'target=_blank'}} >Ver documento</a>
									@if($user->CirculationCard)
									<strong>Estatus: </strong><span class="status" {{$user->CirculationCard->status!='Enviada'?'data-good=1':''}}>{{$user->CirculationCard->status}}</span>
									@else
									<span><strong>Estatus: </strong>Sin enviar</span>
									@endif
									@if( !$user->valid )
										<div class="row">
											<div class="col-md-offset-2 col-md-4">
												<button class="btn btn-primary accept reject accept" data-name="Tarjeta de circulación" data-url="{{route('Users.docs_valid', [$user->id, 1, 2])}}">Aceptar</button>
											</div>
											<div class="col-md-4">
												<button class="btn btn-danger accept reject reject" data-name="Tarjeta de circulación" data-url="{{route('Users.docs_valid', [$user->id, 2, 2])}}">Rechazar</button>
											</div>
										</div>
									@endif
								</div>
								<div class="col-md-4 text-center">
									<h4>Comprobante de domicilio</h4>
									<a class="show" href="{{asset('img/docs/'.$user->id.'/'.$user->ProofAdress->name)}}" {{strpos($user->ProofAdress->name, 'pdf') === false?"rel=shadowbox":'target=_blank'}} >Ver documento</a>
									@if($user->ProofAdress)
									<strong>Estatus: </strong><span class="status" {{$user->ProofAdress->status!='Enviada'?'data-good=1':''}}>{{$user->ProofAdress->status}}</span>
									@else
									<span><strong>Estatus: </strong>Sin enviar</span>
									@endif
									@if( !$user->valid )
										<div class="row">
											<div class="col-md-offset-2 col-md-4">
												<button class="btn btn-primary accept reject accept" data-name="Comprobante de domicilio" data-url="{{route('Users.docs_valid', [$user->id, 1, 4])}}">Aceptar</button>
											</div>
											<div class="col-md-4">
												<button class="btn btn-danger accept reject reject" data-name="Comprobante de domicilio" data-url="{{route('Users.docs_valid', [$user->id, 2, 4])}}">Rechazar</button>
											</div>
										</div>
									@endif
								</div>
								<div class="col-md-4 text-center">
									<h4>Licencia de conducir</h4>
									<a class="show" href="{{asset('img/docs/'.$user->id.'/'.$user->License->name)}}" {{strpos($user->License->name, 'pdf') === false?"rel=shadowbox":'target=_blank'}} >Ver documento</a>
									@if($user->License)
									<strong>Estatus: </strong><span class="status" {{$user->License->status!='Enviada'?'data-good=1':''}}>{{$user->License->status}}</span>
									@else
									<span><strong>Estatus: </strong>Sin enviar</span>
									@endif
									@if( !$user->valid )
										<div class="row">
											<div class="col-md-offset-2 col-md-4">
												<button class="btn btn-primary accept reject accept" data-name="Licencia de conducir" data-url="{{route('Users.docs_valid', [$user->id, 1, 6])}}">Aceptar</button>
											</div>
											<div class="col-md-4">
												<button class="btn btn-danger accept reject reject" data-name="Licencia de conducir" data-url="{{route('Users.docs_valid', [$user->id, 2, 6])}}">Rechazar</button>
											</div>
										</div>
									@endif
								</div>
							@else
								<h5 class="text-center">No hay documentos del usuario</h5>
							@endif
						@endif
					</div>
				</li>
			</ul>
			@if( $user->role_id == 2 )
				<ul class="list-group">
					<li class="list-group-item active">Cuenta bancaria del socio</li>
					<li class="list-group-item">
						<div class="row">
							<div class="col-md-12">
								@if($user->bankAccount)
									<ul>
										<li><strong>Banco: </strong>{{$user->bankAccount->bank->name}}</li>
										<li><strong>Clabe: </strong>{{$user->bankAccount->clabe}}</li>
										<li><strong>Cuenta: </strong> {{$user->bankAccount->account_number}}</li>
									</ul>
								@else
									<h5 class="text-center">No hay información de la cuenta del socio</h5>
								@endif
							</div>
						</div>
					</li>
				</ul>
			@endif
			<div class="row-fluid">
				<div class="text-center">
					@if( $user->role_id == 4 )
						<a class="btn btn-default" href="{{route('ValidPartners')}}">Regresar</a>
						@if($user->Identification && $user->CirculationCard && $user->InsurancePolicy && $user->Bill)
							<div id="options" style="display: inline-block;" class="{{$user->CirculationCard->status != 'Pendiente' && $user->Identification->status != 'Pendiente' && $user->InsurancePolicy->status != 'Pendiente' && $user->Bill->status != 'Pendiente' && $user->CirculationCard->status != 'Enviada' && $user->Identification->status != 'Enviada' && $user->InsurancePolicy->status != 'Enviada' && $user->Bill->status != 'Enviada' ?'':'hide'}}">
								@if(!$user->request )
								<button class="btn btn-primary valid" data-url="{{route('Users.valid',[$user->id])}}">Validar socio</button>
								@endif
							</div>
						@endif
					@elseif($user->role_id == 3 )
						<a class="btn btn-default" href="{{route('ValidClients')}}">Regresar</a>
						@if($user->CirculationCard && $user->ProofAdress)
							<div id="options" style="display: inline-block;" class="{{$user->CirculationCard->status != 'Pendiente'&& $user->CirculationCard->status != 'Enviada' && $user->ProofAdress->status != 'Pendiente'&& $user->ProofAdress->status != 'Enviada' && $user->License->status != 'Pendiente'&& $user->License->status != 'Enviada' ?'':'hide'}}">
								@if(!$user->request )
								<button class="btn btn-primary valid" data-url="{{$user->role_id==2?route('Users.valid',[$user->id]):route('Client.valid',[$user->id])}}">Validar cliente</button>
								@endif
							</div>
						@endif
					@else
						<a class="btn btn-default" href="{{route('Users',2)}}">Regresar</a>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
<script src="https://cdn.jsdelivr.net/shadowbox/3.0.3/shadowbox.js" integrity="sha256-qrFwKJW/0YDRgYhvKXgTnsXDA9ikxpsr+oTNNbqHm1c=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/shadowbox/3.0.3/shadowbox.css" integrity="sha256-796KZIBOSFaMueR7dm518U3W9iHIRw6gzkKfGGlVfQ4=" crossorigin="anonymous">
<script>
	Shadowbox.init({
		modal: true
	});

	$('button.valid').on('click', function(){
		var ele = $(this);
		swal({
			title: '¿Enviar estado de solicitud al socio?',
			icon: 'info',
			closeOnEsc: false,
			closeOnClickOutside: false,
			buttons: ['Cancelar', 'Aceptar'],
		}).then((accept) => {
			if( accept ){
				swal({
					title: 'Guardando',
					buttons: false,
					closeOnEsc: false,
					closeOnClickOutside: false,
					content: {
						element: "div",
						attributes: {
							innerHTML:"<i class='fa fa-circle-o-notch fa-spin fa-3x fa-fw'></i>"
						},
					}
				}).catch(swal.noop);
				window.location = ele.data('url')
			}
		})
	});

	$('button.accept').on('click', function(){
		var client = '{{$user->role_id}}';
		var ele = $(this);
		var valid = $(this).hasClass('accept')?'Aceptar':'Rechazar';
		swal({
			title: '¿'+valid+' '+ele.data('name')+' del socio?',
			icon: 'info',
			closeOnEsc: false,
			closeOnClickOutside: false,
			buttons: ['Cancelar', 'Aceptar'],
		}).then((accept) => {
			if( accept ){
				$.ajax({
					url:ele.data('url'),
					type:"GET",
					success:function(response){
						var count = 0;
						if( response.save ){
							swal(ele.data('name')+' aceptado', '', 'success')
							ele.parent().parent().siblings('span.status').text('aceptado')

							ele.parent().parent().siblings('span.status').attr('data-good', 1)

							$("span[data-good=1]").each(function(i,e){
								count += 1;
							});

							if ( client != 3 ){
								if ( count == 4 ) {
									$('#options').removeClass('hide');
								}  else {
									$('#options').addClass('hide');
								}
							} else {
								if ( count == 3 ) {
									$('#options').removeClass('hide');
								}  else {
									$('#options').addClass('hide');
								}
							}

						} else {
							swal('Error', 'Ocurrio un problema al guardar, intenta de nuevo', 'error')
						}
					}
				})
			}
		})
	});

	$('button.reject').on('click', function(){
		var client = '{{$user->role_id}}';
		var ele = $(this);
		var valid = $(this).hasClass('accept')?'Aceptar':'Rechazar';
		swal({
			title: 'Justifique el porqué del rechazo del documento',
			icon: 'info',
			closeOnEsc: false,
			closeOnClickOutside: false,
			content: {
				element: "textarea",
				attributes: {
					rows: '6',
					autofocus: true
				},
			},
			dangerMode:true
		}).then((accept) => {
			var des = $('.swal-content__textarea').val()
			if( des ){
				$.ajax({
					url:ele.data('url') +'/'+encodeURI(des),
					type:"GET",
					success:function(response){
						var count = 0;
						if( response.save ){
							swal(ele.data('name')+' rechazado', '', 'success')
							ele.parent().parent().siblings('span.status').text('rechazado')

							ele.parent().parent().siblings('span.status').attr('data-good', 1)

							$("span[data-good=1]").each(function(i,e){
								count += 1;
							});

							if ( client != 3 ){
								if ( count == 4 ) {
									$('#options').removeClass('hide');
								}  else {
									$('#options').addClass('hide');
								}
							} else {
								if ( count == 3 ) {
									$('#options').removeClass('hide');
								}  else {
									$('#options').addClass('hide');
								}
							}
						} else {
							swal('Error', 'Ocurrio un problema al guardar, intenta de nuevo', 'error')
						}
					}
				});
			}
		})
	});
</script>
@endsection