@extends('layouts.main')
@section('pageTitle', 'Prospectos')
@section('content')
   
    @include('applications.prospects.modal')

    <div class="container-fluid content-body">
        <div class="page-title">
            <h1>Listado <span class="semi-bold">Prospectos</span></h1>
        </div>
        @if( auth()->user()->role_id == 1 )
        {{-- <div class="row-fluid">
            @include('helpers.filters', ['index_url' => route('Office'), 'export_url' => null, 'dates' => false])
        </div> --}}
        @endif
        <div class="row-fluid text-left buttons-container general-info" data-url="{{url("admin/productos")}}" data-refresh="0">
            <a href="{{route('Crm.prospects.form')}}" class="btn btn-success new-row"><i class="glyphicon glyphicon-plus"></i> Nuevo registro</a>
            {{-- <a href="{{route('Applications.multipleDestroys')}}" class="btn btn-danger multiple-delete-btn disabled" disabled><i class="glyphicon glyphicon-trash"></i> Eliminar múltiple</a> --}}
        </div>
        <div class="row-fluid">
            <div class="table-responsive" id="table-container">
                @include('applications.prospects.table')
            </div>
        </div>
    </div>

    @push('scripts')
        <script type="text/javascript">
            //Add comment to calendar
            $('body').delegate('#add_to_calendar', 'click', function() {
                if ($(this).is(":checked")) {
                    $('input[name=date], input[name=hour]').parent().removeClass('hide');
                    $('input[name=date], input[name=hour]').addClass('not-empty');
                } else {
                    $('input[name=date], input[name=hour]').parent().addClass('hide');
                    $('input[name=date], input[name=hour]').removeClass('not-empty');
                }
            });

            //Accept the prospect
            $('body').delegate('.accept-prospect','click', function() {
                var prospect_id = $(this).parent().siblings("td:nth-child(1)").text();
                var customer = $(this).parent().siblings("td:nth-child(3)").text();
                var office = $(this).parent().siblings("td:nth-child(7)").text();
                var url = "{{url('crm/prospectos/formulario-contrato')}}"+"/"+prospect_id;

                swal({
                    title: '¿Realmente quiere aceptar al prospecto ' + customer + ' interesado en la oficina ' + office + '?',
                    content: {
                        element: "div",
                        attributes: {
                            innerHTML:"¡En caso de ser necesario, se creará un usuario para que el cliente pueda acceder a la aplicación!"
                        },
                    },
                    icon: 'warning',
                    buttons:["Cancelar", "Aceptar"],
                    dangerMode: true,
                }).then((accept) => {
                    if (accept) {
                        window.location.href = url;
                    }
                }).catch(swal.noop);
            });

            //Reject prospects
            $('body').delegate('.reject-prospect', 'click', function() {
                var prospect = $(this).parent().siblings("td:nth-child(3)").text();
                
                $('#reject-application input[name=prospect]').val(prospect);
                $('#reject-application input[name=application_id]').val($(this).data('parent-id'));
                $('#reject-application input[name=status]').val(3);
                $('#reject-application').modal('show');
            });

            //Add comments
            $('body').delegate('.add-comments', 'click', function() {
                var prospect = $(this).parent().siblings("td:nth-child(3)").text();

                $('input[name=date], input[name=hour]').parent().addClass('hide');
                $('input[name=date], input[name=hour]').removeClass('not-empty');

                $('#add-application-comment input[name=prospect]').val(prospect);
                $('#add-application-comment input[name=application_id]').val($(this).data('parent-id'));
                $('#add-application-comment').modal('show');
            });

            //View only comments
            $('body').delegate('.view-comments','click', function() {
                $('div.load-bar').removeClass('hide');
                $('div.comments-content').addClass('hide');
                $('#view-application-comments').modal('show');

                var id = $(this).parent().siblings("td:nth-child(1)").text();

                config = {
                    'id'        : id,
                    'keepModal' : true,
                    'route'     : "{{route('Crm.prospects.view_comments')}}",
                    'method'    : 'POST',
                    'callback'  : 'display_application_comments',
                }

                ajaxSimple(config);
            });

            //View details from application prospect
            $('body').delegate('.view-details', 'click', function() {
                $('div.load-bar').removeClass('hide');
                $('div.details-content').addClass('hide');
                $('#view-application-details').modal('show');

                var id = $(this).parent().siblings("td:nth-child(1)").text();

                config = {
                    'id'        : id,
                    'keepModal' : true,
                    'route'     : "{{route('Crm.prospects.get_application_info')}}",
                    'method'    : 'POST',
                    'callback'  : 'display_application_details',
                }

                ajaxSimple(config);
            });
        </script>
    @endpush
@endsection
