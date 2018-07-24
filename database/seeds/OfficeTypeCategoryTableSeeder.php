<?php

use Illuminate\Database\Seeder;

class OfficeTypeCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
    		['office_type_id' => 2, 'name' => "Avanzado", 'view_name' => "advance"],
    		['office_type_id' => 2, 'name' => "Intermedio", 'view_name' => "intermediate"],
    		['office_type_id' => 2, 'name' => "Platino estación de cómputo", 'view_name' => "platinum_computer_station"],
    		['office_type_id' => 2, 'name' => "Platino línea de teléfono", 'view_name' => "platinum_telephone_line"],
    		['office_type_id' => 2, 'name' => "Premium", 'view_name' => "premium"],
    	];

        DB::table('office_type_categories')->insert($rows);
    }
}
