@extends('layouts.main')
@section('pageTitle', 'Auditorías')
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
	@if( auth()->user()->role_id == 1 )
	<div class="row-fluid">
		@include('helpers.filters', ['index_url' => route('Audit'), 'export_url' => null, 'dates' => false])
	</div>
	@endif
	<div class="row-fluid">
		<div id="body-content">
			@include('audits.table')
		</div>
	</div>
</div>
@endsection
