@extends('layouts.main')
@section('pageTitle', 'Oficinas')
@section('content')
<div class="container-fluid content-body">
	@if(session('msg'))
	<div class="alert alert-success">
		{{session('msg')}}
	</div>
	@endif
	<div class="page-title">
		<h1>Listado <span class="semi-bold">Oficinas</span></h1>
	</div>
	<div class="row-fluid text-left buttons-container">
		<a href="{{route('Office.form')}}" class="btn btn-success add"><i class="glyphicon glyphicon-plus"></i> Nueva oficina</a>
		<a href="{{route('Office.multipleDestroys')}}" class="btn btn-danger multiple-delete-btn disabled" disabled><i class="glyphicon glyphicon-trash"></i> Eliminar múltiple</a>
	</div>
	<div class="row-fluid">
		<div id="body-content">
			@include('offices.table')
		</div>
	</div>
</div>
@endsection
