@extends('layouts.main')
@section('pageTitle', 'Usuarios')
@section('content')
<div class="container-fluid content-body">
	@if(session('msg'))
	<div class="alert alert-danger">
		{{session('msg')}}
	</div>
	@endif
	<div class="page-title">
		<h1>{{$user->id ? 'Actualizar' : 'Crear'}} <span class="semi-bold">usuario de sistema</span></h1>
	</div>
	<div class="row-fluid">
		{{ Form::model($user, ['route' => !$user->id?'User.store':['User.update',$user->id], 'class' => 'form valid', 'id' => 'UserForm' ,'autocomplete' => 'off']) }}
			@if($user->id)
			{{ method_field('PUT') }}
			@endif
			<div class="row">
				<div class="form-group col-md-12 {{$errors->user->first('fullname')?'has-error':''}}">
					{{Form::label('fullname', 'Nombre', ['class' => 'control-label required'])}}
					{{Form::text('fullname', null, ['class' => 'form-control not-empty', 'data-name' => 'Nombre'])}}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-12 {{$errors->user->first('phone')?'has-error':''}}">
					{{Form::label('phone', 'Teléfono', ['class' => 'control-label required'])}}
					{{Form::text('phone', null, ['class' => 'form-control not-empty numeric', 'data-name' => 'Teléfono'])}}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-6 {{$errors->user->first('email')?'has-error':''}}">
					{{Form::label('email', 'Correo electrónico', ['class' => 'control-label  required'])}}
					{{Form::email('email', null,['class' => 'form-control not-empty email', 'data-name' => "Email", 'readonly' => $user->id?true:false])}}
					{{@$errors->user->first('email')}}
				</div>
				<div class="form-group col-md-6 {{$errors->user->first('password')?'has-error':''}}">
					@php
						$req = $user->id?'':'required';
					@endphp
					{{Form::label('password', 'Contraseña', ["class" => "control-label ".$req])}}
					{{Form::password('password', ['class' => !$user->id?'form-control not-empty length':'form-control length', 'data-name' => "Contraseña", 'data-min' => '8'])}}
					{{@$errors->user->first('password')}}
				</div>
			</div>
			@if( $user->role_id != 2 )
				<div class="row">
					<div class="form-group col-md-12 {{$errors->user->first('role_id')?'has-error':''}}">
						{{Form::label('role_id', 'Rol', ['class' => 'control-label  required'])}}
						{{Form::select('role_id', $roles, $user->id?$user->role_id:0,['class' => 'form-control not-empty', 'data-name' => "Rol"])}}
					</div>
				</div>
			@endif
			<div class="row extra_fran {{ (!$errors->user->first('regime')&&!$errors->user->first('rfc')) && $user->role_id != 2?'hide':''}}">
				<div class="form-group col-md-6 {{$errors->user->first('regime')?'has-error':''}}">
					{{Form::label('regime', 'Régimen', ['class' => 'control-label required'])}}
					{{Form::select('regime', [0 => 'Seleccione un régimen', "Persona física" => 'Persona física', "Persona moral" => 'Persona moral'], null,['class' => 'form-control', 'data-name' => "Regimen"])}}
				</div>
				<div class="form-group col-md-6 {{$errors->user->first('rfc')?'has-error':''}}">
					{{Form::label('rfc', 'RFC', ['class' => 'control-label required'])}}
					{{Form::text('rfc', null, ['class' => 'form-control', 'data-name' => 'RFC'])}}
					{{@$errors->user->first('rfc')}}
				</div>
			</div>
			<div class="row buttons-form">
				<a href="{{route('User.index1')}}" class="btn btn-danger">Regresar</a>
				{{Form::submit('Guardar',['class' => 'btn btn-success guardar', 'data-target' => 'UserForm'])}}
			</div>
		{{ Form::close() }}
	</div>
</div>
@push('scripts')
	<script type="text/javascript">
		$("#role_id").on('change', function(){
			if ( $(this).val() == 2 ){
				$(".extra_fran").removeClass('hide').find('input').addClass('not-empty rfc')
				$(".extra_fran").find('select').addClass('not-empty')
			} else {
				$(".extra_fran").addClass('hide').find('input').removeClass('not-empty rfc')
				$(".extra_fran").find('select').removeClass('not-empty')
			}
		})
	</script>
@endpush
@endsection
