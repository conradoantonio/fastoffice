@extends('layouts.main')
@section('pageTitle', 'Franquicias')
@section('content')
<div class="container-fluid content-body">
	@if(session('msg'))
	<div class="alert alert-danger">
		{{session('msg')}}
	</div>
	@endif
	<div class="page-title">
		<h1>{{$branch->id ? 'Actualizar' : 'Crear'}} <span class="semi-bold">Franquicia</span></h1>
	</div>
	<div class="row-fluid">
	{{ Form::model($branch, ['route' => !$branch->id?'Branch.store':['Branch.update', $branch->id], 'class' => 'form valid', 'id' => 'branchesForm' ,'autocomplete' => 'off', 'files' => true]) }}
			@if($branch->id)
			{{ method_field('PUT') }}
			@endif
			<div class="row">
				<div class="form-group col-md-12 {{$errors->branch->first('name')?'has-error':''}}">
					{{Form::label('name', 'Nombre', ['class' => 'control-label  required'])}}
					{{Form::text('name', null, ['class' => 'form-control not-empty', 'data-name' => 'Nombre'])}}
					{{@$errors->branch->first('name')}}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-12 {{$errors->branch->first('address')?'has-error':''}}">
					{{Form::label('address', 'Dirección', ['class' => 'control-label  required'])}}
					{{Form::text('address', null, ['class' => 'form-control not-empty', 'data-name' => 'Dirección'])}}
					{{@$errors->branch->first('address')}}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-12 {{$errors->branch->first('user_id')?'has-error':''}}">
					{{Form::label('user_id', 'Responsable de franquicia', ['class' => 'control-label required'])}}
					{!!Form::select('user_id', $users, $branch->id?$branch->user_id:null, ['class' => 'select2 form-control not-empty', 'id' => 'user_id', 'name' => 'user_id', 'data-name' => 'Responsable de franquicia'] )!!}
					{{@$errors->branch->first('user_id')}}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-12 {{$errors->branch->first('user_id')?'has-error':''}}">
					{{Form::label('child_user_ids', 'Recepcionistas', ['class' => 'control-label'])}}
					{!!Form::select('child_user_ids', $child_users, $branch->id?$branch->users->pluck('id'):null, ['class' => 'select2 form-control', 'id' => 'child_user_ids', 'name' => 'child_user_ids[]', 'data-name' => 'Recepcionistas', 'multiple' => true] )!!}
					{{@$errors->branch->first('child_user_ids')}}
				</div>
			</div>
			<?php /*
			<div class="row">
				@if( $branch->photo )
					<div class="col-md-3">
						<img src="{{asset('img/branchs/'.$branch->id.'/'.$branch->photo)}}" alt="Foto noticia" class="show">
					</div>
				@endif
				<div class="form-group col-md-{{$branch->photo?'9':'12'}} {{$errors->branch->first('photo')?'has-error':''}}">
					{{Form::label('photo', 'Foto', ['class' => !$branch->id?'label-control required':'label-control'])}}
					{{Form::file('photo', ['class' =>!$branch->id?'form-control not-empty file image':'form-control file image', 'data-name' => 'Foto'])}}
				</div>
			</div>
			*/ ?>
			<div class="row text-left buttons-form">
				<a href="{{route('Branch')}}" class="btn btn-danger">Regresar</a>
				{{Form::submit('Guardar',['class' => 'btn btn-success guardar', 'data-target' => 'branchesForm'])}}
			</div>
		{{ Form::close() }}
	</div>
</div>
@endsection
