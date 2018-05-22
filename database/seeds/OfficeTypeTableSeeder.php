<?php

use Illuminate\Database\Seeder;

class OfficeTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$types = [
    		['name' => "Física"],
    		['name' => "Virtual"],
    		['name' => "Sala de juntas"],
    		['name' => "Sala de conferencias"]
    	];

        DB::table('office_types')->insert($types);
    }
}
