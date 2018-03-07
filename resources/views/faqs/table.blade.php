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
			<th>Pregunta</th>
			<th>Estatus</th>
			<th>Acciones</th>
		</thead>
		<tbody>
			@foreach($faqs as $faq)
				<tr>
					<td class="hide">{{$faq->id}}</td>
					<td>
						<div class="checkbox check-success">
							<input id="checkbox{{$faq->id}}" class="multiple-delete" type="checkbox" value="{{$faq->id}}">
							<label for="checkbox{{$faq->id}}"></label>
						</div>
					</td>
					<td>{{$faq->question}}</td>
					<td>
						@if($faq->status)
						<span class="label label-success status" data-url="{{route('Faq.status', $faq->id)}}" data-toggle="tooltip" data-placement="top" title="Cambiar status">Activo</span>
						@else
						<span class="label label-danger status" data-url="{{route('Faq.status', $faq->id)}}" data-toggle="tooltip" data-placement="top" title="Cambiar status">Inactivo</span>
						@endif
					</td>
					<td>
						<a class="btn btn-xs btn-mini btn-primary" href="{{route('Faq.form', $faq->id)}}" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil"></i></a>
						<a href="{{route('Faq.destroy', $faq->id)}}" class="btn btn-xs btn-mini btn-danger delete_row" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fa fa-trash"></i></a>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>
