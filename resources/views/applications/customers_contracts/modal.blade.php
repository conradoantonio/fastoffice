<div class="modal fade data-fill" tabindex="-1" role="dialog" data-keyboard="false" aria-labelledby="label-title" id="form-payment-receipt">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="label-title">Recibo de pago</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-sm-6 col-xs-6">
                        <label class="required" for="id">ID contrato</label>
                        <input type="text" class="form-control not-empty" name="id" data-name="ID de contrato">
                    </div>
                    <div class="form-group col-sm-12 col-xs-12">
                        <label class="required" for="payment_type">¿Cómo pagó el cliente?</label>
                        <select class="form-control not-empty" name="payment_type" data-name="Prospecto">
                            <option value="">Seleccione una opción</option>
                            <option value="Efectivo">Efectivo</option>
                            <option value="Tarjeta">Tarjeta</option>
                        </select>
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