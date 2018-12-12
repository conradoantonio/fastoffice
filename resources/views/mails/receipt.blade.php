<html>
	<head></head>
	<body>
		<div>
			<!-- Cambiar el nombre del header -->
			<img src="{{asset('img/mail/mailheader.jpg')}}" style='width: 100%;'>
		</div>
		<div style="text-align: justify; padding: 2% 10%;background: whitesmoke;">
			<h1 style="margin-top: 0px;">{{$title}}</h1>
			<div style='text-align:center;width: 50%;margin: auto;'>
				@if(@$content['order_id'])
					<div style='margin-bottom:2%'>
						<span style='display: block;font-weight: 900;'>Orden:</span> {{$content['order_id']}}
					</div>
				@endif
				<div style='margin-bottom:2%'>
					<span style='display: block;font-weight: 900;'>Método de pago:</span> Tarjeta {{$content['card']}}
				</div>
				<div style='margin-bottom:2%'>
					<span style='display: block;font-weight: 900;'>Cliente: </span>{{$content['user']}}
				</div>
				<table style='width: 100%;'>
					<thead>
						<th style='border-bottom: 1px solid #ddd;padding: 1%;'>Artículos</th>
						<th style='border-bottom: 1px solid #ddd;padding: 1%;'>Usos</th>
						<th style='border-bottom: 1px solid #ddd;padding: 1%;'>Precio</th>
					</thead>
					<tbody>
						@foreach( $content['list'] as $item )
							<tr>
								<td style='border-bottom: 1px solid #ddd;padding: 1%;'>{{$item['name']}}</td>
								<td style='border-bottom: 1px solid #ddd;padding: 1%;'>{{$item['uses']}}</td>
								<td style='border-bottom: 1px solid #ddd;padding: 1%;'>${{$item['subtotal']}}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
				@if(@$content['next_payment'])
					<div style='margin-top: 6%;font-size: 0.9em;'>
						<span>El próximo cobro se realizará el {{$content['next_payment']}}</span>
					</div>
				@endif
			</div>
		</div>
		<div style="text-align:center; background:#3d3d3d; font-size:15px; font-weight:900; padding:6px 0px; color: floralwhite">
			<span>Desarrollado por Bridge Studio</span>
		</div>
	</body>
</html>