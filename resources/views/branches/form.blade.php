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
			<div class="row">
				<div class="form-group col-md-6 {{$errors->branch->first('zip_code')?'has-error':''}}">
					{{Form::label('zip_code', 'Código postal', ['class' => 'control-label required'])}}
					{{Form::text('zip_code', null, ['class' => 'form-control not-empty decimals', 'data-name' => 'Código postal'])}}
					{{@$errors->branch->first('zip_code')}}
				</div>
				<div class="form-group col-md-6 {{$errors->branch->first('locality')?'has-error':''}}">
					{{Form::label('locality', 'Localidad', ['class' => 'control-label required'])}}
					{{Form::text('locality', null, ['class' => 'form-control not-empty', 'data-name' => 'Localidad'])}}
					{{@$errors->branch->first('locality')}}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-6 {{$errors->branch->first('phone')?'has-error':''}}">
					{{Form::label('phone', 'Teléfono', ['class' => 'control-label required'])}}
					{{Form::text('phone', null, ['class' => 'form-control not-empty decimals length', 'data-name' => 'Teléfono', 'data-max' => 10])}}
					{{@$errors->branch->first('phone')}}
				</div>
				<div class="form-group col-md-6 {{$errors->branch->first('website')?'has-error':''}}">
					{{Form::label('website', 'Sitio web', ['class' => 'control-label required'])}}
					{{Form::text('website', null, ['class' => 'form-control not-empty', 'data-name' => 'Sitio web'])}}
					{{@$errors->branch->first('website')}}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-12 {{$errors->branch->first('description')?'has-error':''}}">
					{{Form::label('description', 'Descripción', ['class' => 'control-label  required'])}}
					{{Form::textarea('description', null, ['class' => 'form-control not-empty', 'data-name' => 'Descripción'])}}
				</div>
			</div>
			@if( $branch->id )
			<div class="row">
				<div class="row-fluid dropzone" id="dropzoneDiv">
				</div>
			</div>
			@endif
			<div class="row text-left buttons-form">
				<a href="{{route('Branch')}}" class="btn btn-danger">Regresar</a>
				{{Form::submit('Guardar',['class' => 'btn btn-success guardar', 'data-target' => 'branchesForm'])}}
			</div>
		{{ Form::close() }}
	</div>
</div>
@push('scripts')
<script type="text/javascript">
	var data = "";
	if ( "{{$branch->id}}" ){
		data = "{{$branch->pictures}}"
		data = JSON.parse(data.replace(/&quot;/g,'"'));
	}

	if ( data ){
		$('div.dz-default.dz-message').remove()
	}
	Dropzone.autoDiscover = false;

	$(function(){
	    var myDropzone = new Dropzone("div#dropzoneDiv", {
			url: "{{route('Branch.update', $branch->id)}}",
			addRemoveLinks: true,
			paramName: 'photo',
			init: function() {
				this.on("sending", function(file, xhr, formData){
					formData.append("_method", "PUT");
				});
			},
			removedfile: function(file) {
				swal({
					title: '¿Quieres eliminar este archivo adjunto?',
					icon: "warning",
					buttons: ["Cancelar", "Eliminar"],
					dangerMode: true,
				}).then((accept) => {
					if (accept) {
						$.ajax({
							url: "{{route('Branch.destroyImage')}}",
							method:'delete',
							type:'delete',
							data:{
								path: file.name
							},
							success:function(response){
								file.previewElement.remove();
								if ( response.status ){
									swal('Éxito', response.msg, 'success');
								} else {
									swal('Error', response.msg, 'warning');
								}
							}
						})
					}
				})
			}
		});
		if ( data ){
	    	$.each(data, function(key, value){
				var mockFile = { name: value.path, size: value.size};
				myDropzone.options.addedfile.call(myDropzone, mockFile);
				myDropzone.options.thumbnail.call(myDropzone, mockFile, value.path);
			})
		}
	})
</script>
@endpush
@endsection
