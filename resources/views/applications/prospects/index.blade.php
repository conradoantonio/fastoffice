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
            //Reject prospects
            $('body').delegate('.reject-prospect','click', function() {
                var prospect = $(this).parent().siblings("td:nth-child(3)").text();
                
                $('#reject-application input[name=prospect]').val(prospect);
                $('#reject-application input[name=application_id]').val($(this).data('parent-id'));
                $('#reject-application input[name=status]').val(3);
                $('#reject-application').modal('show');
            });

            //Add comments
            $('body').delegate('.add-comments','click', function() {
                var prospect = $(this).parent().siblings("td:nth-child(3)").text();

                $('#add-application-comment input[name=prospect]').val(prospect);
                $('#add-application-comment input[name=application_id]').val($(this).data('parent-id'));
                $('#add-application-comment').modal('show');
            });

            $('body').delegate('.view-comments','click', function() {
                var id = $(this).parent().siblings("td:nth-child(1)").text();

                config = {
                    'id'        : id,
                    'route'     : "{{route('Crm.prospects.view_comments')}}",
                    'method'    : 'POST',
                    'callback'  : 'display_application_comments',
                }

                ajaxSimple(config);

                $('#view-application-comments').modal('show');
                
                /*$("table#detalles tbody").children().remove();

                items = response.detalles;
                for (var key in items) {
                    if (items.hasOwnProperty(key)) {
                        $("table#detalles tbody").append(
                            '<tr>'+
                                '<td class="text-center">'+items[key].nombre+'</td>'+
                                '<td class="text-center">$'+(items[key].precio / 100)+'</td>'+
                                '<td class="text-center">'+(items[key].cantidad)+'</td>'+
                                '<td class="text-center">$'+((items[key].precio * items[key].cantidad) / 100)+'</td>'+
                            '</tr>'
                        );
                    }
                }*/
            });
        </script>
    @endpush
@endsection
