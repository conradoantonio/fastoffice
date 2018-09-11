@extends('layouts.main')
@section('pageTitle', 'Formulario para preguntas de auditoría')
@section('content')
<div class="container-fluid content-body">
	@if(session('msg'))
	<div class="alert alert-danger">
		{{session('msg')}}
	</div>
	@endif
	<div class="page-title">
		<h1>{{$question ? 'Actualizar' : 'Crear'}} <span class="semi-bold">pregunta</span></h1>
	</div>
	<div class="row-fluid">
        <form id="form-data" class="valid ajax-plus" action="{{url('questionario/auditoria')}}/{{$question ? 'actualizar' : 'guardar'}}" onsubmit="return false;" enctype="multipart/form-data" method="POST" autocomplete="off" data-ajax-type="ajax-form" data-column="0" data-refresh="0" data-redirect="1" data-table_id="example3" data-container_id="table-container">
        	<div class="row">
        	 	<div class="form-group col-sm-6 col-xs-12 hide">
	                <label class="required" for="id">ID</label>
	                <input type="text" class="form-control" value="{{$question ? $question->id : ''}}" id="id" name="id">
	            </div>
        	</div>
        	<div class="row">
        		<div class="form-group col-sm-12 col-xs-12">
                    <label class="required" for="question">Pregunta</label>
                    <input type="text" class="form-control not-empty" value="{{$question ? $question->question : ''}}" name="question" data-name="Pregunta">
                </div>
        	</div>
        	<div class="row">
        		<div class="form-group col-sm-12 col-xs-12">
                    <label class="required" for="category_id">Categoría</label>
	                <select name="category_id" id="category_id" class="form-control not-empty select2" data-name="Categoría">
	                    <option value="" disabled selected>Seleccione una opción</option>
	                    @if ($question)
	                        @foreach($categories as $category)
	                            <option value="{{$category->id}}" {{$question->category_id == $category->id ? 'selected' : ''}}>{{$category->name}}</option>
	                        @endforeach
	                    @else
	                        @foreach($categories as $category)
	                            <option value="{{$category->id}}">{{$category->name}}</option>
	                        @endforeach
	                    @endif
	                </select>
                </div>
        	</div>

        	<a href="{{route('Questionary')}}"><button type="button" class="btn btn-danger">Regresar</button></a>
            <button type="submit" class="btn btn-success guardar" data-target="form-data">Guardar</button>
        </form>
	</div>
</div>
@push('scripts')
	<script type="text/javascript">
		
	</script>
@endpush
@endsection
