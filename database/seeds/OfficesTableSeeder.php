<?php

use Illuminate\Database\Seeder;

class OfficesTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$offices = [
			[
				'branch_id' => 1,
				'user_id' => 3,
				'name' => "Oficina 1",
				'address' => "Simon Bolivar 594",
			],

		];

		DB::table('offices')->insert($offices);
	}
}
