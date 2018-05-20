<ul class="nav nav-tabs" role="tablist">
	<li role="presentation" class="active">
		<a href="#earnings" aria-controls="earnings" role="tab" data-toggle="tab">Ingresos</a>
	</li>
	<li role="presentation">
		<a href="#expenses" aria-controls="expenses" role="tab" data-toggle="tab">Egresos</a>
	</li>
</ul>

<div class="row-fluid text-left buttons-container">
	<a href="{{route('Erp.form')}}" class="btn btn-success add"><i class="glyphicon glyphicon-plus"></i> Nueva</a>
</div>

<div class="tab-content">
	<div role="tabpanel" class="tab-pane fade in active" id="earnings">

		@include('erp.table', ['data' => $earnings])
	</div>
	<div role="tabpanel" class="tab-pane fade" id="expenses">
		@include('erp.table', ['data' => $expenses])
	</div>
</div>