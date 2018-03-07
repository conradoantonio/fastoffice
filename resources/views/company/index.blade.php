@extends('layouts.main')
@section('pageTitle', 'Empresa')
@section('content')
<div class="container-fluid content-body">
	@if(session('msg'))
	<div class="alert alert-success">
		{{session('msg')}}
	</div>
	@endif
	<div class="page-title">
		<h1><span class="semi-bold">Empresa</span></h1>
	</div>
	<div class="row-fluid">
		<div id="body-content">
			{{ Form::model($company, ['url' => route('Company.update', $company->id), 'class' => 'form valid', 'id' => 'newsForm' ,'autocomplete' => 'off', 'files' => true]) }}
				@if($company->id)
				{{ method_field('PUT') }}
				@endif
				<div class="row">
					<div class="form-group col-md-12">
						{{Form::label('name', 'Nombre', ['class' => 'control-label  required'])}}
						{{Form::text('name', null, ['class' => 'form-control not-empty', 'data-name' => 'Título'])}}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-12">
						{{Form::label('description', 'Descrpción', ['class' => 'control-label  required'])}}
						{{Form::textarea('description', null, ['class' => 'form-control not-empty', 'data-name' => 'Descripción'])}}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-12">
						{{Form::label('philosophy', 'Filosofía de la empresa', ['class' => 'control-label  required'])}}
						{{Form::textarea('philosophy', null, ['class' => 'form-control not-empty', 'data-name' => 'Filosofía de la empresa'])}}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-12">
						{{Form::label('terms_conditions', 'Terminos y condiciones', ['class' => 'control-label  required'])}}
						{{Form::textarea('terms_conditions', null, ['class' => 'form-control not-empty', 'data-name' => 'Terminos y condiciones'])}}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-12">
						{{Form::label('privacy', 'Aviso de privacidad', ['class' => 'control-label  required'])}}
						{{Form::textarea('privacy', null, ['class' => 'form-control not-empty', 'data-name' => 'Aviso de privacidad'])}}
					</div>
				</div>
				<div class="row">
					@if( $company->picture )
						<div class="col-md-3">
							<img src="{{asset('img/company/'.$company->picture)}}" alt="Foto empresa" class="show">
						</div>
					@endif
					<div class="form-group col-md-{{$company->picture?'9':'12'}}">
						{{Form::label('picture', 'Fotografía', ['class' => !$company->picture?'label-control required':'label-control'])}}
						{{Form::file('picture', ['class' =>!$company->picture?'form-control not-empty file image':'form-control file image', 'data-name' => 'Fotografía'])}}
					</div>
				</div>
				<div class="row text-left buttons-form">
					{{Form::submit('Guardar',['class' => 'btn btn-success guardar', 'data-target' => 'newsForm'])}}
				</div>
			{{ Form::close() }}
		</div>
	</div>
</div>
@endsection
