@extends('layouts.main')
@section('pageTitle', 'Oficinas')
@section('content')
@include('branches.modal', ['import_url' => route('Office.excel')])
<div class="container-fluid content-body">
	@if(session('msg'))
	<div class="alert alert-success">
		{{session('msg')}}
	</div>
	@endif
	<div class="page-title">
		<h1>Listado <span class="semi-bold">Oficinas</span></h1>
	</div>
	@if( auth()->user()->role_id == 1 )
	<div class="row-fluid">
		@include('helpers.filters', ['index_url' => route('Office'), 'export_url' => null, 'dates' => false])
	</div>
	@endif
	<div class="row-fluid text-left buttons-container">
		<a href="{{route('Office.form')}}" class="btn btn-success add"><i class="glyphicon glyphicon-plus"></i> Nueva oficina</a>
		<a href="{{route('Office.multipleDestroys')}}" class="btn btn-danger multiple-delete-btn disabled" disabled><i class="glyphicon glyphicon-trash"></i> Eliminar múltiple</a>
		<button class="btn btn-info" data-toggle="modal" data-target="#ModalExcel"><i class="glyphicon glyphicon-cloud-upload"></i> Importar oficinas</button>
	</div>
	<div class="row-fluid">
		<div id="body-content">
			@include('offices.table')
		</div>
	</div>
</div>
@push('scripts')
<script type="text/javascript">
	$(function(){
		Dropzone.autoDiscover = false;

		var myDropzone = new Dropzone("div#dropzoneDiv", {
			url: "{{url('')}}",
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
							url: "{{route('Office.destroyImage')}}",
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

	    $(document).delegate(".uploadImages", 'click', function(){
	    	myDropzone.removeAllFiles(true)
			myDropzone.options.url = $(this).data('url2')
			var url = $(this).data('url1')
			$.ajax({
				url: url,
				method:'GET',
				success: function(response){
					console.log(response)
					$.each(response, function(key, value){
						var mockFile = { name: value.path, size: value.size};
						myDropzone.options.addedfile.call(myDropzone, mockFile);
						myDropzone.options.thumbnail.call(myDropzone, mockFile, value.path);
					})
				}
			})
		})
	})
</script>
@endpush
@endsection
