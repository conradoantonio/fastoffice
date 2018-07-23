@extends('layouts.main')
@section('pageTitle', 'Contratos de clientes')
@section('content')
    @include('applications.customers_contracts.modal')
    <div class="container-fluid content-body">
        <div class="page-title">
            <h1>Listado <span class="semi-bold">de contratos finalizados</span></h1>
        </div>
        @if(session('msg'))
            <div class="alert alert-warning">
                {{session('msg')}}
            </div>
        @endif
        @if( auth()->user()->role_id == 1 )
        {{-- <div class="row-fluid">
            @include('helpers.filters', ['index_url' => route('Office'), 'export_url' => null, 'dates' => false])
        </div> --}}
        @endif
        <div class="row-fluid text-left buttons-container general-info" data-url="{{url("admin/productos")}}" data-refresh="0">
            <a id="new-link" href="" target="_blank"></a>
            {{-- <a href="{{route('Crm.prospects.form')}}" class="btn btn-success new-row"><i class="glyphicon glyphicon-plus"></i> Nuevo registro</a> --}}
            {{-- <a href="{{route('Applications.multipleDestroys')}}" class="btn btn-danger multiple-delete-btn disabled" disabled><i class="glyphicon glyphicon-trash"></i> Eliminar múltiple</a> --}}
        </div>
        <div class="row-fluid">
            <div class="table-responsive" id="table-container">
                @include('applications.contracts_finished.table')
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

            //Load payments history
            $('body').delegate('.view-payments','click', function() {
                $('div.load-bar').removeClass('hide');
                $('div.payment-history-content').addClass('hide');
                $('#view-payment-history').modal('show');

                var id = $(this).parent().siblings("td:nth-child(1)").text();

                config = {
                    'id'        : id,
                    'keepModal' : true,
                    'route'     : "{{route('Crm.contracts.get_payment_history')}}",
                    'method'    : 'POST',
                    'callback'  : 'display_payment_history',
                }

                ajaxSimple(config);
            });

            //Cancel a contract or view cancelation doc
            $('body').delegate('.cancel-contract','click', function() {
                var id = $(this).parent().siblings("td:nth-child(1)").text();
                var canceled = $(this).data('cancelled');
                var customer = $(this).parent().siblings("td:nth-child(3)").text();
                var office = $(this).parent().siblings("td:nth-child(6)").text();

                if (!canceled) {
                    swal({
                        title: '¿Realmente quiere cancelar el contrato del cliente ' + customer + ' con la oficina ' + office + '?',
                        text: '¡Tendrás que marcar como finalizado este contrato manualmente de todos modos!',
                        icon: 'warning',
                        buttons:["Cancelar", "Aceptar"],
                        dangerMode: true,
                    }).then((accept) => {
                        if (accept) {
                            config = {
                                'id'        : id,
                                'route'     : "{{route('Crm.contracts.show_cancelled_pdf')}}",
                                'method'    : 'POST',
                                'callback'  : 'redirect_pdf',
                                'reload_ta' : true,
                            }

                            loadAnimation('Espere un momento...');
                            ajaxSimple(config);
                        }
                    }).catch(swal.noop);
                } else {
                    config = {
                        'id'        : id,
                        'route'     : "{{route('Crm.contracts.show_cancelled_pdf')}}",
                        'method'    : 'POST',
                        'callback'  : 'redirect_pdf',
                    }

                    loadAnimation('Espere un momento...');
                    ajaxSimple(config);
                }
            });
        </script>
    @endpush
@endsection
