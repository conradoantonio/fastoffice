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
	{{ Form::model($erp, ['route' => !$erp->id?'Erp.store':['Erp.update', $erp->id], 'class' => 'form valid', 'id' => 'erpForm' ,'autocomplete' => 'off', 'files' => true]) }}
			@if($erp->id)
			{{ method_field('PUT') }}
			@endif
			<div class="row">
				<div class="form-group col-md-6 {{$errors->erp->first('type')?'has-error':''}}">
					{{Form::label('type', 'Tipo', ['class' => 'control-label required'])}}
					{!!Form::select('type', [0 => 'Seleccione tipo', 1 => 'Ingreso', 2 => 'Egreso'], null, ['class' => 'form-control not-empty', 'id' => 'type', 'name' => 'type', 'data-name' => 'Tipo'] )!!}
					{{@$errors->erp->first('type')}}
				</div>
				<div class="form-group col-md-6 {{$errors->erp->first('category_id')?'has-error':''}}">
					{{Form::label('category_id', 'Categoría', ['class' => 'control-label required'])}}
					{!!Form::select('category_id',  session('categories')?session('categories'):$categories, null, ['class' => 'select2 form-control not-empty', 'id' => 'category_id', 'name' => 'category_id', 'data-name' => 'Categoría'] )!!}
					{{@$errors->erp->first('category_id')}}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-12 {{$errors->erp->first('concept')?'has-error':''}}">
					{{Form::label('concept', 'Concepto', ['class' => 'control-label'])}}
					{{Form::text('concept', null, ['class' => 'form-control', 'data-name' => 'Concepto'])}}
					{{@$errors->erp->first('concept')}}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-6 {{$errors->erp->first('amount')?'has-error':''}}">
					{{Form::label('amount', 'Cantidad (coloca la cantidad con decimales o coloca la cantidad sin puntos)', ['class' => 'control-label  required'])}}
					{{Form::text('amount', null, ['class' => 'form-control not-empty decimals', 'data-name' => 'Cantidad'])}}
					{{@$errors->erp->first('amount')}}
				</div>
				<div class="form-group col-md-6 {{$errors->meeting->first('date')?'has-error':''}}">
					{{Form::label('date', 'Fecha del movimiento', ['class' => 'control-label required'])}}
					{{Form::text('date', null, ['class' => 'form-control not-empty input-date', 'data-name' => 'Fecha del movimiento'])}}
					{{@$errors->meeting->first('date')}}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-12 {{!$erp->office_id?'hide':''}} offices_row {{$errors->erp->first('office_id')?'has-error':''}}">
					{{Form::label('office_id', 'Oficina', ['class' => 'control-label required'])}}
					{!!Form::select('office_id', $offices, null, ['class' => $erp->office_id?'select2 form-control not-empty':'select2 form-control', 'id' => 'office_id', 'name' => 'office_id', 'data-name' => 'Oficina'] )!!}
					{{@$errors->erp->first('office_id')}}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-12 {{!$erp->branch_id?'hide':''}} branches_row {{$errors->erp->first('branch_id')?'has-error':''}}">
					{{Form::label('egress_type_id', 'Tipo egreso', ['class' => 'control-label required'])}}
					{!!Form::select('egress_type_id', $egress_types, null, ['class' => $erp->egress_type_id?'select2 form-control not-empty':'select2 form-control', 'id' => 'egress_type_id', 'name' => 'egress_type_id', 'data-name' => 'Tipo egreso'] )!!}
					{{@$errors->erp->first('egress_type_id')}}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-12 {{!$erp->branch_id?'hide':''}} branches_row {{$errors->erp->first('branch_id')?'has-error':''}}">
					{{Form::label('branch_id', 'Franquicia', ['class' => 'control-label required'])}}
					{!!Form::select('branch_id', $branches, null, ['class' => $erp->branch_id?'select2 form-control not-empty':'select2 form-control', 'id' => 'branch_id', 'name' => 'branch_id', 'data-name' => 'Franquicia'] )!!}
					{{@$errors->erp->first('branch_id')}}
				</div>
			</div>
			<div class="row">
				@if( $erp->file )
					<div class="col-md-2">
						<a href="{{asset($erp->file)}}" target="_blank">Ver comprobante</a>
					</div>
				@endif
				<div class="form-group col-md-{{$erp->file?'10':'12'}} {{$errors->erp->first('file')?'has-error':''}}">
					{{Form::label('file', 'Comprobante', ['class' => !$erp->id?'label-control required':'label-control'])}}
					{{Form::file('file', ['class' =>!$erp->id?'form-control not-empty file pdf excel image':'form-control file pdf excel image', 'data-name' => 'Foto'])}}
					{{@$errors->erp->first('file')}}
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

			if ( $(this).val() == 1 ){
				$('.offices_row').removeClass('hide').find('select').addClass('not-empty');
				$('.branches_row').addClass('hide').find('select').removeClass('not-empty');
			} else {
				$('.offices_row').addClass('hide').find('select').removeClass('not-empty');
				$('.branches_row').removeClass('hide').find('select').addClass('not-empty');
			}

		})
	</script>
@endpush
@endsection
