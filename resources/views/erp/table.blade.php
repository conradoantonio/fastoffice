<div class="table-responsive">
	<table class="table table-hover table-condense datatable">
		<thead>
			<th class="hide">ID</th>
			<th>
				<div class="checkbox check-success 	">
					<input id="checkboxParent" type="checkbox">
					<label for="checkboxParent"></label>
				</div>
			</th>
			<th>Concepto</th>
			<th>Cantidad</th>
			<th>Acciones</th>
		</thead>
		<tbody>
			@foreach($data as $d)
				<tr>
					<td class="hide">{{$d->id}}</td>
					<td>
						<div class="checkbox check-success">
							<input id="checkbox{{$d->id}}" class="multiple-delete" type="checkbox" value="{{$d->id}}">
							<label for="checkbox{{$d->id}}"></label>
						</div>
					</td>
					<td>{{$d->concept}}</td>
					<td>{{$d->amount}}</td>
					<td>
						<a class="btn btn-xs btn-mini btn-primary" href="{{route('Erp.form', $d->id)}}" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil"></i></a>
						<a href="{{route('Erp.destroy',$d->id) }}" class="btn btn-xs btn-mini btn-danger delete_row" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fa fa-trash"></i></a>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>