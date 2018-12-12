<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="label-title" id="send-template">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="label-title">Enviar plantillas</h4>
            </div>
            <form id="send-template-form-users" class="valid ajax-plus" action="{{route('User.send_template')}}" onsubmit="return false;" method="POST" autocomplete="off" data-ajax-type="ajax-form-modal" data-column="0" data-refresh="table" data-redirect="0" data-table_id="rows" data-container_id="table-container">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-sm-12 col-xs-12">
                            <label class="required" for="template_id">Plantillas</label>
                            <select name="template_id" id="template_id" class="form-control not-empty select2 select2-offscreen" data-name="Plantilla">
                                <option value="0">Seleccione una plantilla</option>
                                @foreach( $templates as $template )
                                    <option value="{{$template->id}}">{{$template->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" data-target="send-template-form-users" id="send_templates">Enviar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->