@extends('layouts.main')
@section('pageTitle', 'Faqs')
@section('content')
<div class="container-fluid content-body">
	@if(session('msg'))
	<div class="alert alert-danger">
		{{session('msg')}}
	</div>
	@endif
	<div class="page-title">
		<h1>{{$faq->id ? 'Actualizar' : 'Crear'}} <span class="semi-bold">Pregunta frecuente</span></h1>
	</div>
	<div class="row-fluid">
	{{ Form::model($faq, ['route' => !$faq->id?['Faq.store']:['Faq.update', $faq->id], 'class' => 'form valid', 'id' => 'faqsForm' ,'autocomplete' => 'off']) }}
			@if($faq->id)
			{{ method_field('PUT') }}
			@endif
			<div class="row">
				<div class="form-group col-md-12 {{$errors->faq->first('question')?'has-error':''}}">
					{{Form::label('question', 'Título', ['class' => 'control-label  required'])}}
					{{Form::text('question', null, ['class' => 'form-control not-empty', 'data-name' => 'Título'])}}
					{{@$errors->faq->first('question')}}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-12 {{$errors->faq->first('answer')?'has-error':''}}">
					{{Form::label('answer', 'Respuesta', ['class' => !$faq->id?'label-control required':'label-control'])}}
					{{Form::textarea ('answer', null, ['class' => 'form-control not-empty', 'data-name' => 'Respuesta'])}}
				</div>
			</div>
			<div class="row buttons-form">
				<a href="{{route('Faq')}}" class="btn btn-danger">Regresar</a>
				{{Form::submit('Guardar',['class' => 'btn btn-success guardar', 'data-target' => 'faqsForm'])}}
			</div>
		{{ Form::close() }}
	</div>
</div>
@endsection
