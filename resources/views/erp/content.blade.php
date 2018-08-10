<ul class="nav nav-tabs" role="tablist">
	<li role="presentation" class="active">
		<a href="#earnings" aria-controls="earnings" role="tab" data-toggle="tab">Ingresos</a>
	</li>
	<li role="presentation">
		<a href="#expenses_fixed" aria-controls="expenses_fixed" role="tab" data-toggle="tab">Egresos Fijos</a>
	</li>
	<li role="presentation">
		<a href="#expenses_variable" aria-controls="expenses_variable" role="tab" data-toggle="tab">Egresos Variables</a>
	</li>
</ul>

<div class="row-fluid text-left buttons-container">
	<a href="{{route('Erp.form')}}" class="btn btn-success add"><i class="glyphicon glyphicon-plus"></i> Nueva</a>
</div>

<div class="tab-content">
	<div role="tabpanel" class="tab-pane fade in active" id="earnings">

		@include('erp.table', ['data' => $earnings])
	</div>
	<div role="tabpanel" class="tab-pane fade" id="expenses_fixed">
		@include('erp.table', ['data' => $expenses_fixed])
	</div>
	<div role="tabpanel" class="tab-pane fade" id="expenses_variable">
		@include('erp.table', ['data' => $expenses_variable])
	</div>
</div>