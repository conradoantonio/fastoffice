@extends('layouts.main')
@section('pageTitle', 'Contratos de clientes')
@section('content')
    @include('applications.customers_contracts.modal')
    <div class="container-fluid content-body">
        <div class="page-title">
            <h1>Listado <span class="semi-bold">de contratos de clientes</span></h1>
        </div>
        @if(session('msg'))
            <div class="alert alert-warning">
                {{session('msg')}}
            </div>
        @endif
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
        <div class="row-fluid text-left buttons-container general-info" data-url="{{url("crm/contracts")}}" data-refresh="0">
            <a id="new-link" href="" target="_blank"></a>
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

            //Show the form to generate a new pdf of money receipt
            $('body').delegate('.show-money-receipt','click', function() {
                $('#form-payment-receipt select[name=payment_type]').val(0);//Reset select
                $('#form-payment-receipt input.form-control').val('');//Reset select

                var id = $(this).parent().siblings("td:nth-child(1)").text();

                $('#form-payment-receipt input[name=id]').val(id);              
                $('#form-payment-receipt').modal('show');              
            });

            //Show the money receipt pdf
            $('body').delegate('.show-receipt-pdf','click', function() {
                type = $('#form-payment-receipt select[name=payment_type]').val();
                id = $('#form-payment-receipt input[name=id]').val();
                status = $('#form-payment-receipt select[name=status]').val();

                if (!type || !id || !status) {
                    swal({
                        title: 'Complete los campos antes de continuar',
                        icon: 'error',
                    }).catch(swal.noop);
                } else {
                    href = '{{route('Crm.contracts.show_money_receipt')}}/'+id+'/'+type+'/'+status;

                    $("a#new-link").attr('href', href);
                    $("a#new-link")[0].click();
                }
            });

            //Show the modal to make a payment
            $('body').delegate('.mark-as-paid','click', function() {
                var id = $(this).parent().siblings("td:nth-child(1)").text();
                var normal_price = $(this).parent().siblings("td:nth-child(9)").text();
                var normal_price_str = $(this).parent().siblings("td:nth-child(10)").text();
                var delay_price = $(this).parent().siblings("td:nth-child(11)").text();
                var delay_price_str = $(this).parent().siblings("td:nth-child(12)").text();

                $('#mark-as-paid input[name=contract_id]').val(id);
                $('#mark-as-paid select[name=type]').children().remove();
                $('#mark-as-paid select[name=type]').append(
                    '<option value="">Seleccione una opción</option>'+
                    '<option value="1" quantity="'+normal_price+'" money-str="'+normal_price_str+'">Normal</option>'+
                    '<option value="2" quantity="'+delay_price+'" money-str="'+delay_price_str+'">Atrasado</option>');
                $('div#mark-as-paid').modal('show');
            });

            //Code to load input content for the payment
            $('body').delegate('#mark-as-paid select[name=type]', 'change', function() {
                var price = $('option:selected', this).attr('quantity');
                var str = $('option:selected', this).attr('money-str');

                $('#mark-as-paid input[name=payment]').val(price);
                $('#mark-as-paid input[name=payment_str]').val(str);
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

            //Finish a contract
            $('body').delegate('.finish-contract','click', function() {
                var id = $(this).parent().siblings("td:nth-child(1)").text();
                var customer = $(this).parent().siblings("td:nth-child(3)").text();
                var office = $(this).parent().siblings("td:nth-child(6)").text();

                swal({
                    title: '¿Realmente quiere finalizar el contrato del cliente ' + customer + ' con la oficina ' + office + '?',
                    text: '¡Esta acción NO podrá deshacerse!',
                    icon: 'warning',
                    buttons:["Cancelar", "Aceptar"],
                    dangerMode: true,
                }).then((accept) => {
                    if (accept) {
                        config = {
                            'id'        : id,
                            'route'     : "{{route('Crm.contracts.mark_as_finished')}}",
                            'method'    : 'POST',
                            'refresh'   : 'table',
                        }

                        loadAnimation('Espere un momento...');
                        ajaxSimple(config);
                    }
                }).catch(swal.noop);
            });
        </script>
    @endpush
@endsection
