@extends('layouts.main')
@section('pageTitle', 'Plantillas')
@section('content')
<div class="container-fluid content-body">
	@if(session('msg'))
	<div class="alert alert-success">
		{{session('msg')}}
	</div>
	@endif
	<div class="page-title">
		<h1>Listado <span class="semi-bold">Plantillas</span></h1>
	</div>
	<div class="row-fluid text-left buttons-container">
		<a href="{{route('Template.form')}}" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Nueva plantilla</a>
		<a href="{{route('Template.multipleDestroys')}}" class="btn btn-danger multiple-delete-btn disabled" disabled><i class="glyphicon glyphicon-trash"></i> Eliminar múltiple</a>
	</div>
	<div class="row-fluid">
		<div id="body-content">
			@include('templates.table')
		</div>
	</div>
</div>
@endsection
