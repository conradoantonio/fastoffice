@extends('layouts.main')
@section('pageTitle', 'Contratos de clientes')
@section('content')
    @include('applications.customers_contracts.modal')
    <div class="container-fluid content-body">
        <div class="page-title">
            <h1>Listado <span class="semi-bold">de contratos de clientes</span></h1>
        </div>
        @if( auth()->user()->role_id == 1 )
        {{-- <div class="row-fluid">
            @include('helpers.filters', ['index_url' => route('Office'), 'export_url' => null, 'dates' => false])
        </div> --}}
        @endif
        <div class="row-fluid text-left buttons-container general-info" data-url="{{url("admin/productos")}}" data-refresh="0">
            <a id="payment-recepit-tab" href="" target="_blank"></a>
            {{-- <a href="{{route('Crm.prospects.form')}}" class="btn btn-success new-row"><i class="glyphicon glyphicon-plus"></i> Nuevo registro</a> --}}
            {{-- <a href="{{route('Applications.multipleDestroys')}}" class="btn btn-danger multiple-delete-btn disabled" disabled><i class="glyphicon glyphicon-trash"></i> Eliminar múltiple</a> --}}
        </div>
        <div class="row-fluid">
            <div class="table-responsive" id="table-container">
                @include('applications.customers_contracts.table')
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

            $('body').delegate('.show-money-receipt','click', function() {
                $('#form-payment-receipt select[name=payment_type]').val(0);//Reset select

                var id = $(this).parent().siblings("td:nth-child(1)").text();

                $('#form-payment-receipt input[name=id]').val(id);              
                $('#form-payment-receipt').modal('show');              
            });

            $('body').delegate('.show-receipt-pdf','click', function() {
                type = $('#form-payment-receipt select[name=payment_type]').val();
                id = $('#form-payment-receipt input[name=id]').val();

                if (!type || !id) {
                    swal({
                        title: 'Seleccione una opción para continuar',
                        icon: 'error',
                    }).catch(swal.noop);
                } else {
                    href = '{{route('Crm.contracts.show_money_receipt')}}/'+id+'/'+type;

                    $("a#payment-recepit-tab").attr('href', href);
                    $("a#payment-recepit-tab")[0].click();
                }
            });

        </script>
    @endpush
@endsection
