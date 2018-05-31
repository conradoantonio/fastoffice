@extends('layouts.main')
@section('pageTitle', 'Oficinas')
@section('content')
@include('branches.modal')
<div class="container-fluid content-body">
	@if(session('msg'))
	<div class="alert alert-success">
		{{session('msg')}}
	</div>
	@endif
	<div class="page-title">
		<h1>Listado <span class="semi-bold">Oficinas</span></h1>
	</div>
	@if( auth()->user()->role_id == 1 )
	<div class="row-fluid">
		@include('helpers.filters', ['index_url' => route('Office'), 'export_url' => null, 'dates' => false])
	</div>
	@endif
	<div class="row-fluid text-left buttons-container">
		<a href="{{route('Office.form')}}" class="btn btn-success add"><i class="glyphicon glyphicon-plus"></i> Nueva oficina</a>
		<a href="{{route('Office.multipleDestroys')}}" class="btn btn-danger multiple-delete-btn disabled" disabled><i class="glyphicon glyphicon-trash"></i> Eliminar múltiple</a>
		<button class="btn btn-info" data-toggle="modal" data-target="#ModalExcel"><i class="glyphicon glyphicon-cloud-upload"></i> Importar oficinas</button>
	</div>
	<div class="row-fluid">
		<div id="body-content">
			@include('offices.table')
		</div>
	</div>
</div>
@endsection
