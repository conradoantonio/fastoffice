<?php

use Illuminate\Database\Seeder;

class EgressTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$types = [
			['name' => "Fijo"],
			['name' => "Variable"],
		];

		DB::table('egress_types')->insert($types);
    }
}
