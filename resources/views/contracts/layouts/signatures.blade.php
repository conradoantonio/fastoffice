<p class="break justify">Leído el presente contrato y enteradas las partes de su contenido y alcances, lo firman de conformidad.</p>
<br><br>
<p class="break right">{{$contract->office->municipality->name}}, {{$contract->office->state->name}} a {{ucwords(strftime('%d %B %Y', strtotime($contract->contract_date)))}}</p>

<br><br><br>
<div class="signature uppercase">
	<span class="bold">"EL PRESTADOR"</span>
	<br><br><br>
	_______________________________<br>
    <span>{{$contract->office->branch->user->fullname}} <br><span class="bold">{{($contract->office->branch->user->regime == 'Persona moral' ? 'FAST OFFICE & BENS, S.A DE C.V.' : '')}}</span></span>
</div>
<div class="signature uppercase">
	<span class="bold">"EL CLIENTE"</span>
	<br><br><br>
	_______________________________<br>
	<span class="">{{$contract->customer->fullname}} <br><span class="bold">{{$contract->customer_company}}</span></span>
</div>

<br><br><br><br><br>
<p class="break center bold">Testigos</p>
<br><br><br>
<div class="signature">
	_______________________________
</div>
<div class="signature">
	_______________________________
</div>