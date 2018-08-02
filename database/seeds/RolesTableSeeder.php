<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$roles = [
			['name' => "Administrador", 'env' => "Sistema"],
			['name' => "Franquisatario", 'env' => "Sistema"],
			['name' => "Recepcionista", 'env' => "Sistema"],
			['name' => "Usuario", 'env' => "App"],
			['name' => "Auditor", 'env' => "App"],
		];

		DB::table('roles')->insert($roles);
	}
}
