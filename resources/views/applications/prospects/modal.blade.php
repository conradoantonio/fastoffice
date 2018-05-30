<div class="modal fade data-fill" tabindex="-1" role="dialog" aria-labelledby="label-title" id="view-application-comments">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="label-title">Comentarios sobre el prospecto</h4>
            </div>
            <div class="modal-body">
                <div class="row text-left comments-content hide">
                    <div class="col-md-12">
                        <ul class="list-group">
                            <li class="list-group-item active">Historial de comentarios</li>
                            <li class="list-group-item">
                                <div class="table-responsive">
                                    <table class="table table-responsive comments-table">
                                        <thead>
                                            <th style="text-align: center;">Comentario</th>
                                            <th style="text-align: center;">Fecha y hora de creación</th>
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
                            <span><i style="font-size: 10mm;" class="fa fa-cloud-download" aria-hidden="true"></i></span><br>
                            <div class="progress transparent progress-large progress-striped active no-radius no-margin">
                                <div data-percentage="100%" class="progress-bar progress-bar-success animate-progress-bar"></div>       
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-primary save">Guardar</button> --}}
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade data-fill" tabindex="-1" role="dialog" aria-labelledby="label-title" id="add-application-comment">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="label-title">Nuevo comentario</h4>
            </div>
            <form id="form-data" class="valid ajax-plus" action="{{route('Crm.prospects.save_comment')}}" onsubmit="return false;" enctype="multipart/form-data" method="POST" autocomplete="off" data-ajax-type="ajax-form-modal" data-column="0" data-refresh="" data-redirect="0" data-table_id="example3" data-container_id="content-container">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-sm-12 col-xs-12 hide">
                            <label class="required" for="application_id">ID</label>
                            <input type="text" class="form-control not-empty" name="application_id" data-name="ID">
                        </div>
                        <div class="form-group col-sm-12 col-xs-12">
                            <label class="required" for="prospect">Prospecto</label>
                            <input type="text" class="form-control not-empty" disabled name="prospect" data-name="Prospecto">
                        </div>
                        <div class="form-group col-sm-12 col-xs-12">
                            <label class="required" for="comment">Comentario</label>
                            <textarea class="form-control not-empty" name="comment" data-name="Comentario"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary guardar" data-target="form-data">Guardar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade data-fill" tabindex="-1" role="dialog" aria-labelledby="label-title" id="reject-application">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="label-title">¿Por qué rechaza al prospecto?</h4>
            </div>
            <form id="form-data-2" class="valid ajax-plus" action="{{route('Crm.prospects.change_status')}}" onsubmit="return false;" enctype="multipart/form-data" method="POST" autocomplete="off" data-ajax-type="ajax-form-modal" data-column="0" data-refresh="table" data-redirect="0" data-table_id="rows" data-container_id="table-container">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-sm-12 col-xs-12 hide">
                            <label class="required" for="application_id">ID</label>
                            <input type="text" class="form-control not-empty" name="application_id" data-name="ID">
                        </div>
                        <div class="form-group col-sm-12 col-xs-12 hide">
                            <label class="required" for="status">Status</label>
                            <input type="text" class="form-control not-empty" name="status" data-name="Status">
                        </div>
                        <div class="form-group col-sm-12 col-xs-12">
                            <label class="required" for="prospect">Prospecto a rechazar</label>
                            <input type="text" class="form-control not-empty" disabled name="prospect" data-name="Prospecto">
                        </div>
                        <div class="form-group col-sm-12 col-xs-12">
                            <label class="required" for="comment">Razón</label>
                            <textarea class="form-control not-empty" name="comment" data-name="Comentario"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary guardar" data-target="form-data-2">Guardar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade data-fill" tabindex="-1" role="dialog" aria-labelledby="titulo_detalles_pedido" id="view-application-details">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title" id="titulo_detalles_pedido">Detalles prospecto</h2>
            </div>
            <div class="modal-body">
                <div class="row text-left details-content">
                    <div class="col-md-12">
                        <ul class="list-group">
                            <li class="list-group-item active">Datos generales</li>
                            <li class="list-group-item fill-container"><span class="label_show">ID Prospecto: <span class="id"></span></span></li>
                            <li class="list-group-item fill-container"><span class="label_show">Fecha de creación: <span class="created_at"></span></span></li>
                            <li class="list-group-item fill-container"><span class="label_show">Presupuesto del cliente: <span class="badget"></span></span></li>
                            <li class="list-group-item fill-container"><span class="label_show">Número de gente solicitado: <span class="num_people"></span></span></li>
                            <li class="list-group-item fill-container"><span class="label_show">Tipo de oficina: <span class="office_type"></span></span></li>
                        </ul>
                    </div>
                </div>
                <div class="row text-center load-bar">
                    <div class="col-md-12">
                        <div class="progress-outer">
                            <h5>Cargando comentarios... espere un momento</h5>
                            <span><i style="font-size: 10mm;" class="fa fa-cloud-download" aria-hidden="true"></i></span><br>
                            <div class="progress transparent progress-large progress-striped active no-radius no-margin">
                                <div data-percentage="100%" class="progress-bar progress-bar-success animate-progress-bar"></div>       
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->