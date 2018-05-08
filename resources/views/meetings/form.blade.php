@extends('layouts.main')
@section('pageTitle', 'Calendario')
@section('content')
<div class="container-fluid content-body">
	@if(session('msg'))
	<div class="alert alert-danger">
		{{session('msg')}}
	</div>
	@endif
	<div class="page-title">
		<h1>{{$meeting->id ? 'Actualizar' : 'Crear'}} <span class="semi-bold">Reunión/Junta</span></h1>
	</div>
	<div class="row-fluid">
	{{ Form::model($meeting, ['route' => !$meeting->id?'Meeting.store':['Meeting.update', $meeting->id], 'class' => 'form valid', 'id' => 'meetingsForm' ,'autocomplete' => 'off']) }}
			@if($meeting->id)
			{{ method_field('PUT') }}
			@endif
			<div class="row">
				<div class="form-group col-md-12 {{$errors->meeting->first('title')?'has-error':''}}">
					{{Form::label('title', 'Título', ['class' => 'control-label  required'])}}
					{{Form::text('title', null, ['class' => 'form-control not-empty', 'data-name' => 'Título'])}}
					{{@$errors->meeting->first('title')}}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-6 {{$errors->meeting->first('datetime')?'has-error':''}}">
					{{Form::label('date', 'Fecha inicio', ['class' => 'control-label required'])}}
					{{Form::text('date', null, ['class' => 'form-control not-empty input-date', 'data-name' => 'Fecha inicio'])}}
					{{@$errors->meeting->first('datetime')}}
				</div>
				<div class="form-group col-md-6 {{$errors->meeting->first('datetime')?'has-error':''}}">
					{{Form::label('hour', 'Hora inicio', ['class' => 'control-label required'])}}
					{{Form::text('hour', null, ['class' => 'form-control clockpicker not-empty', 'data-name' => 'Hora inicio'])}}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-6 {{$errors->meeting->first('user_id')?'has-error':''}}">
					{{Form::label('user_id', 'Usuario', ['class' => 'control-label'])}}
					{!!Form::select('user_id', $users, $meeting->id?$meeting->user_id:null, ['class' => 'select2 form-control', 'id' => 'user_id', 'name' => 'user_id', 'data-name' => 'Usuario'] )!!}
					{{@$errors->meeting->first('user_id')}}
				</div>
				<div class="form-group col-md-6 {{$errors->meeting->first('office_id')?'has-error':''}}">
					{{Form::label('office_id', 'Oficina', ['class' => 'control-label required'])}}
					{!!Form::select('office_id', $offices, $meeting->id?$meeting->office_id:null, ['class' => 'select2 form-control not-empty', 'id' => 'office_id', 'name' => 'office_id', 'data-name' => 'Oficina'] )!!}
					{{@$errors->meeting->first('office_id')}}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-12 {{$errors->meeting->first('description')?'has-error':''}}">
					{{Form::label('description', 'Descripción', ['class' => 'control-label required'])}}
					{{Form::textarea('description', null, ['class' => 'form-control not-empty', 'data-name' => 'Descripción'])}}
					{{@$errors->meeting->first('description')}}
				</div>
			</div>
			<div class="row text-left buttons-form">
				<a href="{{route('Meeting')}}" class="btn btn-danger">Regresar</a>
				{{Form::submit('Guardar',['class' => 'btn btn-success guardar', 'data-target' => 'meetingsForm'])}}
			</div>
		{{ Form::close() }}
	</div>
</div>
@endsection
