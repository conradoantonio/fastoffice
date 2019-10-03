<html>
	<head></head>
	<body>
		<div style="text-align: justify; padding: 2% 10%;background: whitesmoke;">
			<h1 style="margin-top: 0px;">{{$title}}</h1>
			<p style="margin-bottom: 0px;">{{$content['message']}}</p>
			<ul>
				<li><strong>Correo:</strong> {{$content['email']}}</li>
				<li><strong>Contraseña:</strong> {{$content['password']}}</li>
			</ul>
		</div>
		<div>
			<a href="https://fastoffice.mx/" target="_blank"><img src="{{asset('img/mail/cintillo.jpeg')}}" style='width: 100%;'></a>
		</div>
		<div style="text-align:center; background:#3d3d3d; font-size:15px; font-weight:900; padding:6px 0px; color: floralwhite">
			<span>Desarrollado por Bridge Studio</span>
		</div>
	</body>
</html>