<?php

use Illuminate\Database\Seeder;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
			[
				'name' 			=> 'Aguascalientes',
				'abreviation' 	=> 'Ags',
				'country'		=> 'MX'
			],
			[
				'name' 			=> 'Baja California',
				'abreviation' 	=> 'BC',
				'country'		=> 'MX'
			],
			[
				'name' 			=> 'Baja California Sur',
				'abreviation' 	=> 'BCS',
				'country'		=> 'MX'
			],
			[
				'name' 			=> 'Campeche',
				'abreviation' 	=> 'Camp.',
				'country'		=> 'MX'
			],
			[
				'name' 			=> 'Coahuila de Zaragoza',
				'abreviation' 	=> 'Coah.',
				'country'		=> 'MX'
			],
			[
				'name' 			=> 'Colima',
				'abreviation' 	=> 'Col.',
				'country'		=> 'MX'
			],
			[
				'name' 			=> 'Chiapas',
				'abreviation' 	=> 'Chis.',
				'country'		=> 'MX'
			],
			[
				'name' 			=> 'Chihuahua',
				'abreviation' 	=> 'Chih.',
				'country'		=> 'MX'
			],
			[
				'name' 			=> 'Distrito Federal',
				'abreviation' 	=> 'DF',
				'country'		=> 'MX'
			],
			[
				'name' 			=> 'Durango',
				'abreviation' 	=> 'Dgo.',
				'country'		=> 'MX'
			],[
				'name' 			=> 'Guanajuato',
				'abreviation' 	=> 'Gto.',
				'country'		=> 'MX'
			],
			[
				'name' 			=> 'Guerrero',
				'abreviation' 	=> 'Gro.',
				'country'		=> 'MX'
			],
			[
				'name' 			=> 'Hidalgo',
				'abreviation' 	=> 'Hgo.',
				'country'		=> 'MX'
			],
			[
				'name' 			=> 'Jalisco',
				'abreviation' 	=> 'Jal.',
				'country'		=> 'MX'
			],
			[
				'name' 			=> 'México',
				'abreviation' 	=> 'Mex.',
				'country'		=> 'MX'
			],
			[
				'name' 			=> 'Michoacán de Ocampo',
				'abreviation' 	=> 'Mich.',
				'country'		=> 'MX'
			],
			[
				'name' 			=> 'Morelos',
				'abreviation' 	=> 'Mor.',
				'country'		=> 'MX'
			],
			[
				'name' 			=> 'Nayarit',
				'abreviation' 	=> 'Nay.',
				'country'		=> 'MX'
			],
			[
				'name' 			=> 'Nuevo León',
				'abreviation' 	=> 'NL',
				'country'		=> 'MX'
			],
			[
				'name' 			=> 'Oaxaca',
				'abreviation' 	=> 'Oax.',
				'country'		=> 'MX'
			],
			[
				'name' 			=> 'Puebla',
				'abreviation' 	=> 'Pue.',
				'country'		=> 'MX'
			],
			[
				'name' 			=> 'Querétaro',
				'abreviation' 	=> 'Qro.',
				'country'		=> 'MX'
			],
			[
				'name' 			=> 'Quintana Roo',
				'abreviation' 	=> 'Q. Roo',
				'country'		=> 'MX'
			],
			[
				'name' 			=> 'San Luis Potosí',
				'abreviation' 	=> 'SLP',
				'country'		=> 'MX'
			],
			[
				'name' 			=> 'Sinaloa',
				'abreviation' 	=> 'Sin.',
				'country'		=> 'MX'
			],
			[
				'name' 			=> 'Sonora',
				'abreviation' 	=> 'Son.',
				'country'		=> 'MX'
			],
			[
				'name' 			=> 'Tabasco',
				'abreviation' 	=> 'Tab.',
				'country'		=> 'MX'
			],
			[
				'name' 			=> 'Tamaulipas',
				'abreviation' 	=> 'Tamps.',
				'country'		=> 'MX'
			],
			[
				'name' 			=> 'Tlaxcala',
				'abreviation' 	=> 'Tlax.',
				'country'		=> 'MX'
			],
			[
				'name' 			=> 'Veracruz de Ignacio de la Llave',
				'abreviation' 	=> 'Ver.',
				'country'		=> 'MX'
			],
			[
				'name' 			=> 'Yucatán',
				'abreviation' 	=> 'Yuc.',
				'country'		=> 'MX'
			],
			[
				'name' 			=> 'Zacatecas',
				'abreviation' 	=> 'Zac.',
				'country'		=> 'MX'
			],
		];

		DB::table('states')->insert($rows);
    }
}
