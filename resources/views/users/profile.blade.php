@extends('layouts.main')
@section('pageTitle', 'Usuarios')
@section('content')
<link href="{{asset('plugins/bootstrap-datepicker/css/datepicker.css')}}" rel="stylesheet" type="text/css" />
<div class="container-fluid content-body">
	<div class="page-title">
		<h1>{{$user->id ? 'Actualizar' : 'Crear'}} <span class="semi-bold">Mi perfil</span></h1>
	</div>
	<div class="row-fluid">
		@if(session('msg'))
		<div class="alert alert-success">
			{{session('msg')}}
		</div>
		@endif
		{{ Form::model($user, ['url' => !$user->id?route('Users.store'):route('Users.update-profile',$user->id), 'class' => 'form valid', 'id' => 'UserForm' ,'autocomplete' => 'off', 'files' => true]) }}
			@if($user->id)
			{{ method_field('PUT') }}
			@endif
			<div class="row">
				<div class="form-group col-md-4 text-center">
					<img src="{{!$user->photo?asset('/img/profiles/avatar.jpg'):asset('/img/profiles/'.$user->id.'/'.$user->photo)}}" alt="..." class="img-circle" width="35%" id="foto_perfil">
				</div>
				<div class="form-group col-md-8">
					{{Form::label('photo', 'Foto de perfil', ['class' => !$user->photo?'label-control required':'label-control'])}}
					{{Form::hidden('base64', null, ['class' => 'form-control'])}}
					{{Form::file('photo', ['class' =>!$user->photo?'form-control not-empty':'form-control', 'data-name' => 'Foto'])}}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-4 {{$errors->user->first('name')?'has-error':''}}">
					{{Form::label('name', 'Nombre', ['class' => 'control-label required'])}}
					{{Form::text('name', null, ['class' => 'form-control not-empty', 'data-name' => 'Nombre'])}}
				</div>
				<div class="form-group col-md-4 {{$errors->user->first('lastname')?'has-error':''}}">
					{{Form::label('lastname', 'Apellido', ['class' => 'control-label required'])}}
					{{Form::text('lastname', null, ['class' => 'form-control not-empty', 'data-name' => 'Apellido'])}}
				</div>
				<div class="form-group col-md-4">
					{{Form::label('birthday', 'Nacimiento', ['class' => 'control-label required'])}}

					<div class="input-append success date col-md-11 no-padding">
						{{Form::text('birthday', null, ['class' => 'form-control not-empty numeric', 'maxlength' => 2, 'data-name' => 'Fecha de nacimiento'])}}
					    <span class="add-on"><span class="arrow"></span><i class="fa fa-th"></i></span>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-6 {{$errors->user->first('email')?'has-error':''}}">
					{{Form::label('email', 'Correo electrónico', ['class' => 'control-label required'])}}
					{{Form::email('email', null,['class' => 'form-control not-empty email', 'data-name' => "Email"])}}
					{{@$errors->user->first('email')}}
				</div>
				<div class="form-group col-md-6 {{$errors->user->first('password')?'has-error':''}}">
					@php
						$req = $user->id?'':'required';
					@endphp
					{{Form::label('password', 'Contraseña', ["class" => "control-label ".$req])}}
					{{Form::password('password', ['class' => !$user->id?'form-control not-empty':'form-control', 'data-name' => "Contraseña"])}}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-12">
					{{Form::label('address', 'Dirección', ['class' => 'control-label required'])}}
					{{Form::text('address', null, ['class' => 'form-control not-empty', 'data-name' => 'Dirección'])}}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-12">
					{{Form::label('phone', 'Teléfono', ['class' => 'control-label required'])}}
					{{Form::text('phone', null, ['class' => 'form-control not-empty numeric', 'maxlength' => 10, 'data-name' => 'Teléfono'])}}
				</div>
			</div>
			<div class="row">
				<h3 class="text-center">Cuenta bancaria</h3>
				<div class="form-group col-md-4">
					{{Form::label('bank_id', 'Banco', ['class' => 'control-label required'])}}
					{!!Form::select('bank_id', $banks, @$user->bankAccount->bank_id?$user->bankAccount->bank_id:0, ['class' => 'select2 form-control not-empty', 'data-name' => 'Banco'] )!!}
				</div>
				<div class="form-group col-md-4">
					{{Form::label('clabe', 'Clabe', ['class' => 'control-label required with-counter'])}}
					<span class="display-counter"><span class="counter">0</span>/18</span>
					{{Form::text('clabe', @$user->bankAccount->clabe?$user->bankAccount->clabe:null,['class' => 'form-control not-empty numeric length', 'data-name' => "Clabe", 'data-equal' => 18])}}
				</div>
				<div class="form-group col-md-4">
					{{Form::label('account_number', 'Número de cuenta', ['class' => 'control-label required with-counter'])}}
					<span class="display-counter"><span class="counter">0</span>/10</span>
					{{Form::text('account_number', @$user->bankAccount->account_number?$user->bankAccount->account_number:null,['class' => 'form-control not-empty numeric length', 'data-name' => "Número de cuenta", 'data-equal' => 10])}}
				</div>
			</div>
			<div class="row buttons-form">
				{{Form::submit('Guardar',['class' => 'btn btn-success guardar', 'data-target' => 'UserForm'])}}
			</div>
		{{ Form::close() }}
	</div>
</div>
<script>
	$(function(){
		$('.input-append.date').datepicker({
			autoclose: true,
			todayHighlight: true,
			format: "yyyy-mm-dd",
		})
	})

	function readURL(input) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();

	        reader.onload = function (e) {
	            $('.cr-image').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}

	$('#photo').change(function(){
		/*readURL(this)*/
		$('#foto_perfil').croppie('destroy');
		var img = this;

		$('#foto_perfil').croppie({
			url: readURL(img),
			mouseWheelZoom: false,
			viewport: {
				width: 200,
				height: 200,
			},
			boundary: {
				width: 300,
				height: 300
			},
			update: function (data) {
				$('#foto_perfil').croppie('result', {
					type : 'base64',
					quality: '0.9',
					size: {
						width: 640,
						height: 605
					},
					}).then(function(res) {
					//console.log(res)
					res = res.replace(/^data\:image\/\w+\;base64\,/, '');
					console.log(res);
					$('input[name=base64]').val(res);
				});
			}
		});
	})
</script>
@endsection
