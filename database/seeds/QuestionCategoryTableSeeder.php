<?php

use Illuminate\Database\Seeder;

class QuestionCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$categories = [
			[
				'name' => "FACHADA DE SUCURSAL"
			],
			[
				'name' => "COCINA"
			],
			[
				'name' => "BAÑOS"
			],
			[
				'name' => "SALA DE JUNTAS"
			],
			[
				'name' => "PASILLOS DE SUCURSAL"
			],
			[
				'name' => "OFICINAS"
			],
			[
				'name' => "ALARMA"
			],
			[
				'name' => "SERVICIOS: TELEFONÍA, INTERNET, AGUA, LUZ"
			],
			[
				'name' => "RECEPCIÓN"
			],
			[
				'name' => "DOCUMENTOS"
			],
			[
				'name' => "RENOVACIONES DE CONTRATOS"
			]
		];

		DB::table('question_categories')->insert($categories);
    }
}
