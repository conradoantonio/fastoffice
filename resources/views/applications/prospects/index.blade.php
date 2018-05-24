@extends('layouts.main')
@section('pageTitle', 'Prospectos')
@section('content')
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
        <a href="{{-- {{route('Applications.multipleDestroys')}} --}}" class="btn btn-danger multiple-delete-btn disabled" disabled><i class="glyphicon glyphicon-trash"></i> Eliminar múltiple</a>
    </div>
    <div class="row-fluid">
        <div class="table-responsive" id="table-container">
            @include('applications.prospects.table')
        </div>
    </div>
</div>
@push('scripts')
    <script type="text/javascript">
        //Display a swal to change the password
        $('body').delegate('.multiple-delete-btn','click', function() {
            swal({
                title: 'Describa el por qué se rechaza el prospecto: ',
                buttons: {
                    cancel: "Cancelar",
                    confirm_p: {
                        text: "Aceptar",
                        value: true,
                        visible: true,
                        className: "",
                        closeModal: false
                    },
                },
                content: {
                    element: "form",
                    attributes: {
                        innerHTML:
                            "<form>"+
                                "<div class='row'>"+
                                    "<div class='col-sm-12 col-xs-12'>"+
                                        "<div class='form-group'>"+
                                            "<label>Motivo</label>"+
                                            "<textarea type='text' rows='3' class='form-control' id='comment' name='comment'></textarea>"+
                                        "</div>"+
                                    "</div>"+
                                "</div>"+
                                "<ul class='error_list'>"+
                                    "<li style='display: none;' id='error-fields'>Este campo es obligatorio</li>"+
                                "</ul>"+
                            "</form>"
                    },
                }
            }).catch(swal.noop);
        });

        //Validate the modal for change the password
        $('body').delegate('.swal-button--confirm_p','click', function() {
            current_pass = $('#current-password').val();
            new_pass = $('#new-password').val();
            confirm_pass = $('#confirm-password').val();

            if (!current_pass || !new_pass || !confirm_pass) {//Empty fields
                $('li#error-fields').fadeIn();
                swal.stopLoading();
            } else if (!($('#confirm-password').val() == $('#new-password').val())) {//Different password
                $('li#error-pass-different').fadeIn();
                swal.stopLoading();
            } else {//Everything ok
                config = {
                    'current_pass'  : current_pass,
                    'new_pass'      : new_pass,
                    'confirm_pass'  : confirm_pass,
                    'route'         : baseUrl.concat('/system/change-password'),
                    'method'        : 'POST',
                }
                requestNewPassword(config);
            }
        });
    </script>
@endpush
@endsection
