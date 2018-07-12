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
				'office_type_id' => 1,
				'state_id' => 14,
				'municipality_id' => 941,
				'name' => "Oficina 1",
				'phone' => "1231233",
				'address' => "Simon Bolivar 594",
				'price' => "100.00",
				'num_people' => 10,
				'description' => 'The office is big.'
			],

		];

		DB::table('offices')->insert($offices);
	}
}
