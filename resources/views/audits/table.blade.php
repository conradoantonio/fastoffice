<div class="table-responsive">
	<table class="table table-hover table-condense datatable">
		<thead>
			<th class="hide">ID</th>
			<th>Titulo</th>
			<th>Oficina</th>
			<th>Auditor</th>
			<th>Acciones</th>
		</thead>
		<tbody>
			@foreach($audits as $audit)
				<tr>
					<td class="hide">{{$audit->id}}</td>
					<td>{{$audit->title}}</td>
					<td>{{$audit->office->name}}</td>
					<td>{{$audit->user->fullname}}</td>
					<td>
						<a class="btn btn-xs btn-mini btn-info" href="{{route('Audit.show', $audit->id)}}"><i class="fa fa-eye"></i></a>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>