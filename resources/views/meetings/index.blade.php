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
		@include('helpers.filters', ['index_url' => route('Meeting'), 'export_url' => null, 'dates' => true])
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
		var calendar = $('#calendar').find('div').first();

		$( document ).delegate('.proccess', 'click', function(){
			var sentence = '',
				val = 0,
				url = '',
				id = 0,
				ele = $(this);
			if ( $(this).hasClass('btn-info') ){
				sentence = 'Completa';
				val = 1;
			} else {
				sentence = 'Incompleta'
				val = 2;
			}

			url = $(this).data('url');
			id = $(this).data('id');

			swal({
				title: '¿Quieres marcar como '+sentence+' esta solicitud?',
				icon: 'warning',
				buttons:["Cancelar", "Aceptar"],
				dangerMode: false,
			}).then((accept) => {
				if (accept){
					$.ajax({
						url: url,
						type:"PATCH",
						data:{
							id:id,
							val:val
						},
						beforeSend:function(){
							loadAnimation()
						},
						success:function(response){
							if (response.status){
								swal("Se ha modificado el estatus","","success");
								if ( val == 1 ){
									ele.parent().parent().find('.progress-val').removeClass('label-warning, label-danger').addClass('label-success').text('Completa')
								} else{
									ele.parent().parent().find('.progress-val').removeClass('label-warning, label-success').addClass('label-danger').text('Incompleta')
								}
							} else {
								swal("Ha ocurrido un error","","error");
							}
						}
					})
				}
			})
		})

		$( document ).ajaxComplete(function( event, xhr, settings ) {
			if ( settings.type === "GET" && settings.url.includes('/reuniones') ) {
				$(".fc-today-button").click()
				fillCalendar();
			}
		});

		$(document).delegate('#tab_calendar', 'click', function (e) {
			$(".fc-today-button").click()
			fillCalendar();
		})

		function fillCalendar(){
			var b_url = $('meta[name=base-url]').attr('content');
			var dest =  "/obtener-calendario";
			if ( typeof url !== 'undefined' ){
				dest = "/obtener-calendario" + url;
			}
			calendar.fullCalendar('removeEvents');
			$.ajax({
				url: b_url+'/'+dest,
				method: "GET",
				type: "GET",
				beforeSend:function(){
					loadAnimation('Refrescando reuniones');
				},
				success:function(events){
					swal.close();
					var ev =  [];
					$.each(events, function(){
						var array = [];
						array.title = this.title;
						array.start = this.start.date;
						array.end = this.end.date;
						array.isAllDay = false;
						array.color = "#1e671d";

						ev.push(array);
					});

					calendar.fullCalendar('addEventSource', ev);
					calendar.fullCalendar('refetchEvents');
				}
			});
		}
	</script>
@endpush
@endsection
