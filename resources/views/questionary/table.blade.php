<table class="table table-hover table-condense datatable" id="rows">
	<thead>
		<th class="hide">ID</th>
		<th class="hide">
			<div class="checkbox check-success">
				<input id="checkboxParent" type="checkbox">
				<label for="checkboxParent"></label>
			</div>
		</th>
		<th>Pregunta</th>
		<th>Categoría</th>
		<th>Acciones</th>
	</thead>
	<tbody>
		@foreach($questions as $question)
			<tr>
				<td class="hide">{{$question->id}}</td>
				<td class="hide">
					<div class="checkbox check-success">
						<input id="checkbox{{$question->id}}" class="multiple-delete" type="checkbox" value="{{$question->id}}">
						<label for="checkbox{{$question->id}}"></label>
					</div>
				</td>
				<td>{{$question->question}}</td>
				<td>{{$question->category->name}}</td>
				<td>
					<a href="{{route('Questionary.form', $question->id)}}" class="btn btn-xs btn-mini btn-edit edit-row" data-toggle="tooltip" data-parent-id="{{$question->id}}" data-placement="top" title="Editar"><i class="fa fa-pencil"></i></a>
					<a href="javascript:;" class="btn btn-xs btn-mini btn-danger delete-row" data-toggle="tooltip" data-parent-id="{{$question->id}}" data-placement="top" title="Eliminar pregunta"><i class="fa fa-trash"></i></a>
				</td>
			</tr>
		@endforeach
	</tbody>
</table>
