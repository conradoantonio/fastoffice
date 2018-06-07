<?php

use Illuminate\Database\Seeder;

class BranchesTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$branches = [
			[
				'name' => "Sucursal 1",
				'address' => "Simon Bolivar 594",
				'phone' => "6691505087",
				'zip_code' => "44900",
				'website' => "www.google.com",
				'locality' => "Guadalajara",
				'description' => "The bulding its's blue."
			],

		];

		DB::table('branches')->insert($branches);
	}
}
