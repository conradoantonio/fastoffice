<!DOCTYPE html>
<html>
<head>
	<title>Contrato</title>
	<link rel="stylesheet" type="text/css" href="{{asset('css/pdf.css')}}">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
	<style>
	
	</style>
</head>

<body>
	<div class="fixed-top-left">
		<img class="logo" src="{{asset('img/fa_of_logo.png')}}">
	</div>
	<div class="start">
		<p class="break bold">CONTRATO DE PRESTACIÓN DE SERVICIOS</p>
		<br>
		<p class="break">
			EN EL MUNICIPIO DE ZAPOPAN JALISCO A LOS 15 DIAS DEL MES DE ENERO DEL AÑO 2018 COMPARECIERON ANTE LOS TESTIGOS QUE AL FINAL SE SUSCRIBEN, 
			POR UNA PARTE, JACQUELINE GARCIA GUTIERREZ A QUIEN EN LO SUCESIVO SE LE DENOMINARÁ “EL PRESTADOR” Y POR LA OTRA PARTE XXXXXXXXXXXXXXXXXXXXX 
			A QUIEN EN LO SUCESIVO SE LE DENOMINARÁ “EL CLIENTE” AL TENOR DE LAS SIGUIENTES DECLARACIONES Y CLÁUSULAS
		</p>
	</div>
	{{-- <div class="row">
	 	<div class="centrar">
			<img class="img-logo" src="{{asset('img/login_logo.png')}}" alt="company-logo">
		</div>
	</div> --}}
	
	<br>
	{{-- <table class="table">
		<thead class="thead-light">
			<tr>
				<th>Servicio</th>
				<th>Cantidad</th>
				<th>Fecha</th>
			</tr>
		</thead>
		<tbody>
			@if(isset($estilista->servicios))
	            @foreach($estilista->servicios as $servicio)
	            	@foreach($servicio->detalles as $detalle)
		            	<tr>
							<td>{{$detalle->nombre}}</td>
							<td>{{$detalle->cantidad}}</td>
							<td>{{date('d/M/Y', strtotime($servicio->start_datetime))}}</td>
						</tr>
	            	@endforeach
				@endforeach
			@else
				<tr>
					<td colspan="3">No hay servicios por pagar</td>
				</tr>
			@endif
		</tbody>
	</table> --}}
	<br>
</body>
</html>

