@extends('layouts.main')
@section('pageTitle', 'CRM')
@section('content')
<div class="container-fluid content-body">
	@if(session('msg'))
	<div class="alert alert-danger">
		{{session('msg')}}
	</div>
	@endif
	<div class="page-title">
		<h1>{{$contract ? 'Actualizar' : 'Crear'}} <span class="semi-bold">Contrato</span></h1>
	</div>
	<div class="row-fluid">
        <form id="form-data" class="valid ajax-plus" action="{{route($contract ? 'Crm.contracts.update' : 'Crm.contracts.save')}}" onsubmit="return false;" enctype="multipart/form-data" method="POST" autocomplete="off" data-ajax-type="ajax-form" data-column="0" data-refresh="0" data-redirect="1" data-table_id="example3" data-container_id="table-container">
        	<div class="row">
        	 	<div class="form-group col-sm-6 col-xs-12 hide">
	                <label class="required" for="id">ID</label>
	                <input type="text" class="form-control" value="{{$contract ? $contract->id : ''}}" id="id" name="id">
	            </div>
        	</div>
        	{{-- Application details data --}}
        	<div class="row">
        	 	<div class="form-group col-sm-6 col-xs-12 hide">
	                <label for="user_id">User ID</label>
	                <input type="text" class="form-control" value="{{$prospect && $prospect->customer ? $prospect->user_id : ''}}" name="user_id">
	            </div>
        	</div>
        	<div class="row">
        	 	<div class="form-group col-sm-6 col-xs-12 hide">
	                <label for="application_id">Application ID</label>
	                <input type="text" class="form-control" value="{{$prospect ? $prospect->id : ''}}" name="application_id">
	            </div>
        	</div>
        	<div class="row">
        	 	<div class="form-group col-sm-6 col-xs-12 hide">
	                <label for="office_id">Office ID</label>
	                <input type="text" class="form-control" value="{{$prospect && $prospect->office ? $prospect->office_id : ''}}" name="office_id">
	            </div>
        	</div>
            <hr>

            <h3>Datos generales del contrato</h3>
            <div class="row">
                <div class="form-group col-sm-12 col-xs-12">
                    <label class="required" for="contract_date">Fecha de contrato</label>
                    <input type="text" class="form-control {{$contract ? '' : 'input-date-c'}} not-empty" {{$contract ? 'readonly' : ''}} value="{{$contract ? $contract->contract_date : date('Y-m-d')}}" name="contract_date" data-name="Fecha de contrato">
                </div>
            </div>
            @if(! $contract )
                <div class="alert alert-info">
                    Si selecciona una fecha mayor al día 24 del mes, en automático se ajustará hacia el día primero del mes siguiente.
                </div>
            @endif
            <div class="row">
                <div class="form-group col-sm-12 col-xs-12">
                    <label class="required" for="start_date_validity">Inicio de vigencia del contrato</label>
                    <input type="text" class="form-control {{$contract ? '' : 'input-date-c'}} not-empty" {{$contract ? 'readonly' : ''}} value="{{$contract ? $contract->start_date_validity : date('Y-m-d')}}" name="start_date_validity" data-name="Inicio de vigencia del contrato">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-12 col-xs-12">
                    <label class="required" for="end_date_validity">Fin de vigencia del contrato</label>
                    <input type="text" class="form-control input-date-c not-empty" value="{{$contract ? $contract->end_date_validity : ''}}" name="end_date_validity" data-name="Fin de vigencia del contrato">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-4 col-xs-12">
                    <label class="control-label required" for="state_id">Estado</label>
                    <select name="state_id" class="form-control not-empty select2" data-name="Estado">
                        <option value="0" disabled selected>SELECCIONE UNA OPCIÓN</option>
                        @if ( $contract )
                            @foreach($states as $state)
                                <option value="{{$state->id}}" {{$contract->state_id == $state->id ? 'selected' : ''}}>{{$state->name}}</option>
                            @endforeach
                        @else
                            @foreach($states as $state)
                                <option value="{{$state->id}}">{{$state->name}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group col-sm-4 col-xs-12">
                    <label class="control-label required" for="municipality_id">Municipio</label>
                    <select name="municipality_id" class="form-control not-empty select2" data-name="Municipio">
                        <option value="0" disabled selected>SELECCIONE UNA OPCIÓN</option>
                        @if ( $contract )
                            @foreach($municipalities as $municipality)
                                <option value="{{$municipality->id}}" {{$contract->municipality_id == $municipality->id ? 'selected' : ''}}>{{$municipality->name}}</option>
                            @endforeach
                        @else
                            @foreach($municipalities as $municipality)
                                <option value="{{$municipality->id}}">{{$municipality->name}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group col-sm-4 col-xs-12">
                    <label class="required" for="country">País</label>
                    <input type="text" class="form-control not-empty upper" value="{{$contract ? $contract->country : 'México' }}" name="country" data-name="Cliente: Tipo de identificación">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-12 col-xs-12">
                    <label for="office_data">Oficina</label>
                    <input type="text" class="form-control" disabled value="{{$prospect && $prospect->office && $prospect->office->branch ? $prospect->office->name. ' LOCALIZADA EN '. $prospect->office->branch->address.' '.$prospect->office->branch->municipality->name.', '.$prospect->office->branch->state->name : ''}}" name="office_data">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-12 col-xs-12">
                    <label class="required" for="bank_reference">Referencia bancaria</label>
                    <input type="text" class="form-control not-empty" value="{{$contract ? $contract->bank_reference : ''}}" name="bank_reference" data-name="Referencia bancaria">
                </div>
            </div>
            @if( $prospect && ( $prospect->office->type->name == 'VIRTUAL' || $prospect->office->type->name == 'FÍSICA' ) )
                <div class="alert alert-info">
                    Nota: Si modifica el contrato agregando más personas adicionales, se realizará un cargo extra en la próxima fecha de pago.
                </div>
                <div class="row">
                    <div class="form-group col-sm-6 col-xs-12">
                        <label class="required" for="usage">Uso de oficina</label>
                        <select name="usage" class="form-control not-empty select2" data-name="Uso de oficina">
                            <option value="0" disabled selected>SELECCIONE UNA OPCIÓN</option>
                            @if ( $contract )
                                <option value="OFICINA" {{$contract->usage == "OFICINA" ? 'selected' : ''}}>OFICINA</option>
                                <option value="COMERCIAL" {{$contract->usage == "COMERCIAL" ? 'selected' : ''}}>COMERCIAL</option>
                                <option value="CONSULTORIO" {{$contract->usage == "CONSULTORIO" ? 'selected' : ''}}>CONSULTORIO</option>
                            @else
                                <option value="OFICINA">OFICINA</option>
                                <option value="COMERCIAL">COMERCIAL</option>
                                <option value="CONSULTORIO">CONSULTORIO</option>
                            @endif
                        </select>
                    </div>
                    <div class="form-group col-sm-6 col-xs-12">
                        <label class="" for="additional_people">Personas adicionales</label>
                        <select name="additional_people" class="form-control select2" data-name="Personas adicionales">
                            <option value="0" selected>SIN PERSONAS ADICIONALES</option>
                            @if ( $contract )
                                @for($i=1; $i <= 5; $i++)
                                    <option value="{{$i}}" {{$contract->additional_people == $i ? 'selected' : ''}}>{{$i}}</option>
                                @endfor
                            @else
                               @for($i=1; $i <= 5; $i++)
                                    <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            @endif
                        </select>
                    </div>
                    <div class="form-group col-sm-6 col-xs-6" style="padding-bottom: 20px;">
                        <label for="telephone_line">Incluye línea telefónica</label>
                        <div class="checkbox check-primary">
                            <input id="telephone_line" name="telephone_line" type="checkbox" {{$contract && $contract->telephone_line ? 'checked' : ''}}>
                            <label for="telephone_line" style="padding-left:0px;"></label>
                        </div>
                    </div>
                    <div class="form-group col-sm-6 col-xs-6" style="padding-bottom: 20px;">
                        <label for="computer_station">Incluye estación de cómputo</label>
                        <div class="checkbox check-primary">
                            <input id="computer_station" name="computer_station" type="checkbox" {{$contract && $contract->computer_station ? 'checked' : ''}}>
                            <label for="computer_station" style="padding-left:0px;"></label>
                        </div>
                    </div>
                </div>
            @endif
            @if( $prospect && $prospect->office->type->name == 'VIRTUAL' )
                <div class="row">
                    <div class="form-group col-sm-12 col-xs-12">
                        <label class="required" for="office_type_category_id">Plantilla de oficina {{$prospect->office->type->name}}</label>
                        <select name="office_type_category_id" class="form-control not-empty select2" data-name="Plantilla de oficina {{$prospect->office->type->name}}">
                            <option value="0" disabled selected>SELECCIONE UNA OPCIÓN</option>
                            @if ($contract)
                                @foreach($of_ty_cat as $of_cat)
                                    <option value="{{$of_cat->id}}" {{$contract->office_type_category_id == $of_cat->id ? 'selected' : ''}}>{{$of_cat->name}}</option>
                                @endforeach
                            @else
                                @foreach($of_ty_cat as $of_cat)
                                    <option value="{{$of_cat->id}}">{{$of_cat->name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            @endif
            @if( $prospect && ( $prospect->office->type->name == 'VIRTUAL' || $prospect->office->type->name == 'FÍSICA' ) )
                <div class="alert alert-info">
                    <strong>Nota: </strong>Especifique el número de horas que cuenta el cliente para la sala de juntas o deje este campo vacío para indicar que el cliente cuenta con horas ilimitadas ( Aplican restricciones y disponibilidad )
                </div>
                <div class="row">
                    <div class="form-group col-sm-12 col-xs-12">
                        <label class="" for="meeting_room_hours">Número de horas para la sala de juntas</label>
                        <input type="text" class="form-control" value="{{$contract ? $contract->meeting_room_hours : ''}}" name="meeting_room_hours" data-name="Número de horas para la sala de juntas">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12 col-xs-12">{{-- Don't save in contract --}}
                        <label class="required" for="monthly_payment">Pago mensual $</label>
                        <input type="text" class="form-control not-empty" disabled value="${{$prospect && $prospect->office ? $prospect->office->monthly_price : ''}}" name="monthly_payment" data-name="Pago mensual">
                    </div>
                </div>
                @if( $contract )
                    <div class="row">
                        <div class="form-group col-sm-12 col-xs-12">
                            <label class="required" for="monthly_payment_str">Pago mensual (en palabras)</label>
                            <input type="text" class="form-control not-empty" disabled value="{{$contract->monthly_payment_str}}" name="monthly_payment_str" data-name="Pago mensual (en palabras)">
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="form-group col-sm-12 col-xs-12">
                        <label class="required" for="monthly_payment_delay">Pago mensual por atraso $</label>
                        <input type="text" class="form-control not-empty" disabled value="${{$prospect && $prospect->office ? ($prospect->office->price) : ''}}" name="monthly_payment_delay" data-name="Pago mensual por atraso $">
                    </div>
                </div>
                @if( $contract )
                    <div class="row">
                        <div class="form-group col-sm-12 col-xs-12">
                            <label class="required" for="monthly_payment_delay_str">Pago mensual por atraso (en palabras)</label>
                            <input type="text" class="form-control not-empty" readonly value="{{$contract->monthly_payment_delay_str}}" name="monthly_payment_delay_str" data-name="Pago mensual por atraso (en palabras)">
                        </div>
                    </div>
                @endif
                @if( auth()->user()->role->name == 'Recepcionista' && ! $contract )
                    <div class="alert alert-info">
                        Sugiera un nuevo precio de lista para la oficina (sólo números con un máximo de hasta 2 decimales), en automático se calculará el precio por pronto pago en caso de ser aprobado por un franquisatario.
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12 col-xs-12">
                            <label class="" for="new_price">Sugerir precio de lista</label>
                            <input type="text" class="form-control decimals" value="{{-- {{$contract && $contract->new_office_price ? $contract->new_office_price->price : ''}} --}}" name="new_price" data-name="Precio sugerido">
                        </div>
                    </div>
                @endif
            @elseif( $prospect && ( $prospect->office->type->name == 'SALA DE JUNTAS' || $prospect->office->type->name == 'SALA DE CONFERENCIAS' ) )
                <div class="row">
                    <div class="form-group col-sm-12 col-xs-12">{{-- Don't save in contract --}}
                        <label class="required" for="monthly_payment">Pago por hora $</label>
                        <input type="text" class="form-control not-empty" disabled value="${{$prospect && $prospect->office ? $prospect->office->monthly_price : ''}}" name="monthly_payment" data-name="Pago por hora">
                    </div>
                </div>
                @if( $contract )
                    <div class="row">
                        <div class="form-group col-sm-12 col-xs-12">
                            <label class="required" for="monthly_payment_str">Pago por hora (en palabras)</label>
                            <input type="text" class="form-control not-empty" value="{{$contract->monthly_payment_str}}" name="monthly_payment_str" data-name="Pago por hora (en palabras)">
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="form-group col-sm-12 col-xs-12">
                        <label class="required" for="start_hour">Hora inicio</label>
                        <input type="text" class="form-control clockpicker not-empty" value="{{$contract ? $contract->start_hour : ''}}" name="start_hour" data-name="Hora inicio">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12 col-xs-12">
                        <label class="required" for="end_hour">Hora fin</label>
                        <input type="text" class="form-control clockpicker not-empty" value="{{$contract ? $contract->end_hour : ''}}" name="end_hour" data-name="Hora fin">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12 col-xs-12">
                        <label class="required" for="total_hours">Total de horas</label>
                        <input type="text" class="form-control not-empty" value="{{$contract ? $contract->total_hours : ''}}" name="total_hours" data-name="Total de horas">
                    </div>
                </div>
            @endif

            <hr>
            <h3>Datos del prestador (Franquiciatario)</h3>
        	<div class="row">
        		<div class="form-group col-sm-6 col-xs-12">
                    <label class="required" for="provider_name">Nombre del prestador</label>
                    <input type="text" class="form-control not-empty upper" readonly value="{{ $prospect && $prospect->office && $prospect->office->branch->user ? $prospect->office->branch->user->fullname : '' }}" name="provider_name" data-name="Nombre de prestador">
                </div>
                <div class="form-group col-sm-6 col-xs-12">
                    <label class="required" for="provider_rfc">RFC</label>
                    <input type="text" class="form-control not-empty upper" readonly value="{{ $prospect && $prospect->office && $prospect->office->branch->user ? $prospect->office->branch->user->rfc : '' }}" name="provider_rfc" data-name="RFC de prestador">
                </div>
        	</div>
            
            <hr>
            <h3>Datos del cliente</h3>
            <div class="alert alert-info">
                Nota: Modificar los datos del cliente en el formulario de contrato NO modificará su perfil actual.
            </div>
            <div class="row">
                <div class="form-group col-sm-6 col-xs-12">
                    <label class="required" for="customer_name">Nombre o razón social</label>
                    <input type="text" class="form-control upper" disabled value="{{$prospect && $prospect->customer ? $prospect->customer->fullname : ''}}" name="customer_name" data-name="Cliente: Nombre o razón social">
                </div>
                <div class="form-group col-sm-6 col-xs-12">
                    <label class="required" for="customer_rfc">RFC</label>
                    <input type="text" class="form-control upper" readonly value="{{$prospect && $prospect->customer ? $prospect->customer->rfc : ''}}" name="customer_rfc" data-name="Cliente: RFC">
                </div>
                <div class="form-group col-sm-6 col-xs-12">
                    <label class="required" for="customer_email">Email</label>
                    <input type="text" class="form-control" readonly value="{{$prospect && $prospect->customer ? $prospect->customer->email : ''}}" name="customer_email" data-name="Cliente: Email">
                </div>
                <div class="form-group col-sm-6 col-xs-12">
                    <label class="required" for="customer_phone">Teléfono</label>
                    <input type="text" class="form-control upper" readonly value="{{$prospect && $prospect->customer ? $prospect->customer->phone : ''}}" name="customer_phone" data-name="Cliente: Teléfono">
                </div>
            </div>
        	<div class="row">
                <div class="form-group col-sm-6 col-xs-12">
                    <label class="required" for="customer_identification_type">Tipo de identificación</label>
                    <input type="text" class="form-control not-empty upper" value="{{$contract ? $contract->customer_identification_type : ( $prospect && $prospect->customer ? $prospect->customer->identification_type : '' )}}" name="customer_identification_type" data-name="Cliente: Tipo de identificación">
                </div>
        		<div class="form-group col-sm-6 col-xs-12">
                    <label class="required" for="customer_identification_num">Número de identificación</label>
                    <input type="text" class="form-control not-empty numeric" value="{{$contract ? $contract->customer_identification_num : ( $prospect && $prospect->customer ? $prospect->customer->identification_num : '' )}}" name="customer_identification_num" data-name="Cliente: Número de identificación">
                </div>
        		<div class="form-group col-sm-12 col-xs-12">
                    <label class="required" for="customer_business_activity">Giro empresarial</label>
                    <input type="text" class="form-control not-empty upper" value="{{$contract ? $contract->customer_business_activity : ( $prospect && $prospect->customer ? $prospect->customer->business_activity : '' )}}" name="customer_business_activity" data-name="Cliente: Giro empresarial">
                </div>
        	</div>
        	<div class="row">
        		<div class="form-group col-sm-12 col-xs-12">
                    <label class="required" for="customer_address">Domicilio</label>
                    <textarea class="form-control not-empty upper" rows="4" name="customer_address" data-name="Cliente: Domicilio">{{$contract ? $contract->customer_address : ( $prospect && $prospect->customer ? $prospect->customer->address : '' )}}</textarea>
                </div>
        	</div>
        	<hr>
        	<a href="{{route($contract ? 'Crm.contracts' : 'Crm.prospects')}}"><button type="button" class="btn btn-danger">Regresar</button></a>
            <button type="submit" class="btn btn-success guardar" data-target="form-data">Guardar</button>
        </form>
	</div>
</div>
@push('scripts')
	<script type="text/javascript">
		$(function() {
			$(".input-date-c").datepicker({
				language: 'es',
				autoclose: true,
				todayHighlight: true,
				format: "yyyy-mm-dd",
				clearBtn: true,
			});/*.on('changeDate', function() {
				in_da = $(this);
				if (in_da.attr('id') == 'start_date_validity' && in_da.val() != '') {

					var init_date = in_da.val();
					var fecha = new Date(Date.UTC(init_date.substring(0,4), init_date.substring(5,7), init_date.substring(8,10)));
					var utcTime = fecha.getUTCHours();
					fecha.setHours(utcTime-5);
					console.log(fecha);
					dia_inicio = fecha.getUTCDate();
					var dias = 4;
					//console.warn(fecha.getDate());
					fecha.setDate(fecha.getUTCDate() + dias);
					dia_fin = fecha.getUTCDate();

					$('#payment_range_start').val(dia_inicio);
					$('#payment_range_end').val(dia_fin);
				}
			})*/
		});

        $('select[name="state_id"]').on('change', function(){
            elem_to_block = $('select[name="municipality_id"]').parent('div').children('div.select2-container');
            $("select[name='municipality_id']").select2("val", 0);
            if ( $(this).val() != 0 ){
                $.ajax({
                    url: "{{url('obtener-municipio')}}/"+$(this).val(),
                    method: 'POST',
                    beforeSend:function(){
                        blockUI(elem_to_block);
                    },
                    success:function(response){
                        $("select[name='municipality_id'] option:gt(0)").remove();
                        $.each(response,function(i,e){
                            $("select[name='municipality_id']").append("<option value='"+e.id+"'>"+e.name+"</option>");
                        })
                        unblockUI(elem_to_block);
                    }
                })
            } else {
                $("select[name='municipality_id'] option:gt(0)").remove();
            }
        })

	/*$('#start_date_validity').change(function() {
	});*/
	</script>
@endpush
@endsection
