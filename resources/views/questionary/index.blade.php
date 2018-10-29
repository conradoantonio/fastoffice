@extends('layouts.main')
@section('pageTitle', 'Cuestionario auditoría')
@section('content')

    <div class="container-fluid content-body">
        <div class="page-title">
            <h1>Listado de preguntas para el cuestionario de<span class="semi-bold"> auditoría.</span></h1>
        </div>
        <div class="row-fluid text-left buttons-container general-info" data-url="{{url("questionario/auditoria")}}" data-refresh="0">
            <a href="{{route('Questionary.form')}}" class="btn btn-success new-row"><i class="glyphicon glyphicon-plus"></i> Nuevo registro</a>
            {{-- <a href="{{route('Questionary.multipleDestroys')}}" class="btn btn-danger multiple-delete-btn disabled" disabled><i class="glyphicon glyphicon-trash"></i> Eliminar múltiple</a> --}}
        </div>
        <div class="row-fluid">
            <div class="table-responsive" id="table-container">
                @include('questionary.table')
            </div>
        </div>
    </div>

    @push('scripts')
    	<script type="text/javascript">
    		//View only comments
            $('body').delegate('.delete-row','click', function() {

                var id = $(this).parent().siblings("td:nth-child(1)").text();

                swal({
                    title: '¿Realmente desea eliminar este registro?',
                    content: {
                        element: "div",
                        attributes: {
                            innerHTML:"¡Esta acción no podrá deshacerse!"
                        },
                    },
                    icon: 'warning',
                    buttons:["Cancelar", "Aceptar"],
                    dangerMode: true,
                }).then((accept) => {
                    if (accept) {
                        config = {
		                    'id'        : id,
		                    'route'     : "{{route('Questionary.change_status')}}",
		                    'method'    : 'POST',
		                    'refresh'   : 'table',
		                }

		                ajaxSimple(config);
                    }
                }).catch(swal.noop);
            });
    	</script>
    @endpush
@endsection
