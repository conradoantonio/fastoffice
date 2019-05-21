@extends('layouts.main')
@section('pageTitle', 'Home')
@section('content')
<div class="container-fluid content-body">
	@if(session('msg'))
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
		{{session('msg')}}
	</div>
	@endif
	<div class="page-title">
	<h1><span class="semi-bold">Dashboard</span></h1>
	</div>
	<div class="row">
		<div class="col-md-3 col-sm-6">
			<a href="{{route('Crm.prospects')}}"><img class="img-responsive" src="{{asset('img/dashboard/prospectos.png')}}"></a>
		</div>
		
		<div class="col-md-3 col-sm-6">
			<a href="{{route('Meeting')}}"><img class="img-responsive" src="{{asset('img/dashboard/calendario.png')}}"></a>
		</div>
		
		<div class="col-md-3 col-sm-6">
			<a href="{{route('Erp')}}"><img class="img-responsive" src="{{asset('img/dashboard/egreso.png')}}"></a>
		</div>
	</div>

	<div class="row" style="padding-top: 5%;">
		<div class="col-md-3 col-sm-6">
			<a href="{{route('Erp')}}"><img class="img-responsive" src="{{asset('img/dashboard/ingreso.png')}}"></a>
		</div>
		
		@if(auth()->user()->role->name == 'Administrador')
			<div class="col-md-3 col-sm-6">
				<a href="{{route('Branch')}}"><img class="img-responsive" src="{{asset('img/dashboard/franquicias.png')}}"></a>
			</div>
		@endif

		<div class="col-md-3 col-sm-6">
			<a href="{{route('Office')}}"><img class="img-responsive" src="{{asset('img/dashboard/oficinas.png')}}"></a>
		</div>
	</div>

	<div class="row" style="padding-top: 5%;">
		@if(auth()->user()->role->name == 'Administrador')
			<div class="col-md-3 col-sm-6">
				<a href="{{route('Audit')}}"><img class="img-responsive" src="{{asset('img/dashboard/auditorias.png')}}"></a>
			</div>
		@endif
		<div class="col-md-3 col-sm-6">
			<button data-url="{{route('Crm.prospects.history')}}" class="btn btn-block btn-danger buts-red">Prospectos descartados</button>
			<button data-url="{{route('Crm.contracts')}}" class="btn btn-block btn-success buts-red">Contratos clientes</button>
			<button data-url="{{route('Crm.contracts.finished')}}" class="btn btn-block btn-info buts-red">Contratos finalizados</button>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(".buts-red").on('click',function(e) {
		window.location.href = $(this).data('url');
	})

</script>
	
@endsection
