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
	<div class="start-page">
		<p class="break bold center">CONTRATO DE PRESTACIÓN DE SERVICIOS</p>
		<br>
		<p class="break justify uppercase">
			EN EL MUNICIPIO DE {{$contract->office->municipality->name}} {{$contract->office->state->name}} A LOS {{strftime('%d', strtotime($contract->contract_date))}} DIAS DEL MES DE {{strftime('%B', strtotime($contract->contract_date))}} DEL AÑO {{strftime('%Y', strtotime($contract->contract_date))}} COMPARECIERON ANTE LOS TESTIGOS QUE AL FINAL SE SUSCRIBEN, 
			POR UNA PARTE, <span class="bold">{{$contract->office->branch->user->fullname}}</span> A QUIEN EN LO SUCESIVO SE LE DENOMINARÁ <span class="bold">“EL PRESTADOR”</span> Y POR LA OTRA PARTE <span class="bold">{{$contract->customer->fullname}}</span>
			A QUIEN EN LO SUCESIVO SE LE DENOMINARÁ <span class="bold">“EL CLIENTE”</span> AL TENOR DE LAS SIGUIENTES DECLARACIONES Y CLÁUSULAS:
		</p>
		<br>
		<p class="break bold center">DECLARACIONES:</p>
		<br>
		<p class="break justify">I.<span class="white-space-5">DECLARA “EL PRESTADOR”</span></p>
		<ul class="b-up-alpha justify">
			<li class="one-line-sp">Es una persona física con actividad empresarial, mayor de edad con facultad para suscribir el presente instrumento y que representa en este acto para identificarse con la credencial del Instituto Federal Electoral número {{$contract->provider_ine_number}}.</li>
			<li class="one-line-sp">Que se encuentra autorizado para disponer del bien inmueble para oficinas de representación comercial que se ubica en {{$contract->office->address}} en <span class="capitalize">{{$contract->office->municipality->name}} {{$contract->office->state->name}}</span></li>
			<li class="one-line-sp">Que señala como domicilio para efectos de este contrato, el ubicado en el domicilio de {{$contract->office->address}}</li>
			<li class="one-line-sp">Que tiene como registro federal de contribuyentes: {{$contract->office->branch->user->rfc}}</li>
		</ul>

		<br>
		<p class="break justify">II.<span class="white-space-5">DECLARA “EL CLIENTE”</span></p>
		<ul class="b-up-alpha justify">
			<li class="one-line-sp">Que es una persona física con actividad empresarial, mayor de edad, con facultad para suscribir el presente instrumento y que presenta en este acto para identificarse la credencial del instituto federal electoral con número {{$contract->customer_ine_number}}</li>
			<li class="one-line-sp">Que su primordial actividad es la siguiente: {{$contract->customer_activity}}.</li>
			<li class="one-line-sp">Que señala como domicilio para efectos de este contrato, el ubicado en {{$contract->office->address}} <span class="capitalize">{{$contract->office->municipality->name}} {{$contract->office->state->name}}</span>.</li>
			<li class="one-line-sp">Que tiene como registro federal de contribuyentes: {{$contract->customer_ine_number}}.</li>
		</ul>

		<div class="new-page"></div>

		<br><br><br>
		<p class="break justify">III.<span class="white-space-4">DECLARAN AMBAS PARTES</span></p>
		<ul class="no-style justify">
			<li>Que en atención a lo expuesto están conformes en sujetar su compromiso a los términos del presente contrato y a las siguientes condiciones:</li>
		</ul>
		<p class="break bold center">OBJETO</p>
		<ul class="b-up-alpha justify">
			<li class="one-line-sp">Este contrato tiene por objeto la prestación de servicios establecidos en el cuerpo del presente contrato en favor de “EL CLIENTE” a cambio de una contraprestación por dichos servicios, tal y como se especifica en las siguientes:</li>
		</ul>

		<br>
		<p class="bold center">CLÁUSULAS</p>
		<p class="break justify bold">1. Duración:</p>
		<ul class="b-up-alpha less-li-he justify">
			<li class="one-line-sp">Este contrato inicia su vigencia el día {{strftime('%d', strtotime($contract->start_date_validity))}} de {{strtoupper(strftime('%B', strtotime($contract->start_date_validity)))}} del {{strftime('%Y', strtotime($contract->start_date_validity))}} y finaliza el {{strftime('%d', strtotime($contract->end_date_validity))}} de {{strtoupper(strftime('%B', strtotime($contract->end_date_validity)))}} del {{strftime('%Y', strtotime($contract->end_date_validity))}}.</li>
			<li class="one-line-sp">En caso de que “EL CLIENTE” quisiere renovar el presente contrato deberá de dar aviso cuando al menos 60 días anteriores a la fecha de terminación del contrato y deberá de haber cumplido cabalmente con cada una de sus obligaciones establecidas en el presente contrato, además de que se deberá de realizar y formar un nuevo contrato. “EL CLIENTE” tiene conocimiento que estará sujeto a cumplir cualquier otra obligación que “EL PRESTADOR” le estipule en su nuevo contrato.</li>
			<li class="one-line-sp">“EL CLIENTE” acepta que, en caso de no desear la renovación de su contrato, deberá dar aviso por escrito a “EL PRESTADOR” por lo menos 30 días antes del vencimiento de su contrato vigente, de lo contrario, “EL PRESTADOR” tendrá la libertad de aplicar la penalización correspondiente.</li>
			<li class="one-line-sp">Las partes convienen que, al término de la vigencia de este contrato, “EL CLIENTE” sin necesidad de intervención judicial, se obliga a entregar a “EL PRESTADOR” la oficina en las mismas condiciones en que la recibió. si existieran reparaciones mayores al momento de la desocupación, “EL PRESTADOR” las realizará y presentará la factura correspondiente a “EL CLIENTE”, quien se obliga a cubrirla (s) en su totalidad.</li>
		</ul>

		<br>
		<p class="break justify bold">2. Contraprestaciones:</p>
		<ul class="b-up-alpha less-li-he justify">
			<li class="one-line-sp">“EL CLIENTE” se obliga a pagar a “EL PRESTADOR” por concepto de prestación de servicios de este contrato y validando la promoción de pronto pago la cantidad mensual de ${{$contract->office->price}} ({{$contract->monthly_payment_str}}) más IVA al valor agregado la cual será válida realizando el pago el día puntual de la fecha de contratación entre el día {{$contract->payment_range_start}} y {{$contract->payment_range_end}} de cada mes.</li>
			<li class="one-line-sp">En caso de pagar días posteriores a la fecha estipulada EL CLIENTE se obliga a pagar la cantidad de    ${{$contract->office->price * 1.10}} ({{$contract->monthly_payment_str}}) más IVA al valor agregado “EL PRESTADOR” o a quien su derecho represente en la oficina ubicada en la misma dirección. Aumentando anualmente según el índice nacional de precios al consumidor. Dicha cantidad incluye el uso de los servicios mencionados en el inciso “A-1, A-3, A-4, A-5, A-6 A-8,” de este contrato. Dichos servicios estarán disponibles para “EL CLIENTE” únicamente dentro de los horarios estipulados por “EL PRESTADOR” y conforme a las condiciones de este contrato. (Ver cláusula de pago)</li>
			
			<div class="new-page"></div>
			<br><br>
			<li class="one-line-sp">En caso de no cumplir con el pago 15 días posteriores a la fecha estipulada será negada la entrada a la oficina y se cambiará clave de alarma.</li>
		</ul>

		<br>
		<p class="break justify bold">3. Obligaciones de EL PRESTADOR de servicios:</p>
		<ul class="b-up-alpha less-li-he justify">
			<li class="one-line-sp">De los servicios en general:
				<ul class="no-style no-padding no-margin">
					<li>“EL PRESTADOR” se obliga a mantener disponibles para “EL CLIENTE” los servicios siguientes:</li>
					<li><br></li>
					<li>A-1) oficina amueblada para {{$contract->office->num_people}} personas. </li>
					<li>A-2) cada persona adicional tiene un costo de $ 580.00 pesos </li>
					<li>A-3) servicios de energía eléctrica, agua potable, limpieza.</li>
					<li>A-4) recepción de llamadas, mensajes, correspondencia en horario de (lunes a viernes de 9:00 am a 3:00 pm – 4:00 pm a 7:00 pm y sábados 9:00 am a 2:00 pm)</li>
					<li>A-5) sala de juntas ilimitada, previa reservación. (Ver anexo de políticas de sala de juntas)</li>
					<li>A-6) estación de café</li>
					<li>A-7) mensajería (costos por paquete de acuerdo a la compañía)</li>
					<li>A-8) internet inalámbrico</li>
					<li>A-9) servicio de impresora, copiadora (costo adicional)</li>
					<li><br></li>
					<li>Cada uno de los anteriores puntos es un servicio prestado por “EL PRESTADOR” de acuerdo al objeto de este contrato.</li>
				</ul>
			</li>
			<li class="one-line-sp">“EL PRESTADOR” otorga en prestación de servicios la oficina ubicada en {{$contract->office->address}} en {{$contract->office->municipality->name.' '.$contract->office->state->name}}.</li>
			<li class="one-line-sp">El personal que labora para “EL PRESTADOR”, recibirá la correspondencia de “EL CLIENTE” cuando éste se lo solicite. la entrega se hará de forma responsable cuando “EL CLIENTE” recoja oportunamente (previo aviso del personal) su correspondencia.</li>
			<li class="one-line-sp">El servicio de prestación de servicios de oficina, se prestará únicamente a “EL CLIENTE” contratante.</li>
			<li class="one-line-sp">El personal que labora para “EL PRESTADOR”, recibirá la correspondencia de “EL CLIENTE” cuando éste se lo solicite. la entrega se hará de forma responsable cuando “EL CLIENTE” recoja oportunamente (previo aviso del personal) su correspondencia.</li>
			<li class="one-line-sp">“EL PRESTADOR” no recibirá ningún paquete superior a 4,5 kg. (10 libras) de peso, 46 cm (18 pulgadas) de cualquier dimensión, 0,03 metros cúbicos (1 pie cubico) del volumen o si contiene cualquier mercaderías peligrosas, vivas o perecederas y EL PRESTADOR tendrá derecho, a su absoluta discreción, para devolver cualquier paquete o negarse a aceptar cualquier cantidad de paquetes que considere irrazonable o ilegal. paquetes de mayor tamaño solo serán aceptados por mutuo acuerdo previo. EL PRESTADOR no garantiza ni asume responsabilidad por cualquiera de los servicios proporcionados.</li>
			<li class="one-line-sp">EL PRESTADOR se reserva el derecho de suspender inmediatamente los servicios y/o rescindir el contrato si determina que la instalación o la dirección se utiliza en relación con una posible actividad fraudulenta o actividad que pueda constituir una violación de las leyes o regulaciones gubernamentales.</li>
			<li class="one-line-sp">“EL PRESTADOR” no se hace responsable por robo total o parcial de los artículos, pertenencias, equipo de cómputo, electrónico, así como dinero en efectivo, papeles, cheques dentro de la oficina del “EL CLIENTE”, áreas comunes o cualquier dentro de las instalaciones dentro del domicilio en el que se presta el servicio.</li>
			
			<div class="new-page"></div>
			
			<br><br>
			<li class="one-line-sp">“Horario de prestación de servicios”:
				<ul class="no-style no-padding no-margin">
					<li><br></li>
					<li>“EL PRESTADOR” brindará los servicios mencionados en este contrato únicamente en el horario y dentro de sus instalaciones, de lunes a viernes de 9:00 am a 3:00 pm y de 4:00 a 7:00 pm y sábados de 9:00 am a 2:00 pm, salvo los días siguientes:</li>
					<li><br></li>
					<li>
						<ul class="b-up-disc">
							<li>Enero 1</li>
							<li>Primer lunes de febrero (conmemoración al 5 de febrero)</li>
							<li>Tercer lunes de marzo (conmemoración al 21 de marzo)</li>
							<li>Jueves, viernes y sábado (semana santa)</li>
							<li>Mayo 1</li>
							<li>Septiembre 16</li>
							<li>Tercer lunes de noviembre (conmemoración al 20 de noviembre)</li>
							<li>Diciembre 25</li>
							<li>Cualquier otro día que marque excepcional el “dos” (diario oficial de la federación) o la legislatura del estado de Jalisco.</li>
						</ul>
					</li>
				</ul>
			</li>
		</ul>

		<br>
		<p class="break justify bold">4. Obligaciones de “EL CLIENTE”:</p>
		<ul class="b-up-alpha less-li-he justify">
			<li class="one-line-sp">“EL CLIENTE” se obliga incondicionalmente a que la oficina ubicada en {{$contract->office->address}} en {{$contract->office->municipality->name.' '.$contract->office->state->name}} será destinada exclusivamente para oficinas de representación comercial, cualquier otro uso diferente al señalado, causará la rescisión inmediata del presente contrato. el mobiliario y accesorios (escritorios, mesas, sillas, chapas, vidrios, etc.) deberán ser entregados en las mismas condiciones en que fueron recibidos, de lo contrario, “EL CLIENTE” deberá absorber el costo de reparación de los mismos cuando “EL PRESTADOR” se lo solicite.</li>
			<li class="one-line-sp">“EL CLIENTE” acepta pagar de inmediato (i) todos los impuestos sobre ventas, uso, consumo  y cualesquier otros impuestos y derechos de licencia que “EL CLIENTE” tenga que pagar a alguna autoridad gubernamental (y, a petición de “EL PRESTADOR”, “EL CLIENTE” deberá de proporcionar al prestador un comprobante de dicho pago) y (ii) todos los impuestos pagados por “EL PRESTADOR” a alguna autoridad gubernamental que sean atribuibles al uso de la instalación, de ser aplicable, incluyendo, sin limitación, todos los ingresos brutos, impuestos sobre renta y ocupación, impuestos sobre bienes personales tangibles, impuesto de sellos u otros impuestos y aranceles similares.</li>
			<li class="one-line-sp">“EL CLIENTE” se compromete a no fumar dentro de las instalaciones, no introducir animales, combustibles o cualquier otra sustancia que pueda provocar algún percance.</li>
			<li class="one-line-sp">“EL CLIENTE” bajo ninguna circunstancia podrá ceder los derechos de los servicios de oficina que está recibiendo a terceras personas completa ni parcialmente.</li>
			<li class="one-line-sp">Los empleados e invitados de “EL CLIENTE” se comportaran de una manera apropiada para el entorno de negocios; en todo momento deberán de vestirse de manera adecuada para negocios; el nivel de ruido se mantendrá en un nivel adecuado para no interferir con el ambiente de trabajo de los demás y “EL CLIENTE” cumplirá con las directivas de “EL PRESTADOR” con respecto a la seguridad, llaves, estacionamiento, no fumar dentro del establecimiento, así como también no ingerir o introducir bebidas alcohólicas y otros asuntos comunes para todos los ocupantes.</li>
			<li class="one-line-sp">“EL CLIENTE” no podrá realizar negocios en los pasillos, área de recepción o alguna otra área excepto en su oficina designada sin la previa autorización escrita de “EL PRESTADOR”.</li>
			
			<div class="new-page"></div>
			
			<br><br>
			<li class="one-line-sp">“EL CLIENTE” o sus funcionarios, directores, empleados, accionistas, socios, agentes, representantes, contratistas que presenten o incurran en cualquier clase de acoso o comportamiento de índoles hostil, discriminatoria o abusiva, ya sea físico o verbal, hacia los integrantes de “EL PRESTADOR”, otros clientes o sus invitados que se encuentren en el centro de negocios. toda violación de estas reglas se considerará un incumplimiento de su contrato (sin posibilidad de ser subsanado) y, en consecuencia, su contrato podrá ser rescindido de inmediato y los servicios podrán ser suspendidos sin previo aviso.</li>
			<li class="one-line-sp">“EL CLIENTE” está obligado a entregar documentación oficial (IFE-INE, pasaporte o cedula profesional) de cada uno de los empleados que laboren en la ubicación señalada en este contrato por “EL PRESTADOR”.</li>
			<li class="one-line-sp">Queda prohibido para “EL CLIENTE” mantener sonidos o música a alto volumen que pueda molestar a los demás clientes, así mismo, deberá evitarse la permanencia de niños dentro de las instalaciones, en caso contrario, “EL CLIENTE” será responsable de los percances que pudieran provocar ya sea al mobiliario o a los demás clientes de las oficinas.</li>
			<li class="one-line-sp">“EL CLIENTE” se compromete a solicitar autorización a “prestador” previo a realizar cualquier modificación dentro del bien inmueble, aunque sea en beneficio del mismo. cualquier modificación a favor quedará como beneficio para el mismo una vez terminada la vigencia del presente contrato de acuerdo a los artículos 2005 y 2016 del código civil del estado de Jalisco.</li>
			<li class="one-line-sp">“EL CLIENTE” se obliga a conservar el buen estado del inmueble y dar aviso de cualquier situación que pudiera afectar al mismo, de lo contrario se hará responsable de los daños y perjuicios que pudieran ocasionarse por tal motivo.</li>
			<li class="one-line-sp">“EL CLIENTE” acepta expresamente en caso de que diera por rescindido el presente contrato de prestación de servicios por causas imputables al mismo, la penalización será igual a 4 meses de renta, misma que será aplicada a favor de “EL PRESTADOR” para resarcirle de los perjuicios que le causaría el incumplimiento en el plazo del presente contrato, dando aviso a “EL PRESTADOR” con un mínimo de 30 días de anticipación.</li>
		</ul>

		<br>
		<p class="break justify bold">5. Depósito en garantía:</p>
		<ul class="b-up-alpha less-li-he justify">
			<li class="one-line-sp">“EL CLIENTE” entrega en este acto la suma de {{$contract->office->price}} ({{$contract->monthly_payment_str}}) más IVA al valor agregado cantidad que “EL PRESTADOR” conservará en depósito hasta la terminación del presente contrato y queda autorizado para aplicar dicha cantidad al pago de saldos insolutos que “EL CLIENTE” pudiera adeudar. en caso de que “EL CLIENTE” no adeude cantidad alguna, la suma depositada en garantía le será devuelta sin necesidad de ningún trámite adicional (será indispensable para la devolución, entregar baja de domicilio ante el SAT en caso de estar registrado como domicilio fiscal y comprobantes de no adeudo de servicios contratados por su cuenta, tales como líneas de teléfono, etc.), en un plazo máximo de 30 días contados a partir de la fecha de vencimiento del contrato, siempre y cuando cumpla la vigencia del mismo. en caso de no presentar los documentos mencionados, el depósito quedará a disposición de cobro en favor de “EL PRESTADOR”.</li>
		</ul>

		<p class="break justify bold">6. Confidencialidad:</p>
		<ul class="b-up-alpha less-li-he justify">
			<li class="one-line-sp">En los términos de este contrato son confidenciales. “EL CLIENTE no podrá divulgar ningún tipo de información que se le haya proporcionado, sin la autorización de la otra parte a menos que la ley o una autoridad competente lo requieran. esta obligación continuara después de la finalización o terminación del presente contrato por un lapso de tiempo de 5 años posteriores a la fecha en la que se haya terminado, rescindido o finalizado el presente instrumento jurídico.</li>
		</ul>

		<br><br><br><br>
		<p class="break justify bold">7. Incumplimiento y terminación del contrato:</p>
		<ul class="b-up-alpha less-li-he justify">
			<li class="one-line-sp">En el evento de que “EL PRESTADOR” incumpla con alguna de las obligaciones asumidas a su cargo por virtud del presente contrato, “EL CLIENTE” deberá notificar por escrito a “EL PRESTADOR”</li>
			<li class="one-line-sp">“EL PRESTADOR” podrá dar por rescindido el presente contrato en cualquier momento que “EL CLIENTE” incumpla alguna de las obligaciones de “EL CLIENTE” sin tener que presentar previa notificación.</li>
			<li class="one-line-sp">El presente contrato podrá ser rescindido en los siguientes casos:</li>
			<li class="one-line-sp">Por incumplimiento de cualquiera de las partes, tomando en cuenta las condiciones, plazos y multas señaladas para cada una de las obligaciones contenidas en el presente contrato. en caso de que alguna de las obligaciones no se encuentre sujeta a condición, plazo o no se especifique que el incumplimiento de la misma será causal de rescisión; las partes manifiestan de común acuerdo sujetarse a la siguiente regla de aplicación de la rescisión: en caso de no especificarse, será motivo de rescisión del presente contrato el hecho de que las partes reincidan en el incumplimiento de alguna de las obligaciones a su cargo, siempre y cuando la parte afectada por el incumplimiento hubiese señalado el mismo mediante notificación escrita y haya señalado un plazo para subsanarlo.</li>
			<li class="one-line-sp">Por convenio celebrado entre las partes, en el que de mutuo acuerdo determinen la terminación anticipada del presente contrato.</li>
			<li class="one-line-sp">por el hecho de que transcurra el plazo natural de duración estipulado en este contrato, sin que “EL CLIENTE” tramite su renovación en los términos señalados en el título de duración en su punto b.</li>
			<li class="one-line-sp">En caso del fallecimiento de “EL CLIENTE”. </li>
		</ul>

		<br>
		<p class="break justify bold">8. Efectos a la terminación del contrato:</p>
		<ul class="b-up-alpha less-li-he justify">
			<li class="one-line-sp">pagar a favor del “prestador” todas aquellas cantidades que le adeude por cualquiera de los conceptos estipulados en el presente contrato.</li>
			<li class="one-line-sp">en caso de que exista la rescisión anticipada de este instrumento jurídico “EL CLIENTE” acepta expresamente en caso de que diera por rescindido el presente contrato o por causas imputables al mismo, la penalización será igual al tiempo restante del presente contrato, misma que será aplicada a favor de “EL PRESTADOR” para resarcirle de los perjuicios que le causaría el incumplimiento en el plazo del presente contrato, dando aviso a “EL PRESTADOR” con un mínimo de 30 días de anticipación por escrito.</li>
			<li class="one-line-sp">cuando este contrato termine EL CLIENTE se compromete a cesar cualquier uso de la dirección del centro DEL PRESTADOR y autoriza a EL PRESTADOR a tomar cualquier acción que estime necesaria e incurrir en cualquier costo razonable si EL PRESTADOR estima, a su solo juicio, que EL CLIENTE no ha tomado las acciones necesarias dentro de un plazo razonable. EL CLIENTE también acuerda reembolsarle al prestador cualquier costo razonable en que incurra dando de baja el uso de la dirección del centro DEL PRESTADOR</li>
			<li class="one-line-sp">para la interpretación y cumplimiento de este contrato, así como para lo no previsto en el mismo, las partes se someten a la jurisdicción y competencia de los tribunales por medio de la vía mercantil del fuero común de la ciudad de {{$contract->office->municipality->name}} en el estado de {{$contract->office->state->name}}, por lo que renuncian expresamente al fuero que, por razón de su domicilio presente o futuro, pudiera corresponderles.</li>
		</ul>

		<br><br><br>
		<br>
		<p class="break justify bold">9. Respetar el compromiso de no competencia:</p>
		<p class="break justify">en razón a la información y conocimientos de carácter confidencial a los que tuvo acceso por motivo de la relación contractual que mantuvo con EL PRESTADOR, EL CLIENTE se obliga, durante 5 (cinco) años contados a partir del día en que opere la terminación del presente contrato, a no operar negocios similares, participar directa o indirectamente en algún negocio perteneciente al ramo de mercado al que pertenece EL PRESTADOR, así como establecer o participar en negocios en los que se ofrezcan productos y servicios similares a los que ofrece EL PRESTADOR en sus franquicias, invertir en esquemas de negocio iguales o con algún grado de similitud al utilizado por EL PRESTADOR, desarrollar o participar en el desarrollo de un sistema o de un esquema de negocio de cualquier tipo que constituya competencia directa con el concepto de negocio DEL PRESTADOR o que utilice procesos y procedimientos similares a los establecidos en el contrato  y en la información confidencial DEL PRESTADOR. O en su defecto que EL CLIENTE elija cubrir una indemnización por la cantidad de $480,000.00 (cuatrocientos ochenta mil pesos 00/100 m.n.) en favor DEL PRESTADOR, cuando este se quiera dedicar a un concepto similar al prestador, en este supuesto el simple pago de la indemnización permitirá al cliente ser competencia DEL PRESTADOR.</p>
		<p class="break justify">Leído el presente contrato y enteradas las partes de su contenido y alcances, lo firman de conformidad.</p>

		<br><br>
		<p class="break right">{{$contract->office->municipality->name}}, {{$contract->office->state->name}} a {{ucwords(strftime('%d %B %Y', strtotime($contract->contract_date)))}}</p>

		<br><br><br>
		<div class="signature uppercase">
			<span class="bold">"EL PRESTADOR"</span>
			<br><br><br>
			_______________________________<br>
            <span>{{$contract->office->branch->user->fullname}}</span>
		</div>
		<div class="signature uppercase">
			<span class="bold">"EL CLIENTE"</span>
			<br><br><br>
			_______________________________<br>
			<span class="">{{$contract->customer->fullname}}</span>
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

		<div class="new-page"></div>
		
		<br>
		<p class="break center bold underline">APÉNDICE</p>
		<br>
		<p class="break left">LISTA DE PRECIOS DE SERVICIOS ADICIONALES:</p>

		<ul class="no-style less-li-he no-margin no-padding justify">
			<li class="">Copia Fotostática …………………………………………………       $ 1.00 por copia</li>
			<li class="">Impresiones ………………………………………………………     $ 2.00 cada una </li>
			<li class="">Llamadas Locales ……...…………………………………………       $ 1.50 </li>
			<li class="">Llamadas Larga Distancia ………………………………………     $ 1.50 por minuto </li>
			<li class="">Escáner de documentos …………………………………………        $ 2.00 por pagina </li>
			<li class="">Costo de proyector………………………………………………      $ 100.00 por hora. </li>
			<li class="">Costo de proyector………………………………………………      $ 400.00 por día. </li>
			<li class="">Sala de juntas costo por hora …………………………………          $ 200.00 por hora </li>
			<li class="">Sala de juntas costo por hora (horarios fuera de recepción)       $ 400.00 por hora </li>
		</ul>

		<br>
		<p class="break center bold">POLITICAS DE SALA DE JUNTAS:</p>
		<br>
		<p class="break center bold italic">Con el propósito de que la Sala de Juntas tenga un uso óptimo se exhorta a los inquilinos a respetar lo siguiente:</p>

		<ul class="b-numeric less-li-he justify">
			<li class="one-line-sp">“EL CLIENTE” deberá verificar con la recepcionista si la fecha que desea reservar está disponible</li>
			<li class="one-line-sp">Si “EL CLIENTE” requiere hacer uso del proyector será necesario pedirlo en recepción 1 día antes de la reservación que solicito</li>
			<li class="one-line-sp">La reservación podrá solicitarse hasta con 1 mes de anticipación (como máximo) y con   dos días de anticipación (como mínimo).</li>
			<li class="one-line-sp">“EL CLIENTE” deberá mantener la sala limpia y en orden. Si “EL CLIENTE” requieren cambiar la disposición de las mesas y las sillas deberán reacomodarlas al terminar su reservación.</li>
			<li class="one-line-sp">Con el propósito de mantener limpia la sala, sólo se permite servir bebidas, canapés y galletas, cuyos contenedores deberán ser retirados una vez que concluya la reunión.</li>
			<li class="one-line-sp">“EL CLIENTE” deberá mantener el pintaron limpio, así mismo colocar los plumones y el borrador en el lugar que pertenecen.</li>
			<li class="one-line-sp">“EL CLIENTE” cuenta con un periodo de 15 minutos para disponer de sala juntas de lo contrario pierde su reservación.</li>
			<li class="one-line-sp">“EL CLIENTE” que reserve la sala y, por razones imprevistas, no harán uso de ella se les ruega que cancelen su solicitud a la mayor brevedad posible.</li>
			<li class="one-line-sp">Al terminar de usar la sala, “EL CLIENTE” deberá: apagar la luz, aire acondicionado y aparatos electrónicos o todo aquel aparato que esté conectado a la corriente eléctrica, (aplican restricciones) cerrar la puerta,  dar aviso a recepción y devolver el control del clima, y de televisión o pantalla.</li>
			<li class="one-line-sp">“EL CLIENTE” deberá desocupar sala de juntas exactamente en la hora que específico su finalización cuando hizo la reservación.</li>
			<li class="one-line-sp">Las reservaciones para sala de juntas únicamente podrán ser por lapsos y/o bloques de 1 hora por cliente, por lo que el “EL CLIENTE” no podrá realizar reservas acumulativas, o por lapsos mayores a este tiempo.</li>
		</ul>
	</div>

</body>
</html>

