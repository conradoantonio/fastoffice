@extends('layouts.main')
@section('pageTitle', 'Categorías')
@section('content')
<div class="container-fluid content-body">
	@if(session('msg'))
	<div class="alert alert-danger">
		{{session('msg')}}
	</div>
	@endif
	<div class="page-title">
		<h1>{{$category->id ? 'Actualizar' : 'Crear'}} <span class="semi-bold">Categoría</span></h1>
	</div>
	<div class="row-fluid">
	{{ Form::model($category, ['route' => !$category->id?['Category.store']:['Category.update', $category->id], 'class' => 'form valid', 'id' => 'categoriesForm' ,'autocomplete' => 'off']) }}
			@if($category->id)
			{{ method_field('PUT') }}
			@endif
			<div class="row">
				<div class="form-group col-md-12">
					{{Form::label('name', 'Nombre', ['class' => 'control-label  required'])}}
					{{Form::text('name', null, ['class' => 'form-control not-empty', 'data-name' => 'Nombre'])}}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-12">
					{{Form::label('type', 'Tipo', ['class' => !$category->id?'label-control required':'label-control'])}}
					{{Form::select('type', [0 => 'Seleccione un tipo', 1 => 'Ingreso', 2 => 'Egreso'], null, ['class' => 'form-control not-empty', 'data-name' => 'Tipo'])}}
				</div>
			</div>
			<div class="row buttons-form">
				<a href="{{route('Category')}}" class="btn btn-danger">Regresar</a>
				{{Form::submit('Guardar',['class' => 'btn btn-success guardar', 'data-target' => 'categoriesForm'])}}
			</div>
		{{ Form::close() }}
	</div>
</div>
@endsection
