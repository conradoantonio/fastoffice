<ul class="nav nav-tabs" role="tablist">
	<li role="presentation" class="active" id="tab_calendar">
		<a href="#calendar" aria-controls="calendar" role="tab" data-toggle="tab">Calendario</a>
	</li>
	<li role="presentation">
		<a href="#table" aria-controls="table" role="tab" data-toggle="tab">Solicitudes</a>
	</li>
</ul>

<div class="tab-content">
	<div role="tabpanel" class="tab-pane fade in active" id="calendar">
		@include('meetings.calendar')
	</div>
	<div role="tabpanel" class="tab-pane fade" id="table">
		<div class="row-fluid text-left buttons-container">
			<a href="{{route('Meeting.form')}}" class="btn btn-success add"><i class="glyphicon glyphicon-plus"></i> Nueva solicitud</a>
			<a href="{{route('Meeting.multipleDestroys')}}" class="btn btn-danger multiple-delete-btn disabled" disabled><i class="glyphicon glyphicon-trash"></i> Eliminar multiple</a>
		</div>
		@include('meetings.table')
	</div>
</div>