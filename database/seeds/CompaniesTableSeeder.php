<?php

use Illuminate\Database\Seeder;

class CompaniesTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$company = [
			['name' => "skeleton"],
		];

		DB::table('companies')->insert($company);
	}
}
