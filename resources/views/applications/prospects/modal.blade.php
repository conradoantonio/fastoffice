<div class="modal fade data-fill" tabindex="-1" role="dialog" aria-labelledby="label-title" id="modal-form">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="label-title">Detalles del pedido</h4>
            </div>
            <form id="form-data" action="{{url('services/change-status')}}" onsubmit="return false;" enctype="multipart/form-data" method="POST" autocomplete="off" data-ajax-type="ajax-form-modal" data-column="0" data-refresh="content" data-redirect="0" data-table_id="example3" data-container_id="content-container">
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
            </form>
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
            <form id="form-data" action="{{route('Crm.prospects.save_comment')}}" onsubmit="return false;" enctype="multipart/form-data" method="POST" autocomplete="off" data-ajax-type="ajax-form-modal" data-column="0" data-refresh="content" data-redirect="0" data-table_id="example3" data-container_id="content-container">
                <div class="modal-body">
                    
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-primary save">Guardar</button> --}}
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->