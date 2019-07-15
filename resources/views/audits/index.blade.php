@extends('layouts.main')
@section('pageTitle', 'Auditorías')
@section('content')
<div class="container-fluid content-body">
	@if(session('msg'))
	<div class="alert alert-success">
		{{session('msg')}}
	</div>
	@endif
	<div class="page-title">
		<h1>Listado <span class="semi-bold">Auditorías</span></h1>
	</div>
	@if( auth()->user()->role_id == 1 )
	<div class="row-fluid">
		@include('helpers.filters', ['index_url' => route('Audit'), 'export_url' => null, 'dates' => false])
	</div>
	@endif
	<div class="row-fluid">
		<div id="body-content">
			@include('audits.table')
		</div>
	</div>
</div>
<script type="text/javascript">
    $('body').delegate('.send-summary','click', function() {
        var audit_id = $(this).data('row-id');
        var franchise = $(this).parent().siblings("td:nth-child(3)").text();

        swal({
            title: '¿Realmente desea enviar el resultado de la auditoría a la franquicia ' + franchise + '?',
            icon: 'warning',
            buttons:["Cancelar", "Aceptar"],
            dangerMode: true,
        }).then((accept) => {
            if (accept) {
                config = {
                    'audit_id' : audit_id,
                    'route'    : "{{route('Audit.send')}}",
                    'method'   : 'POST',
                }

                ajaxSimple(config);
            }
        }).catch(swal.noop);
    });
</script>
@endsection
