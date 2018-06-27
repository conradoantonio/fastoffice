<!DOCTYPE html>
<html>
<head>
	<title>Concepto de pago</title>
	<link rel="stylesheet" type="text/css" href="{{asset('css/pdf.css')}}">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
	<style>
	.color{
		background-color: gray;
		font-weight: bold;
	}
	.none{
		background-color:none;
	}
	td, th{
		padding: 1px!important;
	}
	.firma {
		text-align: center;
    	display: inline-block;
		width: 300px;
	    height: 40px;
	    margin: 5px;
	}
	.firmas {
		width: 700px;
	}

	</style>
</head>

<body>
	<div class="row">
	 	<div class="centrar">
			<img class="img-logo" src="{{asset('img/login_logo.png')}}" alt="company-logo">
		</div>
	</div>
	<div class="row">
		<div class="">
			<div class="col-sm-12 col-xs-12">
                <div class="alert alert- alert-dismissible justify" role="alert">
                    Recibo por concepto de servicios al ArtLook <strong>{{$estilista->usuario->nombre.' '.$estilista->usuario->apellido}}</strong>, con fecha inicial del día
					{{date('d/M/Y', strtotime($fecha_inicio))}} al {{date('d/M/Y', strtotime($fecha_fin))}}, por la cantidad de ${{$total}} mxn, 
					quedando saldadas las cuentas a la fecha anteriormente mencionada. <br>
					A continuación se enlistan los servicios brindados por el Artlook:
                </div>
            </div>
		</div>
	</div>
	<br>
	<table class="table">
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
	</table>
	<br>

	<div class="containter firmas">
		<div class="col-md-6 firma">
			____________________________<br>	
			Eduardo Ascencio Santana
		</div>
		<div class="col-md-6 firma">
			____________________________<br>
			{{$estilista->usuario->nombre.' '.$estilista->usuario->apellido}}
		</div>
	</div>
</body>
</html>

