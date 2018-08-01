@extends('layouts.main')
@section('pageTitle', 'Prospectos')
@section('content')
   
    @include('applications.prospects.modal')

    <div class="container-fluid content-body">
        <div class="page-title">
            <h1>Listado <span class="semi-bold">Prospectos (Rechazados)</span></h1>
        </div>
        @if( auth()->user()->role_id == 1 )
            <div class="row">
                <div class="form-group col-sm-12 col-xs-12">
                    <label class="required" for="branch_id">Franquicia</label>
                    <select class="form-control select2 not-empty" name="branch_id">
                        <option value="0">Mostrar todas</option>
                        @foreach($branches as $branch)
                            <option value="{{$branch->id}}">{{$branch->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12 text-center">
                    <button class="btn btn-primary" id="filterv2">Filtrar</button>
                </div>
            </div>
        @endif

        <div class="row-fluid text-left buttons-container general-info" data-url="{{url("crm/prospectos/historial")}}" data-refresh="0">
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
