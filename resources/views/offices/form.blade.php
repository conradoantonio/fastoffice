@extends('layouts.main')
@section('pageTitle', 'Oficina')
@section('content')
<div class="container-fluid content-body">
	@if(session('msg'))
	<div class="alert alert-danger">
		{{session('msg')}}
	</div>
	@endif
	<div class="page-title">
		<h1>{{$office->id ? 'Actualizar' : 'Crear'}} <span class="semi-bold">Oficina</span></h1>
	</div>
	<div class="row-fluid">
	{{ Form::model($office, ['route' => !$office->id?'Office.store':['Office.update', $office->id], 'class' => 'form valid', 'id' => 'officesForm' ,'autocomplete' => 'off', 'files' => true]) }}
			@if($office->id)
			{{ method_field('PUT') }}
			@endif
			<div class="row">
				<div class="form-group col-md-12 {{$errors->office->first('name')?'has-error':''}}">
					{{Form::label('name', 'Nombre', ['class' => 'control-label  required'])}}
					{{Form::text('name', null, ['class' => 'form-control not-empty', 'data-name' => 'Nombre'])}}
					{{@$errors->office->first('name')}}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-12 {{$errors->office->first('address')?'has-error':''}}">
					{{Form::label('address', 'Dirección', ['class' => 'control-label  required'])}}
					{{Form::text('address', null, ['class' => 'form-control not-empty', 'data-name' => 'Dirección'])}}
					{{@$errors->office->first('address')}}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-12 {{$errors->office->first('office_type_id')?'has-error':''}}">
					{{Form::label('office_type_id', 'Tipo de oficina', ['class' => 'control-label required'])}}
					{!!Form::select('office_type_id', $types, null, ['class' => 'select2 form-control not-empty', 'id' => 'office_type_id', 'name' => 'office_type_id', 'data-name' => 'Tipo de oficina'] )!!}
					{{@$errors->office->first('office_type_id')}}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-6 {{$errors->office->first('price')?'has-error':''}}">
					{{Form::label('price', 'Precio', ['class' => 'control-label required'])}}
					{{Form::text('price', null, ['class' => 'form-control not-empty decimals', 'data-name' => 'Precio'])}}
					{{@$errors->office->first('price')}}
				</div>
				<div class="form-group col-md-6 {{$errors->office->first('num_people')?'has-error':''}}">
					{{Form::label('num_people', 'Número de personas', ['class' => 'control-label required'])}}
					{{Form::text('num_people', null, ['class' => 'form-control not-empty', 'data-name' => 'Número de personas'])}}
					{{@$errors->office->first('num_people')}}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-6 {{$errors->office->first('branch_id')?'has-error':''}}">
					{{Form::label('branch_id', 'Sucursal (Franquicia)', ['class' => 'control-label required'])}}
					{!!Form::select('branch_id', $offices, $office->id?$office->branch_id:null, ['class' => 'select2 form-control not-empty', 'id' => 'branch_id', 'name' => 'branch_id', 'data-name' => 'Sucursal (Franquicia)'] )!!}
					{{@$errors->office->first('branch_id')}}
				</div>
				<div class="form-group col-md-6 {{$errors->office->first('user_id')?'has-error':''}}">
					{{Form::label('user_id', 'Recepcionista', ['class' => 'control-label'])}}
					{!!Form::select('user_id', $users, $office->id?$office->user_id:null, ['class' => 'select2 form-control', 'id' => 'user_id', 'name' => 'user_id', 'data-name' => 'Recepcionista'] )!!}
					{{@$errors->office->first('user_id')}}
				</div>
			</div>
			<div class="row">
				@if( $office->photo )
					<div class="col-md-3">
						<img src="{{asset('img/offices/'.$office->id.'/'.$office->photo)}}" alt="Foto noticia" class="show">
					</div>
				@endif
				<div class="form-group col-md-{{$office->photo?'9':'12'}} {{$errors->office->first('photo')?'has-error':''}}">
					{{Form::label('photo', 'Foto', ['class' => !$office->id?'label-control required':'label-control'])}}
					{{Form::file('photo', ['class' =>!$office->id?'form-control not-empty file image':'form-control file image', 'data-name' => 'Foto'])}}
				</div>
			</div>
			<div class="row text-left buttons-form">
				<a href="{{route('Office')}}" class="btn btn-danger">Regresar</a>
				{{Form::submit('Guardar',['class' => 'btn btn-success guardar', 'data-target' => 'officesForm'])}}
			</div>
		{{ Form::close() }}
	</div>
</div>
@push('scripts')
	<script type="text/javascript">
		$('#branch_id').on('change', function(){
			elem_to_block = $('select#user_id').parent('div').children('div.select2-container');
			$("#user_id").select2("val", 0);
			if ( $(this).val() != 0 ){
				$.ajax({
					url: "{{route('Office.users')}}/"+$(this).val(),
					method: 'POST',
					beforeSend:function(){
						blockUI(elem_to_block);
					},
					success:function(response){
						$("#user_id option:gt(0)").remove();
						$.each(response,function(i,e){
							$("#user_id").append("<option value='"+e.id+"'>"+e.fullname+"</option>");
						})
						unblockUI(elem_to_block);
					}
				})
			} else {
				$("#user_id option:gt(0)").remove();
			}
		})
	</script>
@endpush
@endsection
