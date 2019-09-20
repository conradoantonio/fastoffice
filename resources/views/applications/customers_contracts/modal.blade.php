<div class="modal fade data-fill" tabindex="-1" role="dialog" aria-labelledby="label-title" id="view-payment-history">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="label-title">Historial de pagos</h4>
            </div>
            <div class="modal-body">
                <div class="row text-left payment-history-content hide">
                    <div class="col-md-12">
                        <ul class="list-group">
                            <li class="list-group-item active">Historial de pagos</li>
                            <li class="list-group-item">
                                <div class="table-responsive">
                                    <table class="table table-responsive payment-history">
                                        <thead>
                                            <th style="text-align: center;">No.</th>
                                            <th style="text-align: center;">Monto</th>
                                            <th style="text-align: center;">Método de pago</th>
                                            <th style="text-align: center;">Status</th>
                                            <th style="text-align: center;">Fecha y hora de pago</th>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row text-center load-bar">
                    <div class="col-md-12">
                        <div class="progress-outer">
                            <h5>Cargando comentarios... espere un momento</h5>
                            <div class="progress transparent progress-large progress-striped active no-radius no-margin">
                                <div data-percentage="100%" class="progress-bar progress-bar-success animate-progress-bar"></div>       
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-primary save">Guardar</button> --}}
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade data-fill" tabindex="-1" role="dialog" aria-labelledby="label-title" id="view-charges-contract">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="label-title">Cargos del contrato</h4>
            </div>
            <div class="modal-body">
                <div class="row text-left charges-contract-content hide">
                    <div class="col-md-12">
                        <ul class="list-group">
                            <li class="list-group-item active">Historial de cargos</li>
                            <li class="list-group-item">
                                <div class="table-responsive">
                                    <table class="table table-responsive charges-contract">
                                        <thead>
                                            <th style="text-align: center;">No.</th>
                                            <th style="text-align: center;">Monto</th>
                                            <th style="text-align: center;">Status</th>
                                            <th style="text-align: center;">Fecha y hora del cargo</th>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row text-center load-bar">
                    <div class="col-md-12">
                        <div class="progress-outer">
                            <h5>Cargando comentarios... espere un momento</h5>
                            <div class="progress transparent progress-large progress-striped active no-radius no-margin">
                                <div data-percentage="100%" class="progress-bar progress-bar-success animate-progress-bar"></div>       
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-primary save">Guardar</button> --}}
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade data-fill" tabindex="-1" role="dialog" data-keyboard="false" aria-labelledby="label-title" id="form-payment-receipt">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="label-title">Recibo de pago</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-sm-6 col-xs-6 hide">
                        <label class="required" for="id">ID contrato</label>
                        <input type="text" class="form-control not-empty" name="id" data-name="ID de contrato">
                    </div>
                    <div class="form-group col-sm-12 col-xs-12">
                        <label class="required" for="payment_type">Método de pago</label>
                        <select class="form-control not-empty" name="payment_type" data-name="Método de pago">
                            <option value="">Seleccione una opción</option>
                            <option value="Efectivo">Efectivo</option>
                            <option value="Tarjeta">Tarjeta</option>
                            <option value="Cheque">Cheque</option>
                            <option value="Transferencia">Transferencia</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-12 col-xs-12">
                        <label class="required" for="status">Status de pago</label>
                        <select class="form-control not-empty" name="status" data-name="Status de pago">
                            <option value="">Seleccione una opción</option>
                            <option value="1">Pago normal</option>
                            <option value="2">Pago atrasado</option>
                            <option value="3">Pago esporádico</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-12 col-xs-12">
                        <label class="required" for="sporadic_payment">Cantidad pagada</label>
                        <input type="text" class="form-control numeric" name="sporadic_payment" data-name="Cantidad pagada">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary show-receipt-pdf">Ver recibo</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade data-fill" tabindex="-1" role="dialog" aria-labelledby="label-title" id="mark-as-paid">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="label-title">Realizar pagado</h4>
            </div>
            <form id="form-data" class="valid ajax-plus" action="{{route('Crm.contracts.make_payment')}}" onsubmit="return false;" enctype="multipart/form-data" method="POST" autocomplete="off" data-ajax-type="ajax-form-modal" data-column="0" data-refresh="table" data-redirect="0" data-table_id="rows" data-container_id="table-container">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-sm-12 col-xs-12 hide">
                            <label class="required" for="contract_id">ID</label>
                            <input type="text" class="not-empty" name="contract_id" data-name="ID">
                        </div>
                        <div class="form-group col-sm-12 col-xs-12">
                            <label class="required" for="payment_method">Método de pago</label>
                            <select class="form-control not-empty" name="payment_method" data-name="Método de pago">
                                <option value="">Seleccione una opción</option>
                                <option value="Efectivo">Efectivo</option>
                                <option value="Tarjeta">Tarjeta</option>
                                <option value="Cheque">Cheque</option>
                                <option value="Transferencia">Transferencia</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-12 col-xs-12">
                            <label class="required" for="type">Status de pago</label>
                            <select class="form-control not-empty" name="type" data-name="Status de pago">
                                <option value="">Seleccione una opción</option>
                                <option value="Pago normal">Pago normal</option>
                                <option value="Pago atrasado">Pago atrasado</option>
                                <option value="Pago esporádico">Pago esporádico</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-12 col-xs-12">
                            <label class="required" for="payment">Cantidad pagada</label>
                            <input type="text" readonly class="form-control not-empty" name="payment" data-name="Cantidad pagada (en palabras)">
                        </div>
                        <div class="form-group col-sm-12 col-xs-12">
                            <label class="required" for="payment_str">Cantidad pagada (en palabras)</label>
                            <input type="text" readonly class="form-control not-empty" name="payment_str" data-name="Cantidad pagada (en palabras)">
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary guardar" data-target="form-data">Aceptar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" data-keyboard="false" aria-labelledby="label-title" id="view-new-price">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="label-title">Nuevo precio de oficina</h4>
            </div>
            <div class="modal-body">
                <div class="row text-left details-content">
                    <div class="col-md-12">
                        <ul class="list-group">
                            <li class="list-group-item active">Datos generales</li>
                            <li class="list-group-item"><span class="label_show">ID Contrato: <span class="contract-id"></span></span></li>
                            <li class="list-group-item"><span class="label_show">Oficina: <span class="office"></span></span></li>
                            <li class="list-group-item"><span class="label_show">Nombre de recepcionista: <span class="receptionist"></span></span></li>
                            <li class="list-group-item" style="color: #015715;"><span class="label_show">Precio de lista actual: $<span class="old-price"></span></span></li>
                            <li class="list-group-item" style="color: #01579b;"><span class="label_show">Nuevo precio de lista sugerido: $<span class="new-price"></span></span></li>
                        </ul>
                        <ul class="list-group">
                            <li class="list-group-item active">Nota:</li>
                            <li class="list-group-item"><span class="label_show">En caso de aceptar el nuevo monto de la oficina, el nuevo precio se verá reflejado hasta la fecha de corte siguiente sin afectar el precio de la oficina del periodo anterior.</span></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary accept-price">Aceptar nuevo precio</button>
                <button type="submit" class="btn btn-danger reject-price">Rechazar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" data-keyboard="false" aria-labelledby="label-title" id="renew-contract-modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="label-title">Renovar contrato</h4>
            </div>
            <form id="form-data-renew" class="valid ajax-plus" action="{{route('Crm.contracts.renew_contract')}}" onsubmit="return false;" enctype="multipart/form-data" method="POST" autocomplete="off" data-ajax-type="ajax-form-modal" data-column="0" data-refresh="table" data-redirect="0" data-table_id="rows" data-container_id="table-container">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-sm-12 col-xs-12 hide">
                            <label class="required" for="contract_id">ID</label>
                            <input type="text" class="not-empty" name="contract_id" data-name="ID">
                        </div>
                        <div class="form-group col-sm-12 col-xs-12">
                            <div class="alert alert-info">
                                Proporcione el precio de lista (precio por pago tardío) con un máximo de hasta 2 decimales, el sistema calculará en automático el precio por pronto pago multiplicando el monto por 0.90
                                <strong>Nota</strong><br>
                                Se modificará el precio real de la oficina.
                                Se reflejará el nuevo precio de la oficina en la siguiente fecha de cargo.
                            </div>
                            <label class="required" for="list_price">Nuevo precio de lista</label>
                            <input type="text" class="form-control not-empty decimals" name="list_price" data-name="Precio de lista">
                        </div>
                        <div class="form-group col-sm-12 col-xs-12">
                            <label class="required" for="end_date_validity">Fin de vigencia del contrato</label>
                            <input type="text" class="form-control input-date-c not-empty" name="end_date_validity" data-name="Fin de vigencia del contrato">
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary guardar" data-target="form-data-renew">Aceptar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->