<p class="break bold center">DECLARACIONES:</p>
<p class="break justify">I.<span class="white-space-5">DECLARA “EL PRESTADOR”</span></p>
@if($contract->office->branch->user->regime == 'Persona moral')
	<ul class="b-up-alpha justify">
		<li class="one-line-sp">Es una empresa legalmente constituida de conformidad con las leyes mexicanas como lo demuestra con la escritura de su acta constitutiva número {{$contract->provider_act_number}} otorgada ante la fe del notario público número {{$contract->provider_notary_number}} del estado de {{$contract->provider_notary_state->name}} el Lic. {{$contract->provider_notary_name}}.</li>
		<li class="one-line-sp">Que se encuentra autorizado para disponer del bien inmueble para oficinas de representación comercial que se ubica en {{$contract->office->address}} en {{$contract->office->municipality->name}} {{$contract->office->state->name}}.</li>
		<li class="one-line-sp">Que señala como domicilio para efectos de este contrato, el ubicado en el domicilio de {{$contract->provider_address}}</li>
		<li class="one-line-sp">Que tiene como registro federal de contribuyentes: FOA1411107KA</li>
	</ul>
@else
	<ul class="b-up-alpha justify">
		<li class="one-line-sp">Es una persona física con actividad empresarial, mayor de edad con facultad para suscribir el presente instrumento y que representa en este acto para identificarse con la credencial del Instituto Federal Electoral número {{$contract->provider_ine_number}}.</li>
		<li class="one-line-sp">Que se encuentra autorizado para disponer del bien inmueble para oficinas de representación comercial que se ubica en {{$contract->office->address}} en <span class="capitalize">{{$contract->office->municipality->name}} {{$contract->office->state->name}}</span></li>
		<li class="one-line-sp">Que señala como domicilio para efectos de este contrato, el ubicado en el domicilio de {{$contract->provider_address}}</li>
		<li class="one-line-sp">Que tiene como registro federal de contribuyentes: {{$contract->office->branch->user->rfc}}</li>
	</ul>
@endif

<br>
<p class="break justify">II.<span class="white-space-5">DECLARA “EL CLIENTE”</span></p>
@if($contract->customer->regime == 'Persona moral')
	<ul class="b-up-alpha justify">
		<li class="one-line-sp">Que es una empresa legalmente constituida de conformidad con las leyes mexicanas como lo demuestra con la escritura de su acta constitutiva número {{$contract->customer_act_number}} otorgada ante la fe del notario público número {{$contract->customer_notary_number}} del estado de {{$contract->customer_notary_state->name}} el Lic. {{$contract->customer_notary_name}}</li>
		<li class="one-line-sp">Que {{$contract->customer->fullname}} tiene facultades para suscribir el presente instrumento de conformidad con la escritura {{$contract->customer_deed_number}} de fecha {{strftime('%d', strtotime($contract->customer_deed_date))}} de {{strftime('%B', strtotime($contract->customer_deed_date))}} del año {{strftime('%Y', strtotime($contract->customer_deed_date))}} otorgada ante la fe del notario público número {{$contract->customer_notary_number}} del estado de {{$contract->customer_notary_state->name}}.</li>
		<li class="one-line-sp">Que dentro de su objetivo social se encuentra el de {{$contract->customer_social_object}}</li>
		<li class="one-line-sp">Que señala como domicilio para efectos de este contrato, el ubicado en {{$contract->customer_address}}.</li>
		<li class="one-line-sp">Que tiene como registro federal de contribuyentes: {{$contract->customer->rfc}}.</li>
	</ul>
@else
	<ul class="b-up-alpha justify">
		<li class="one-line-sp">Que es una persona física con actividad empresarial, mayor de edad, con facultad para suscribir el presente instrumento y que presenta en este acto para identificarse la credencial del instituto federal electoral con número {{$contract->customer_ine_number}}</li>
		<li class="one-line-sp">Que su primordial actividad es la siguiente: {{$contract->customer_activity}}.</li>
		<li class="one-line-sp">Que señala como domicilio para efectos de este contrato, el ubicado en {{$contract->customer_address}}</span>.</li>
		<li class="one-line-sp">Que tiene como registro federal de contribuyentes: {{$contract->customer->rfc}}.</li>
	</ul>
@endif

<div class="new-page"></div>

<br><br>
<p class="break justify">III.<span class="white-space-4">DECLARAN AMBAS PARTES</span></p>
<ul class="no-style justify">
	<li>Que en atención a lo expuesto están conformes en sujetar su compromiso a los términos del presente contrato y a las siguientes condiciones:</li>
</ul>
<p class="break bold center">OBJETO</p>
<ul class="b-up-alpha justify">
	<li class="one-line-sp">Este contrato tiene por objeto la prestación de servicios establecidos en el cuerpo del presente contrato en favor de “EL CLIENTE” a cambio de una contraprestación por dichos servicios, tal y como se especifica en las siguientes:</li>
</ul>
