<div class="modal fade" id="ModalExcel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Importar excel</h4>
			</div>
			<div class="modal-body">
				<form action="{{$import_url}}" method="POST" enctype="multipart/form-data" class="valid ajax" autocomplete="off" id="formInvitados">
					<div class="row">
						<div class="form-group col-md-12">
							<label for="archivo-excel" class="control-label">EXCEL</label>
							<input type="file" id="archivo-excel" name="archivo-excel" class="not-empty form-control" data-name="Excel">
						</div>

					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary guardar" data-target="formInvitados">Guardar</button>
				<button type="button" class="btn btn-default close_form" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="ModalDrop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Subir imágenes</h4>
			</div>
			<div class="modal-body">
				<div class="row-fluid dropzone" id="dropzoneDiv">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary guardar" data-target="formInvitados">Guardar</button>
				<button type="button" class="btn btn-default close_form" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>