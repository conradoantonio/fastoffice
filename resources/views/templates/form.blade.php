@extends('layouts.main')
@section('pageTitle', 'Plantillas')
@section('content')
<div class="container-fluid content-body">
	@if(session('msg'))
	<div class="alert alert-danger">
		{{session('msg')}}
	</div>
	@endif
	<div class="page-title">
		<h1>{{$template->id ? 'Actualizar' : 'Crear'}} <span class="semi-bold">Plantilla</span></h1>
	</div>
	<div class="row-fluid">
	{{ Form::model($template, ['route' => !$template->id?['Template.store']:['Template.update', $template->id], 'class' => 'form valid', 'id' => 'templatesForm' ,'autocomplete' => 'off']) }}
			@if($template->id)
			{{ method_field('PUT') }}
			@endif
			<div class="row">
				<div class="form-group col-md-12">
					{{Form::label('name', 'Nombre', ['class' => 'control-label  required'])}}
					{{Form::text('name', null, ['class' => 'form-control not-empty', 'data-name' => 'Nombre'])}}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-12">
					{{Form::label('content', 'Contenido', ['class' => !$template->id?'label-control required':'label-control'])}}
					{{Form::textarea ('content', null, ['class' => 'form-control not-empty', 'data-name' => 'Contenido'])}}
				</div>
			</div>

			<div class="row buttons-form">
				<a href="{{route('Template')}}" class="btn btn-danger">Regresar</a>
				{{Form::submit('Guardar',['class' => 'btn btn-success guardar', 'data-target' => 'templatesForm'])}}
			</div>
		{{ Form::close() }}
		@if( $template->id )
			<div class="row-fluid" id="dropzoneDiv">
				<form action="{{route('Template.update', $template->id)}}" class="dropzone">
					{{ method_field('PUT') }}
					{{ csrf_field() }}
				</form>
			</div>
		@endif
	</div>
</div>
@push('scripts')
<script type="text/javascript">
	var data = "";
	if ( "{{$template->id}}" ){
		data = "{{$template->attachments}}"
		data = JSON.parse(data.replace(/&quot;/g,'"'));
	}

	if ( data ){
		$('div.dz-default.dz-message').remove()
	}

	$(function(){
	    var myDropzone = new Dropzone(".dropzone", {
	    	url: "{{route('Template.update', $template->id)}}",
	    	addRemoveLinks: true,
	    	removedfile: function(file) {
	    		swal({
					title: '¿Quieres eliminar este archivo adjunto?',
					icon: "warning",
					buttons: ["Cancelar", "Eliminar"],
					dangerMode: true,
				}).then((accept) => {
					if (accept) {
						$.ajax({
							url: "{{route('Attachment.delete')}}",
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
			},
			complete: function(file){
				if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {

				}
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
