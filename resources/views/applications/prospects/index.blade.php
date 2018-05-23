@extends('layouts.main')
@section('pageTitle', 'Prospectos')
@section('content')
<div class="container-fluid content-body">
    <div class="page-title">
        <h1>Listado <span class="semi-bold">Prospectos</span></h1>
    </div>
    @if( auth()->user()->role_id == 1 )
    {{-- <div class="row-fluid">
        @include('helpers.filters', ['index_url' => route('Office'), 'export_url' => null, 'dates' => false])
    </div> --}}
    @endif
    <div class="row-fluid text-left buttons-container general-info" data-url="{{url("admin/productos")}}" data-refresh="0">
        <a href="{{route('Office.form')}}" class="btn btn-success new-row"><i class="glyphicon glyphicon-plus"></i> Nuevo registro</a>
        <a href="{{route('Office.multipleDestroys')}}" class="btn btn-danger delete-rows disabled" disabled><i class="glyphicon glyphicon-trash"></i> Eliminar múltiple</a>
    </div>
    <div class="row-fluid">
        <div class="table-responsive" id="table-container">
            @include('applications.prospects.table')
        </div>
    </div>
</div>
@endsection
