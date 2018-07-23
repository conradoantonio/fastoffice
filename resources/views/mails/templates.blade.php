<html>
	<head></head>
	<body>
		<div>
			<!-- Cambiar el nombre del header -->
			<img src="{{asset('img/mail/mailheader.png')}}" style='width: 100%;'>
		</div>
		<div style="text-align: justify; padding: 2% 10%;background: whitesmoke;">
			<h1 style="margin-top: 0px;">{{$title}}</h1>
			<p>{{$content['message']}}</p>
			@if( $content['attachments'] )
				<div >
					@foreach( $content['attachments'] as $attachment )
						@if( strpos($attachment->path, 'pdf' ) || strpos($attachment->path, 'PDF' ) )
							<span style="display: none">{{$message->embed(asset($attachment->path))}}</span>
						@else
						<img src="{{ $message->embed(asset($attachment->path)) }}" style="width: 25% !important;">
						@endif
					@endforeach
				</div>
			@endif
		</div>
		<div style="text-align:center; background:#8035A0; font-size:15px; font-weight:900; padding:6px 0px; color: floralwhite">
			<span>Desarrollado por Bridge Studio</span>
		</div>
	</body>
</html>