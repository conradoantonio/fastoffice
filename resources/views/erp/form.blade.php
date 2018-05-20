@extends('layouts.main')
@section('pageTitle', 'Erp')
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
				<div class="form-group col-md-6 {{$errors->meeting->first('type')?'has-error':''}}">
					{{Form::label('type', 'Tipo', ['class' => 'control-label required'])}}
					{!!Form::select('type', [0 => 'Seleccione tipo', 1 => 'Ingreso', 2 => 'Egreso'], null, ['class' => 'form-control not-empty', 'id' => 'type', 'name' => 'type', 'data-name' => 'Tipo'] )!!}
					{{@$errors->meeting->first('type')}}
				</div>
				<div class="form-group col-md-6 {{$errors->meeting->first('category_id')?'has-error':''}}">
					{{Form::label('category_id', 'Categoría', ['class' => 'control-label required'])}}
					{!!Form::select('category_id', $categories, null, ['class' => 'select2 form-control not-empty', 'id' => 'category_id', 'name' => 'category_id', 'data-name' => 'Categoría'] )!!}
					{{@$errors->meeting->first('category_id')}}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-12 {{$errors->meeting->first('concept')?'has-error':''}}">
					{{Form::label('concept', 'Concepto', ['class' => 'control-label'])}}
					{{Form::text('concept', null, ['class' => 'form-control', 'data-name' => 'Concepto'])}}
					{{@$errors->meeting->first('concept')}}
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
@push('scripts')
	<script type="text/javascript">
		$('#type').on('change', function(){
			elem_to_block = $('select#category_id').parent('div').children('div.select2-container');
			$("#category_id").select2("val", 0);
			if ( $(this).val() != 0 ){
				$.ajax({
					url: "{{route('Erp.categories')}}/"+$(this).val(),
					method: 'POST',
					beforeSend:function(){
						blockUI(elem_to_block);
					},
					success:function(response){
						$("#category_id option:gt(0)").remove();
						$.each(response,function(i,e){
							$("#category_id").append("<option value='"+e.id+"'>"+e.name+"</option>");
						})
						unblockUI(elem_to_block);
					}
				})
			} else {
				$("#category_id option:gt(0)").remove();
			}
		})
	</script>
@endpush
@endsection
