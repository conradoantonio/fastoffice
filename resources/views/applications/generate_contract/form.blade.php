@extends('layouts.main')
@section('pageTitle', 'Erp')
@section('content')
<div class="container-fluid content-body">
	@if(session('msg'))
	<div class="alert alert-danger">
		{{session('msg')}}
	</div>
	@endif
	<div class="page-title">
		<h1>{{$prospect ? 'Generar' : 'Crear'}} <span class="semi-bold">Contrato</span></h1>
	</div>
	<div class="row-fluid">
        <form id="form-data" class="valid ajax-plus" action="{{url('crm/prospectos')}}/{{$prospect ? 'actualizar-prospecto' : 'guardar-prospecto'}}" onsubmit="return false;" enctype="multipart/form-data" method="POST" autocomplete="off" data-ajax-type="ajax-form" data-column="0" data-refresh="0" data-redirect="1" data-table_id="example3" data-container_id="table-container">
	        	<div class="row">
	        	 	<div class="form-group col-sm-6 col-xs-12 hide">
		                <label class="required" for="id">ID</label>
		                <input type="text" class="form-control" value="{{$prospect ? $prospect->id : ''}}" id="id" name="id">
		            </div>
	        	</div>
	        	{{-- Application details data --}}
	        	<div class="row">
	        		<div class="form-group col-sm-12 col-xs-12">
	                    <label class="required" for="badget">Presupuesto del cliente</label>
	                    <input type="text" class="form-control not-empty execute-search numeric" value="{{$prospect ? $prospect->detail->badget : ''}}" id="badget" name="badget" data-name="Presupuesto">
	                </div>
	        	</div>
	        	<div class="row">
	        		<div class="form-group col-sm-12 col-xs-12">
	                    <label class="required" for="num_people">Número de personas</label>
	                    <input type="text" class="form-control not-empty execute-search numeric" value="{{$prospect ? $prospect->detail->num_people : ''}}" id="num_people" name="num_people" data-name="Número de personas">
	                </div>
	        	</div>
        	<hr>

        	<a href="{{route('Crm.prospects')}}"><button type="button" class="btn btn-danger">Regresar</button></a>
            <button type="submit" class="btn btn-success guardar" data-target="form-data">Guardar</button>
        </form>
	</div>
</div>
@push('scripts')
	<script type="text/javascript">
		$(function() {
			
		});
	</script>
@endpush
@endsection
