@extends('layouts.main')
@section('pageTitle', 'Noticias')
@section('content')
<div class="container-fluid content-body">
	@if(session('msg'))
	<div class="alert alert-danger">
		{{session('msg')}}
	</div>
	@endif
	<div class="page-title">
		<h1>{{$new->id ? 'Actualizar' : 'Crear'}} <span class="semi-bold">Noticia</span></h1>
	</div>
	<div class="row-fluid">
	{{ Form::model($new, ['route' => !$new->id?'News.store':['News.update', $new->id], 'class' => 'form valid', 'id' => 'newsForm' ,'autocomplete' => 'off', 'files' => true]) }}
			@if($new->id)
			{{ method_field('PUT') }}
			@endif
			<div class="row">
				<div class="form-group col-md-12 {{$errors->new->first('title')?'has-error':''}}">
					{{Form::label('title', 'Título', ['class' => 'control-label  required'])}}
					{{Form::text('title', null, ['class' => 'form-control not-empty', 'data-name' => 'Título'])}}
					{{@$errors->new->first('title')}}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-12 {{$errors->new->first('content')?'has-error':''}}">
					{{Form::label('content', 'Contenido', ['class' => 'control-label  required'])}}
					{{Form::textarea('content', null, ['class' => 'form-control not-empty', 'data-name' => 'Contenido'])}}
				</div>
			</div>
			<div class="row">
				@if( $new->photo )
					<div class="col-md-3">
						<img src="{{asset('img/news/'.$new->id.'/'.$new->photo)}}" alt="Foto noticia" class="show">
					</div>
				@endif
				<div class="form-group col-md-{{$new->photo?'9':'12'}} {{$errors->new->first('photo')?'has-error':''}}">
					{{Form::label('photo', 'Foto', ['class' => !$new->id?'label-control required':'label-control'])}}
					{{Form::file('photo', ['class' =>!$new->id?'form-control not-empty file image':'form-control file image', 'data-name' => 'Foto'])}}
				</div>
			</div>
			<div class="row text-left buttons-form">
				<a href="{{route('News')}}" class="btn btn-danger">Regresar</a>
				{{Form::submit('Guardar',['class' => 'btn btn-success guardar', 'data-target' => 'newsForm'])}}
			</div>
		{{ Form::close() }}
	</div>
</div>
@endsection
