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
	<div class="row-fluid">
		<div class="col-md-6 col-vgl-6 col-sm-6">
			<div class="tiles blue m-b-10">
				<div class="tiles-body">
					<div class="controller"> <a href="javascript:;" class="reload"></a> <a href="javascript:;" class="remove"></a> </div>
					<div class="tiles-title text-white">Bloque 1</div>
					<div class="widget-stats">
						<div class="wrapper transparent">
							<span class="item-title">Total</span> <span class="item-count animate-number semi-bold" data-value="0" data-animation-duration="10">0</span>
						</div>
					</div>
					<div class="widget-stats">
						<div class="wrapper transparent">
							<span class="item-title">Activos</span> <span class="item-count animate-number semi-bold" data-value="0" data-animation-duration="10">0</span>
						</div>
					</div>
					<div class="widget-stats ">
						<div class="wrapper last">
							<span class="item-title">Inactivos</span> <span class="item-count animate-number semi-bold" data-value="0" data-animation-duration="10">0</span>
						</div>
					</div>
					<div class="progress transparent progress-small no-radius m-t-20" style="width:90%">
						<div class="progress-bar progress-bar-white animate-progress-bar" data-percentage="100%" ></div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6 col-vgl-6 col-sm-6">
			<div class="tiles blue m-b-10">
				<div class="tiles-body">
					<div class="controller"> <a href="javascript:;" class="reload"></a> <a href="javascript:;" class="remove"></a> </div>
					<div class="tiles-title text-white">Bloque 1</div>
					<div class="widget-stats">
						<div class="wrapper transparent">
							<span class="item-title">Total</span> <span class="item-count animate-number semi-bold" data-value="0" data-animation-duration="10">0</span>
						</div>
					</div>
					<div class="widget-stats">
						<div class="wrapper transparent">
							<span class="item-title">Activos</span> <span class="item-count animate-number semi-bold" data-value="0" data-animation-duration="10">0</span>
						</div>
					</div>
					<div class="widget-stats ">
						<div class="wrapper last">
							<span class="item-title">Inactivos</span> <span class="item-count animate-number semi-bold" data-value="0" data-animation-duration="10">0</span>
						</div>
					</div>
					<div class="progress transparent progress-small no-radius m-t-20" style="width:90%">
						<div class="progress-bar progress-bar-white animate-progress-bar" data-percentage="100%" ></div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6 col-vgl-6 col-sm-6">
			<div class="tiles blue m-b-10">
				<div class="tiles-body">
					<div class="controller"> <a href="javascript:;" class="reload"></a> <a href="javascript:;" class="remove"></a> </div>
					<div class="tiles-title text-white">Bloque 1</div>
					<div class="widget-stats">
						<div class="wrapper transparent">
							<span class="item-title">Total</span> <span class="item-count animate-number semi-bold" data-value="0" data-animation-duration="10">0</span>
						</div>
					</div>
					<div class="widget-stats">
						<div class="wrapper transparent">
							<span class="item-title">Activos</span> <span class="item-count animate-number semi-bold" data-value="0" data-animation-duration="10">0</span>
						</div>
					</div>
					<div class="widget-stats ">
						<div class="wrapper last">
							<span class="item-title">Inactivos</span> <span class="item-count animate-number semi-bold" data-value="0" data-animation-duration="10">0</span>
						</div>
					</div>
					<div class="progress transparent progress-small no-radius m-t-20" style="width:90%">
						<div class="progress-bar progress-bar-white animate-progress-bar" data-percentage="100%" ></div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6 col-vgl-6 col-sm-6">
			<div class="tiles blue m-b-10">
				<div class="tiles-body">
					<div class="controller"> <a href="javascript:;" class="reload"></a> <a href="javascript:;" class="remove"></a> </div>
					<div class="tiles-title text-white">Bloque 1</div>
					<div class="widget-stats">
						<div class="wrapper transparent">
							<span class="item-title">Total</span> <span class="item-count animate-number semi-bold" data-value="0" data-animation-duration="10">0</span>
						</div>
					</div>
					<div class="widget-stats">
						<div class="wrapper transparent">
							<span class="item-title">Activos</span> <span class="item-count animate-number semi-bold" data-value="0" data-animation-duration="10">0</span>
						</div>
					</div>
					<div class="widget-stats ">
						<div class="wrapper last">
							<span class="item-title">Inactivos</span> <span class="item-count animate-number semi-bold" data-value="0" data-animation-duration="10">0</span>
						</div>
					</div>
					<div class="progress transparent progress-small no-radius m-t-20" style="width:90%">
						<div class="progress-bar progress-bar-white animate-progress-bar" data-percentage="100%" ></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
