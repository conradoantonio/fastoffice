@extends('layouts.main')
@section('pageTitle', 'Banners')
@section('content')
<div class="container-fluid content-body">
	@if(session('msg'))
	<div class="alert alert-danger">
		{{session('msg')}}
	</div>
	@endif
	<div class="page-title">
		<h1>{{$banner->id ? 'Actualizar' : 'Crear'}} <span class="semi-bold">Banner</span></h1>
	</div>
	<div class="row-fluid">
	{{ Form::model($banner, ['route' => !$banner->id?['Banner.store']:['Banner.update', $banner->id], 'class' => 'form valid', 'id' => 'bannersForm' ,'autocomplete' => 'off', 'files' => true]) }}
			@if($banner->id)
			{{ method_field('PUT') }}
			@endif
			<div class="row">
				@if( $banner->image )
					<div class="col-md-3">
						<img src="{{asset('img/banners/'.$banner->id.'/'.$banner->image)}}" alt="Foto banner" class="show">
					</div>
				@endif
				<div class="form-group col-md-{{$banner->image?'9':'12'}} {{$errors->banner->first('image')?'has-error':''}}">
					{{Form::label('image', 'Imagen', ['class' => !$banner->id?'label-control required':'label-control'])}}
					{{Form::file('image', ['class' =>!$banner->id?'form-control not-empty file image':'form-control file image', 'data-name' => 'Foto'])}}
				</div>
			</div>
			<div class="row text-left buttons-form">
				<a href="{{route('Banner')}}" class="btn btn-danger">Regresar</a>
				{{Form::submit('Guardar',['class' => 'btn btn-success guardar', 'data-target' => 'bannersForm'])}}
			</div>
		{{ Form::close() }}
	</div>
</div>
@endsection
