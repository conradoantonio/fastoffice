@extends('layouts.main')
@section('pageTitle', 'Usuarios')
@section('content')
<div class="container-fluid content-body">
	@if(session('msg'))
	<div class="alert {{session('class')}}">
		{{session('msg')}}
	</div>
	@endif
	<div class="page-title">
		<h1>Listado <span class="semi-bold">Usuarios</span></h1>
	</div>
	<div class="row-fluid text-left buttons-container">
		<a href="{{route('User.form')}}" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Nuevo usuario sistema</a>
	</div>
	<div class="row-fluid">
		<div id="body-content">
			@include('users.table')
		</div>
	</div>
</div>
@endsection
