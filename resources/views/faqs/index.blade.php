@extends('layouts.main')
@section('pageTitle', 'Faqs')
@section('content')
<div class="container-fluid content-body">
	@if(session('msg'))
	<div class="alert alert-success">
		{{session('msg')}}
	</div>
	@endif
	<div class="page-title">
		<h1>Listado <span class="semi-bold">Preguntas frecuentes</span></h1>
	</div>
	<div class="row-fluid text-left buttons-container">
		<a href="{{route('Faq.form')}}" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Nueva pregunta frecuente</a>
		<a href="{{route('Faq.multipleDestroys')}}" class="btn btn-danger multiple-delete-btn disabled" disabled><i class="glyphicon glyphicon-trash"></i> Eliminar multiple</a>
	</div>
	<div class="row-fluid">
		<div id="body-content">
			@include('faqs.table')
		</div>
	</div>
</div>
@endsection
