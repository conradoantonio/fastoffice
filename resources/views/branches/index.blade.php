@extends('layouts.main')
@section('pageTitle', 'Franquicias')
@section('content')
@include('branches.modal', ['import_url' => route('Branch.excel')])
<div class="container-fluid content-body">
	@if(session('msg'))
	<div class="alert alert-success">
		{{session('msg')}}
	</div>
	@endif
	<div class="page-title">
		<h1>Listado <span class="semi-bold">franquicias</span></h1>
	</div>
	<div class="row-fluid text-left buttons-container">
		<a href="{{route('Branch.form')}}" class="btn btn-success add"><i class="glyphicon glyphicon-plus"></i> Nueva Franquicia</a>
		<a href="{{route('Branch.multipleDestroys')}}" class="btn btn-danger multiple-delete-btn disabled" disabled><i class="glyphicon glyphicon-trash"></i> Eliminar múltiple</a>
		<button class="btn btn-info" data-toggle="modal" data-target="#ModalExcel"><i class="glyphicon glyphicon-cloud-upload"></i> Importar sucursales</button>
	</div>
	<div class="row-fluid">
		<div id="body-content">
			@include('branches.table')
		</div>
	</div>
</div>
@endsection
