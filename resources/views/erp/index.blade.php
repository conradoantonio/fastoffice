@extends('layouts.main')
@section('pageTitle', 'ERP')
@section('content')
<div class="container-fluid content-body">
	@if(session('msg'))
	<div class="alert alert-success">
		{{session('msg')}}
	</div>
	@endif
	<div class="page-title">
		<h1><span class="semi-bold">Ingresos y egresos</span></h1>
	</div>
	@if( auth()->user()->role_id == 1 || ( auth()->user()->role_id == 2 && auth()->user()->branches ) )
		<div class="row-fluid">
			@include('helpers.filters', ['index_url' => route('Erp'), 'export_url' => route('Erp.export'), 'dates' => true])
		</div>
	@endif
	<div class="row-fluid">
		<div id="body-content">
			@include('erp.content')
		</div>
	</div>
</div>
@endsection
