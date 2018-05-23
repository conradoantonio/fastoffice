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
				'user_id' => 2,
				'name' => "Sucursal 1",
				'address' => "Simon Bolivar 594",
			],

		];

		DB::table('branches')->insert($branches);
	}
}
