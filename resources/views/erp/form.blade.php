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
		<h1>{{$erp->id ? 'Actualizar' : 'Crear'}} <span class="semi-bold">ingreso/egreso</span></h1>
	</div>
	<div class="row-fluid">
	{{ Form::model($erp, ['route' => !$erp->id?'Erp.store':['Erp.update', $erp->id], 'class' => 'form valid', 'id' => 'erpForm' ,'autocomplete' => 'off']) }}
			@if($erp->id)
			{{ method_field('PUT') }}
			@endif
			<div class="row">
				<div class="form-group col-md-6 {{$errors->meeting->first('concept')?'has-error':''}}">
					{{Form::label('concept', 'Concepto', ['class' => 'control-label  required'])}}
					{{Form::text('concept', null, ['class' => 'form-control not-empty', 'data-name' => 'Concepto'])}}
					{{@$errors->meeting->first('concept')}}
				</div>
				<div class="form-group col-md-6 {{$errors->meeting->first('type')?'has-error':''}}">
					{{Form::label('type', 'Tipo', ['class' => 'control-label required'])}}
					{!!Form::select('type', [0 => 'Seleccione tipo', 1 => 'Ingreso', 2 => 'Egreso'], null, ['class' => 'form-control not-empty', 'id' => 'type', 'name' => 'type', 'data-name' => 'Tipo'] )!!}
					{{@$errors->meeting->first('type')}}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-12 {{$errors->meeting->first('amount')?'has-error':''}}">
					{{Form::label('amount', 'Cantidad', ['class' => 'control-label  required'])}}
					{{Form::text('amount', null, ['class' => 'form-control not-empty decimals', 'data-name' => 'Cantidad'])}}
					{{@$errors->meeting->first('amount')}}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-12 {{$errors->meeting->first('office_id')?'has-error':''}}">
					{{Form::label('office_id', 'Oficina', ['class' => 'control-label required'])}}
					{!!Form::select('office_id', $offices, null, ['class' => 'select2 form-control not-empty', 'id' => 'office_id', 'name' => 'office_id', 'data-name' => 'Oficina'] )!!}
					{{@$errors->meeting->first('office_id')}}
				</div>
			</div>
			<div class="row text-left buttons-form">
				<a href="{{route('Erp')}}" class="btn btn-danger">Regresar</a>
				{{Form::submit('Guardar',['class' => 'btn btn-success guardar', 'data-target' => 'erpForm'])}}
			</div>
		{{ Form::close() }}
	</div>
</div>
@endsection
