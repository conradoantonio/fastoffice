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
		<h1>{{$user->id ? 'Actualizar' : 'Crear'}} <span class="semi-bold">usuario de {{$type == 'sistema' ? 'sistema' : 'aplicación'}}</span></h1>
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
			@if(!$user->id)
			{{-- @if( $user->role_id != 2 && $user->role_id != 4) --}}
				<div class="row">
					<div class="form-group col-md-12 {{$errors->user->first('role_id')?'has-error':''}}">
						{{Form::label('role_id', 'Rol', ['class' => 'control-label  required'])}}
						{{Form::select('role_id', $roles, $user->id?$user->role_id:0,['class' => 'form-control not-empty', 'data-name' => "Rol"])}}
					</div>
				</div>
			@endif

			<div class="row rfc_field {{ ( old('role_id') != 2 && old('role_id') != 4 ) && ( $user->role_id != 2 && $user->role_id != 4) ? 'hide' :'' }}">
				<div class="form-group col-md-6 {{$errors->user->first('rfc')?'has-error':''}}">
					{{Form::label('rfc', 'RFC', ['class' => 'control-label required'])}}
					{{Form::text('rfc', null, ['class' => 'form-control', 'data-name' => 'RFC'])}}
					{{@$errors->user->first('rfc')}}
				</div>
			</div>

			<div class="row customer_fields {{ ( old('role_id') != 4 ) && ( $user->role_id != 4 ) ? 'hide' :'' }}">
				<div class="form-group col-md-6 {{$errors->user->first('business_activity')?'has-error':''}}">
					{{Form::label('business_activity', 'Giro empresarial', ['class' => 'control-label required'])}}
					{{Form::text('business_activity', null, ['class' => 'form-control', 'data-name' => 'Giro empresarial'])}}
					{{@$errors->user->first('business_activity')}}
				</div>
				<div class="form-group col-md-12 {{$errors->user->first('address')?'has-error':''}}">
					{{Form::label('address', 'Dirección', ['class' => 'control-label required'])}}
					{{Form::text('address', null, ['class' => 'form-control', 'data-name' => 'Dirección'])}}
					{{@$errors->user->first('address')}}
				</div>
				<div class="form-group col-md-6 {{$errors->user->first('identification_type')?'has-error':''}}">
					{{Form::label('identification_type', 'Tipo de identificación', ['class' => 'control-label required'])}}
					{{Form::text('identification_type', null, ['class' => 'form-control', 'data-name' => 'Tipo de identificación'])}}
					{{@$errors->user->first('identification_type')}}
				</div>
				<div class="form-group col-md-6 {{$errors->user->first('identification_num')?'has-error':''}}">
					{{Form::label('identification_num', 'Número de identificación', ['class' => 'control-label required'])}}
					{{Form::text('identification_num', null, ['class' => 'form-control', 'data-name' => 'Número de identificación'])}}
					{{@$errors->user->first('identification_num')}}
				</div>
			</div>
			<div class="row buttons-form">
				<a href="{{route($type == 'sistema' ? 'User.index1' : 'User.index2')}}" class="btn btn-danger">Regresar</a>
				{{Form::submit('Guardar',['class' => 'btn btn-success guardar', 'data-target' => 'UserForm'])}}
			</div>
		{{ Form::close() }}
	</div>
</div>
@push('scripts')
	<script type="text/javascript">
		$("#role_id").on('change', function(){
			//If user to create is a franchise, show rfc field
			if ( $(this).val() == 2 || $(this).val() == 4 ) {
				$(".rfc_field").removeClass('hide').find('input').addClass('not-empty rfc');
			} else {
				$(".rfc_field").addClass('hide').find('input').removeClass('not-empty rfc').val("");
			}

			//If user to create is a customer, show rfc field
			if ( $(this).val() == 4 ) {
				$(".customer_fields").removeClass('hide').find('input').addClass('not-empty');
			} else {
				$(".customer_fields").addClass('hide').find('input').removeClass('not-empty').val("");
			}
		})
	</script>
@endpush
@endsection
