@extends('layouts.main')
@section('pageTitle', 'Usuarios')
@section('content')
@include('users.modal')
<div class="container-fluid content-body">
	@if(session('msg'))
	<div class="alert {{session('class')}}">
		{{session('msg')}}
	</div>
	@endif
	<div class="page-title">
		<h1>Listado <span class="semi-bold">Usuarios ({{Route::currentRouteName() == 'User.index1' ? 'Sistema' : 'Aplicación'}})</span></h1>
	</div>
	<div class="row-fluid text-left buttons-container">
		@if(auth()->user()->role->name == 'Administrador')
			<a href="{{route('User.form', ['type' => Route::currentRouteName() == 'User.index1' ? 'sistema' : 'app'])}}" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Nuevo usuario de {{Route::currentRouteName() == 'User.index1' ? 'Sistema' : 'Aplicación'}}</a>
		@endif
		<button class="btn btn-info" data-target="#send-template" data-toggle="modal"><i class="fa fa-paper-plane"></i> Enviar plantilla</button>
	</div>
	<div class="row-fluid">
		<div id="body-content">
			@include('users.table')
		</div>
	</div>
</div>
@push('scripts')
<script type="text/javascript">
	$(document).delegate("#send_templates", 'click',  function(){
		var template_id = $("#template_id").val(), users_ids = [];

        $('.multiple-delete:checked').each(function(){
            users_ids.push($(this).val());
        })

        if ( template_id == 0 || users_ids.length === 0 ){
            if ( users_ids.length === 0 ){
                swal('Error', 'No ha seleccionado ningun rospecto como destinatario de la plantilla', 'error')
            } else {
                swal({
                    title: 'Verifique los siguientes campos: ',
                    icon: 'error',
                    content: {
                        element: "div",
                        attributes: {
                            innerHTML:"<ul id='errores_list'><li>Plantilla: Campo vacio</li></ul>"
                        },
                    }
                }).catch(swal.noop);
                $("#template_id").parent().addClass('has-error')
            }
            return;
        }
        $("#template_id").parent().removeClass('has-error')

        config = {
            'template_id'   : template_id,
            'users_ids'     : users_ids,
            'keepModal'     : false,
            'route'         : $("#send-template-form-users").attr('action'),
            'method'        : 'POST',
            'callback'      : '',
        }
        loadAnimation('Procesando');
        ajaxSimple(config);
        $("#template_id").select2('val',0)
    })
</script>
@endpush
@endsection
