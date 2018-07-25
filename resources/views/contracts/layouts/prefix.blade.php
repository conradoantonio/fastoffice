<p class="break bold center">CONTRATO DE PRESTACIÓN DE SERVICIOS</p>
<br>
<p class="break justify uppercase">
	EN EL MUNICIPIO DE {{$contract->office->municipality->name}} {{$contract->office->state->name}} A LOS {{strftime('%d', strtotime($contract->contract_date))}} DÍAS DEL MES DE {{strftime('%B', strtotime($contract->contract_date))}} DEL AÑO {{strftime('%Y', strtotime($contract->contract_date))}} COMPARECIERON ANTE LOS TESTIGOS QUE AL FINAL SE SUSCRIBEN, 
	POR UNA PARTE, 
	@if($contract->office->branch->user->regime == 'Persona moral')
		<span class="bold">FAST OFFICE & BENS S.A. DE C.V.</span> A QUIEN EN LO SUCESIVO SE LE DENOMINARÁ <span class="bold">“EL PRESTADOR”</span> REPRESENTADA POR <span class="bold">{{$contract->office->branch->user->fullname}}</span>
	@else
		<span class="bold">{{$contract->office->branch->user->fullname}}</span> A QUIEN EN LO SUCESIVO SE LE DENOMINARÁ <span class="bold">“EL PRESTADOR”</span>
	@endif

	&nbsp;Y POR LA OTRA PARTE 
	
	@if($contract->customer->regime == 'Persona moral')
		<span class="bold">{{$contract->customer_company}}</span> REPRESENTADA POR <span class="bold">{{$contract->customer->fullname}}</span> A QUIEN EN LO SUCESIVO SE LE DENOMINARÁ <span class="bold">“EL CLIENTE”</span>
	@else
		<span class="bold">{{$contract->customer->fullname}}</span> A QUIEN EN LO SUCESIVO SE LE DENOMINARÁ <span class="bold">“EL CLIENTE”</span> 
	@endif
	&nbsp;AL TENOR DE LAS SIGUIENTES DECLARACIONES Y CLÁUSULAS:
</p>