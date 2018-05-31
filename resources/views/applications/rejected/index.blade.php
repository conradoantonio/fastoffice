@extends('layouts.main')
@section('pageTitle', 'Prospectos')
@section('content')
   
    @include('applications.prospects.modal')

    <div class="container-fluid content-body">
        <div class="page-title">
            <h1>Listado <span class="semi-bold">Prospectos (Rechazados)</span></h1>
        </div>

        <div class="row-fluid text-left buttons-container general-info" data-url="{{url("admin/productos")}}" data-refresh="0">
            {{-- <a href="{{route('Applications.multipleDestroys')}}" class="btn btn-danger multiple-delete-btn disabled" disabled><i class="glyphicon glyphicon-trash"></i> Eliminar múltiple</a> --}}
        </div>
        <div class="row-fluid">
            <div class="table-responsive" id="table-container">
                @include('applications.rejected.table')
            </div>
        </div>
    </div>

    @push('scripts')
        <script type="text/javascript">
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
