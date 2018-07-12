<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
			['name' => "Luz (CFE)", 'type' => 2],
			['name' => "Pago de renta", 'type' => 1],
		];

		DB::table('categories')->insert($rows);
    }
}
