@extends('layouts.main')
@section('pageTitle', 'Calendario')
@section('content')
<div class="container-fluid content-body">
	@if(session('msg'))
	<div class="alert alert-success">
		{{session('msg')}}
	</div>
	@endif
	<div class="page-title">
		<h1><span class="semi-bold">Calendario</span></h1>
	</div>
	<div class="row-fluid">
		<div id="body-content">
			@include('meetings.content')
		</div>
	</div>
</div>
@push('links')
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
@endpush
@push('scripts')
	<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
	<script type="text/javascript">
		var calendar = $('#calendar').find('div').first().attr('id');

		$( document ).ajaxComplete(function() {
			//$("#"+calendar).fullCalendar('removeEvents');
			$(".fc-today-button").click()
			$("#"+calendar).fullCalendar( 'refresh' );

			$.ajax({
				url:"/obtener-calendario",
				method: "GET",
				type: "GET",
				success:function(events){
					$("#"+calendar).fullCalendar( 'updateEvents', events )
				}
			});
		});
	</script>
@endpush
@endsection
