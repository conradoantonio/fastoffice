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
        $('body').delegate('.multiple-delete-btn, .reject-prospect','click', function() {
            swal({
                title: 'Describa el por qué se rechaza el prospecto: ',
                buttons: {
                    cancel: "Cancelar",
                    confirm_reject: {
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
                                        "<div class='form-group hide'>"+
                                            "<label>Tipo de rechazo</label>"+
                                            "<input type='text' class='form-control' id='type' name='type'>"+
                                        "</div>"+
                                        "<div class='form-group hide'>"+
                                            "<label>ID</label>"+
                                            "<input type='text' class='form-control' id='id-row' name='id-row'>"+
                                        "</div>"+
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

            $('input#type').val($(this).hasClass('reject-prospect') ? 'single' : 'multiple');
            $(this).hasClass('reject-prospect') ? $('input#id-row').val($(this).data('parent-id')) : '';
        });

        //Validate the modal for change the password
        $('body').delegate('.swal-button--confirm_reject','click', function() {
            comment = $('#comment').val();
            ids_array = [];

            if ($('#type').val() == 'multiple') {
                $("input.multiple-delete").each(function() {
                    if($(this).is(':checked')) {
                        ids_array.push($(this).val());
                    }
                });
            } else {
                ids_array.push($('input#id-row').val());
            }

            if (!comment) {//Empty field
                $('li#error-fields').fadeIn();
                swal.stopLoading();
            } else {//Everything ok
                config = {
                    'ids'      : ids_array,
                    'comment'  : comment,
                    'refresh'  : 'table',
                    'status'   : 3,
                    'route'    : "{{route('Crm.prospects.change_status')}}",
                    'method'   : 'POST',
                }
                ajaxSimple(config);
            }
        });
    </script>
@endpush
@endsection
