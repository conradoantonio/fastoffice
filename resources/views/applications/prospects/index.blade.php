@extends('layouts.main')
@section('pageTitle', 'Prospectos')
@section('content')

    @include('applications.prospects.modal')

    <div class="container-fluid content-body">
        <div class="page-title">
            <h1>Listado <span class="semi-bold">Prospectos</span></h1>
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
        <div class="row-fluid text-left buttons-container general-info" data-url="{{url("crm/prospectos")}}" data-refresh="0">
            <a href="{{route('Crm.prospects.form')}}" class="btn btn-success new-row"><i class="glyphicon glyphicon-plus"></i> Nuevo registro</a>
            <button class="btn btn-info" data-target="#send-template" data-toggle="modal"><i class="fa fa-paper-plane"></i> Enviar plantilla</button>
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
                var office = $(this).parent().siblings("td:nth-child(8)").text();
                var url = "{{url('crm/contracts/formulario')}}"+"/"+prospect_id;

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

            //Accept the prospect
            $('body').delegate('.take-row','click', function() {
                var prospect_id = $(this).parent().siblings("td:nth-child(1)").text();
                var customer = $(this).parent().siblings("td:nth-child(3)").text();
                var office = $(this).parent().siblings("td:nth-child(8)").text();
                var url = "{{url('crm/contracts/formulario')}}"+"/"+prospect_id;

                swal({
                    title: '¿Realmente quiere tomar al prospecto ' + customer + ' interesado en la oficina ' + office + '?',
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
                            'route'     : "{{route('Crm.prospects.view_comments')}}",/*Modify this!*/
                            'method'    : 'POST',
                            //'callback'  : 'display_application_comments',
                        }

                        ajaxSimple(config);
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

            $(document).delegate("#send_button", 'click',  function(){
                var template_id = $("#template_id").val(), prospects_ids = [];

                $('.multiple-delete:checked').each(function(){
                    prospects_ids.push($(this).val());
                })

                if ( template_id == 0 || prospects_ids.length === 0 ){
                    if ( prospects_ids.length === 0 ){
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
                    'prospects_ids' : prospects_ids,
                    'keepModal'     : false,
                    'route'         : $("#send-template-form").attr('action'),
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
