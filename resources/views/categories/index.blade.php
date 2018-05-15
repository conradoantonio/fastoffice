@extends('layouts.main')
@section('pageTitle', 'Categorías')
@section('content')
<div class="container-fluid content-body">
	@if(session('msg'))
	<div class="alert alert-success">
		{{session('msg')}}
	</div>
	@endif
	<div class="page-title">
		<h1>Listado <span class="semi-bold">Categorías</span></h1>
	</div>
	<div class="row-fluid text-left buttons-container">
		<a href="{{route('Category.form')}}" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Nueva categoría</a>
		<a href="{{route('Category.multipleDestroys')}}" class="btn btn-danger multiple-delete-btn disabled" disabled><i class="glyphicon glyphicon-trash"></i> Eliminar múltiple</a>
	</div>
	<div class="row-fluid">
		<div id="body-content">
			@include('categories.table')
		</div>
	</div>
</div>
@endsection
