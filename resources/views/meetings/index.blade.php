@extends('layouts.main')
@section('pageTitle', 'Noticias')
@section('content')
<div class="container-fluid content-body">
	@if(session('msg'))
	<div class="alert alert-success">
		{{session('msg')}}
	</div>
	@endif
	<div class="page-title">
		<h1><span class="semi-bold">Calendario</span></h1>
	</div>
	<div class="row-fluid text-left buttons-container">
		<a href="{{route('Meeting.form')}}" class="btn btn-success add"><i class="glyphicon glyphicon-plus"></i> Nueva reunión</a>
		<a href="{{route('Meeting.multipleDestroys')}}" class="btn btn-danger multiple-delete-btn disabled" disabled><i class="glyphicon glyphicon-trash"></i> Eliminar multiple</a>
	</div>
	<div class="row-fluid">
		<div id="body-content">
			@include('meetings.table')
		</div>
	</div>
</div>
@endsection
