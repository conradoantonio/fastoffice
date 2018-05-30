<div class="modal fade data-fill" tabindex="-1" role="dialog" aria-labelledby="label-title" id="view-application-comments">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="label-title">Comentarios sobre el prospecto</h4>
            </div>
            <div class="modal-body">
                <div class="row text-left hide" id="detail-fields">
                    <div class="col-md-12">
                        <ul class="list-group">
                            <li class="list-group-item active">Datos generales del servicio</li>
                        </ul>
                    </div>
                </div>
                <div class="row text-center" id="load-bar">
                    <div class="row mrg-0 col-md-12">
                        <div class="progress-outer">
                            <span><i style="font-size: 20mm;" class="fa fa-cloud-download" aria-hidden="true"></i></span><br>
                            <span>Cargando comentarios... espere un momento</span>
                            <div class="progress">
                                <div class="progress-bar progress-bar-info progress-bar-striped active" style="width:100%; box-shadow:-1px 10px 10px rgba(92, 190, 220, 0.5);"></div>
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
                        <div class="form-group col-sm-12 col-xs-12">
                            <label class="required" for="application_id">ID</label>
                            <input type="text" class="form-control not-empty" name="application_id" data-name="ID">
                        </div>
                        <div class="form-group col-sm-12 col-xs-12">
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
                <h2 class="modal-title" id="titulo_detalles_pedido">Detalles del servicio</h2>
            </div>
            <div class="modal-body">
                <div class="row text-left" id="campos_detalles">
                    <div class="col-md-12">
                        <ul class="list-group">
                            <li class="list-group-item active">Datos generales del servicio</li>
                            <li class="list-group-item fill-container"><span class="label_show">Número de orden: <span class="id"></span></span></li>
                            <li class="list-group-item fill-container"><span class="label_show">ID orden de conekta: <span class="conekta_order_id"></span></span></li>
                            {{-- <li class="list-group-item fill-container"><span class="label_show">Status: <span class="status"></span></span></li> --}}
                            <li class="list-group-item fill-container"><span class="label_show">Fecha agendado: <span class="created_at"></span></span></li>
                            <li class="list-group-item fill-container"><span class="label_show">Cliente: <span class="nombre_cliente"></span></span></li>
                            <li class="list-group-item fill-container"><span class="label_show">Cancelado por: <span class="cancelado_por"></span></span></li>
                            <li class="list-group-item fill-container"><span class="label_show">Fecha y hora de inicio del servicio: <span class="start_datetime"></span></span></li>
                            <li class="list-group-item fill-container"><span class="label_show">Fecha y hora del término del servicio: <span class="end_datetime"></span></span></li>
                            <li class="list-group-item fill-container"><span class="label_show">Puntuación a usuario: <span class="puntuacion_usuario"></span></span></li>
                            <li class="list-group-item fill-container"><span class="label_show">Puntuación a estilista: <span class="puntuacion_estilista"></span></span></li>
                            <li class="list-group-item fill-container"><span class="label_show">Comentario del servicio: <span class="comentario"></span></span></li>
                            {{-- <li class="list-group-item fill-container"><span class="label_show">Estilista: <span id="estilista_nombre_completo"></span></span></li>
                            <li class="list-group-item fill-container">
                                <span class="label_show">Foto estilista: </span>
                                <img width="300px;" src="" id="estilista_foto">
                            </li> --}}
                        </ul>

                        <ul class="list-group">
                            <li class="list-group-item active">Productos</li>
                            <li class="list-group-item">
                                <div class="table-responsive">
                                    <table id="detalles" class="table table-responsive">
                                        <thead>
                                            <th style="text-align: center;">Producto/Servicio</th>
                                            <th style="text-align: center;">Precio unitario</th>
                                            <th style="text-align: center;">Cantidad</th>
                                            <th style="text-align: center;">Subtotal</th>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </li>
                        </ul>

                        <ul class="list-group">
                            <li class="list-group-item active">Contacto</li>
                            <li class="list-group-item fill-container"><span class="label_show">ID cliente de conekta: <span class="customer_id_conekta"></span></span></li>
                            <li class="list-group-item fill-container"><span class="label_show">Cliente: <span class="nombre_cliente"></span></span></li>
                            <li class="list-group-item fill-container"><span class="label_show">Email: <span class="correo_cliente"></span></span></li>
                            <li class="list-group-item fill-container"><span class="label_show">Teléfono: <span class="telefono"></span></span></li>
                        </ul>

                        <ul class="list-group">
                            <li class="list-group-item active">Dirección</li>
                            <li class="list-group-item fill-container"><span class="label_show">Receptor: <span class="recibidor"></span></span></li>
                            <li class="list-group-item fill-container"><span class="label_show">País: <span class="pais"></span></span></li>
                            <li class="list-group-item fill-container"><span class="label_show">Estado: <span class="estado"></span></span></li>
                            <li class="list-group-item fill-container"><span class="label_show">Ciudad: <span class="ciudad"></span></span></li>
                            <li class="list-group-item fill-container"><span class="label_show">Código Postal: <span class="codigo_postal"></span></span></li>
                            <li class="list-group-item fill-container"><span class="label_show">Colonia: <span class="colonia"></span></span></li>
                            <li class="list-group-item fill-container"><span class="label_show">Calle: <span class="calle"></span></span></li>
                            <li class="list-group-item fill-container"><span class="label_show">Número interior: <span class="num_int"></span></span></li>
                            <li class="list-group-item fill-container"><span class="label_show">Número exterior: <span class="num_ext"></span></span></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->