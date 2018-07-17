<?php

use Illuminate\Database\Seeder;

class QuestionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$questions = [
			[
				'question' => "¿LA FACHADA SE ENCUENTRA PINTADA ADECUADAMENTE?",
				'category_id' => 1
			],
			[
				'question' => "¿EL LETRERO DE FAST OFFICE SE ENCUENTRA EN BUENAS CONDICIONES Y PRENDIDO?",
				'category_id' => 1
			],
			[
				'question' => "¿LAS LUCES EXTERIORES SE ENCUENTRAN APAGADAS DURANTE EL DÍA?",
				'category_id' => 1
			],
			[
				'question' => "¿EL ESTACIONAMIENTO CUENTA CON SEÑALIZACIÓN PARA LUGARES EXCLUSIVOS?",
				'category_id' => 1
			],
			[
				'question' => "¿LOS AUTOS SE ENCUENTRAN CORRECTAMENTE ESTACIONADOS?",
				'category_id' => 1
			],
			[
				'question' => "¿LA SUCURSAL CUENTA CON VIDEO PORTERO FUNCIONANDO?",
				'category_id' => 1
			],
			[
				'question' => "¿LA COCINA CUENTA CON 30 TAZAS?",
				'category_id' => 2
			],
			[
				'question' => "¿LA COCINA CUENTA 12 VASOS DE VIDRIO Y 1 JARRA DE AGUA?",
				'category_id' => 2
			],
			[
				'question' => "¿EL CAFÉ ESTÁ DISPONIBLE Y LISTO PARA SERVIRSE?",
				'category_id' => 2
			],
			[
				'question' => "¿LA COCINA CUENTA CON AZÚCAR, SPLENDA Y CREMA?",
				'category_id' => 2
			],
			[
				'question' => '¿LA COCINA CUENTA CON LOS LETREROS DE "MANTENER LIMPIO ESTA ÁREA"?',
				'category_id' => 2
			],
			[
				'question' => "¿LA COCINA SE ENCUENTRA LIMPIA (LAVABO, COMEDOR, SILLAS)?",
				'category_id' => 2
			],
			[
				'question' => "¿LOS CONSUMIBLES: PAPEL DE BAÑO, MANOS, JABÓN, CAFÉ, AZÚCAR, SPLENDA, SE ENCUENTRAN NUMERADOS PARA INVENTARIO Y EN LUGAR SEGURO CON LLAVE?",
				'category_id' => 2
			],
			[
				'question' => "¿LOS BAÑOS ESTAN ESTABLECIDOS CON PAPEL DE BAÑO?",
				'category_id' => 3
			],
			[
				'question' => "¿LOS BAÑOS ESTAN ABASTECIDOS CON JABÓN?",
				'category_id' => 3
			],
			[
				'question' => "¿LOS BAÑOS ESTÁN ABASTECIDOS CON PAPEL PARA MANOS?",
				'category_id' => 3
			],
			[
				'question' => "¿LOS BAÑOS ESTÁN ABASTECIDOS CON DESODORANTES?",
				'category_id' => 3
			],
			[
				'question' => "¿LOS BAÑOS SE ENCUENTRAN LIMPIOS?",
				'category_id' => 3
			],
			[
				'question' => "¿LA SALA DE JUNTAS CUENTA CON SILLAS COMPLETAS 6 U 8?",
				'category_id' => 4
			],
			[
				'question' => "¿LA SALA DE JUNTAS SE ENCUENTRA LIMPIA Y ORDENADA?",
				'category_id' => 4
			],
			[
				'question' => "¿LA CERRADURA DE SALA DE JUNTAS SE ENCUENTRA EN BUEN ESTADO?",
				'category_id' => 4
			],
			[
				'question' => "¿EL PINTARRÓN ESTA LIMPIO?",
				'category_id' => 4
			],
			[
				'question' => "¿EL PINTARRÓN CUENTA CON 3 PLUMONES Y UN BORRADOR?",
				'category_id' => 4
			],
			[
				'question' => "¿LA CLAVE DE WIFI SE ENCUENTRA EN EL PINTARRÓN?",
				'category_id' => 4
			],
			[
				'question' => "¿LA SALA DE JUNTAS CUENTA CON EL REGLAMENTO A LA VISTA?",
				'category_id' => 4
			],
			[
				'question' => "¿LA SALA DE JUNTAS CUENTA CON LA DISPONIBILIDAD A LA VISTA?",
				'category_id' => 4
			],
			[
				'question' => "¿LOS PASSILLOS DE LA SUCURSAL SE ENCUENTRA EN BUEN ESTADO PINTADOS?",
				'category_id' => 5
			],
			[
				'question' => "¿LOS PASSILLOS CUENTAN CON ADORNOS CON CUADROS?",
				'category_id' => 5
			],
			[
				'question' => "¿LOS PASSILLOS SE ENCUENTRAN BIEN ILUMINADOS?",
				'category_id' => 5
			],
			[
				'question' => "¿LAS OFCINAS SE ENCUENTRAN BIEN PINTADAS?",
				'category_id' => 6
			],
			[
				'question' => "¿LAS PARTAS Y CERRADURAS DE OFICINAS SE ENCUENTRAN EN BUEN ESTADO?",
				'category_id' => 6
			],
			[
				'question' => "¿TODAS LAS OFICINAS CUENTAN CON LLAVES EN RECEPCIÓN?",
				'category_id' => 6
			],
			[
				'question' => "¿LAS OFICINAS QUE NO SE ENCUENTRA EL CLIENTE EN ESE MOMENTO ESTA DEBIDAMENTE CERRADA CON LLAVE?",
				'category_id' => 6
			],
			[
				'question' => "¿EL MOBILIARIO DE LAS OFICINAS SE ENCUENTRA EN BUEN ESTADO?",
				'category_id' => 6
			],
			[
				'question' => "¿LAS OFICINAS CUENTAN CON NÚMERO EXTERIOR EN LA ENTRDA?",
				'category_id' => 6
			],
			[
				'question' => "¿LA ALARMA FUNCIONA CORRECTAMENTE?",
				'category_id' => 7
			],
			[
				'question' => "¿LAS CLAVES DE ALARMA SE ACTUALIZARON HACE MENOS DE 6 MESES?",
				'category_id' => 7
			],
			[
				'question' => "¿EL TECLADO CUENTA CON NUMEROS DE RECEPCIONISTA PARA CUALQUIER DUDA O ACLARACIÓN?",
				'category_id' => 7
			],
			[
				'question' => "¿TODOS LOS CLIENTES CUENTA CON CLAVE DE ACCESO?",
				'category_id' => 7
			],
			[
				'question' => "¿RECEPCIÓN TIENE UN CÓDIGO INDEPENDIENTE Y CONFIDENCIAL?",
				'category_id' => 7
			],
			[
				'question' => "¿LAS REDES DE INTERNET FUNCIONAN CORRECTAMENTE?",
				'category_id' => 8
			],
			[
				'question' => "¿LOS APARATOS TELEFÓNICOS ESTÁN ADECUADOS Y FUNCIONANDO PERFECTO?",
				'category_id' => 8
			],
			[
				'question' => "¿LOS SERVICIOS DE AGUA Y LUZ ESTÁN PAGADOS PUNTUALMENTE?",
				'category_id' => 8
			],
			[
				'question' => "¿LAS CANTIDADES DE LOS RECIBOS DE SERVICIOS ESTÁN DE ACUERDO A LO QUE SE PAGA EN PROMEDIO?",
				'category_id' => 8
			],
			[
				'question' => "¿LAS RECEPCIONISTA REFLEJA BUENA IMAGEN? (PEINADA, MAQUILLADA, UÑAS CORTADAS Y LIMPIAS, MANOS LIMPIAS, CONRIENTE)",
				'category_id' => 9
			],
			[
				'question' => "¿LA RECEPCIONISTA PORTA EL UNIFORME?",
				'category_id' => 9
			],
			[
				'question' => "¿LA RECEPCIONISTA VISTE TACONES?",
				'category_id' => 9
			],
			[
				'question' => "¿LA RECEPCIÓN CUENTA CON EL LIBRETO DE REGISTRO DE VISITANTES?",
				'category_id' => 9
			],
			[
				'question' => "¿LA RECEPCIÓN ESTA ABASTECIDA CON TARJETAS DE PRESENTACIÓN FAST OFFICE?",
				'category_id' => 9
			],
			[
				'question' => "¿LOS CONTRATOS DE CLIENTES SE ENCUENTRAN EN EL ARCHIVERO BAJO LLAVE?",
				'category_id' => 9
			],
			[
				'question' => "¿LAS LLAVES DE OFICINA SE ENCUENTRAN SEGURAS DENTRO DEL CAJÓN DE LLAVES?",
				'category_id' => 9
			],
			[
				'question' => "¿LA RECEPCIÓN SE ENCUENTRA LIMPIA Y ORDENADA?",
				'category_id' => 9
			],
			[
				'question' => "¿lA RECEPCIONISTA TIENE ALIMENTOS SOBRE EL ÁREA DE RECEPCIÓN?",
				'category_id' => 9
			],
			[
				'question' => "¿LA ATENCIÓN DE LA RECEPCIONISTA ES AMABLE Y DE EXCELENTE SERVICIO?",
				'category_id' => 9
			],
			[
				'question' => "¿EL RELOJ CHECADOR SE ENCUENTRA FUNCIONANDO Y CONECTADO A COMPUTADORA?",
				'category_id' => 9
			],
			[
				'question' => "¿LA CÁMARA DE SEGURIDAD SE ENCUENTRA LIMPIA Y VIENDO HACIA ÁREA DE RECEPCIÓN?",
				'category_id' => 9
			],
			[
				'question' => "¿LA COMPUTADORA SE ENCUENTRA TRABAJAND BIEN? (SIN VIRUS, SIN TRABAS)",
				'category_id' => 9
			],
			[
				'question' => "¿LA RECEPCIÓN SE ENCUENTRA ABASTECIDA DE HOJAS BLANCAS, PLUMAS AZULES Y NEGRAS, LÁPICES, ENGRAPADORA?",
				'category_id' => 9
			],
			[
				'question' => "¿EL MULTINACIONAL SE ENCUENTRA TRABAJAND CORRECTAMENTE?",
				'category_id' => 9
			],
			[
				'question' => "¿EL DIRECTORIO DE EMPRESAS SE ENCUENTRA ACTUALIZADO Y LLENO?",
				'category_id' => 9
			],
			[
				'question' => "¿LA RECEPCIÓN CUENTA CON UN COMPROBANTE DE DOMICILIO VIGENTE DE LA SUCURSAL? (3 MESES COMO MÁXIMO DE ANTIGÜEDAD)",
				'category_id' => 10
			],
			[
				'question' => "¿EN 3 CLIENTES AL AZAR, LA RECEPCIÓN CUENTA CON CONTRATO FIRMADO VIGENTE Y ACTUALIZADO?",
				'category_id' => 10
			],
			[
				'question' => "¿EN 3 CLIENTES AL AZAR, LA RECEPCIÓN CUENTA CON LA HOJA DE REGISTRO?",
				'category_id' => 10
			],
			[
				'question' => "¿EN 3 CLIENTES AL AZAR, LA RECEPCIÓN CUENTA CON EL COMPROBANTE DE DOMICILIO DEL CLIENTE?",
				'category_id' => 10
			],
			[
				'question' => "¿EN 3 CLIENTES AL AZAR, LA RECEPCIÓN CUENTA CON IDENTIFICACIÓN OFICIAL DEL REPRESENTANTE LEGAL DE LA EMPRESA?",
				'category_id' => 10
			],
			[
				'question' => "¿EN 3 CLIENTES AL AZAR, LA RECEPCIÓN CUENTA CON EL ACTA CONSTITUTIVA DE LA EMPRESA?",
				'category_id' => 10
			],
			[
				'question' => "¿DE TODOS LOS CLIENTES: EXISTE ALGÚN CONTRATO QUE ESTE POR VENCER?",
				'category_id' => 11
			],
			[
				'question' => "¿DE LOS CONTRATOS POR VENCER: YA SE ENVIÓ LA RENOVACIÓN CON 30 DÍAS DE ANTICIPACIÓN?",
				'category_id' => 11
			],
			[
				'question' => "¿LOS CONTRATOS DE LOS CLIENTES SE ENCUENTRANEN FOLDERS INDEPENDIENTES Y MARCADOS EN LAS PESTAÑAS PARA SU RÁPIDA BÚSQUEDA?",
				'category_id' => 11
			]
		];

		DB::table('questions')->insert($questions);
    }
}
