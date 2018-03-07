<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$users = [
			[
				'fullname' => "Admin",
				'email' => 'admin@bridgestudio.mx',
				'password' => bcrypt('contra'),
				'phone' => 3310980989,
				'openpay_customer_id' => null,
				'role_id' => 1,
			],
			[
				'fullname' => "Usuario",
				'email' => 'usuario@bridgestudio.mx',
				'password' => bcrypt('contra'),
				'phone' => 3310980989,
				'openpay_customer_id' => 'ag1wco6k3r96gcv059zt',
				'role_id' => 2,
			]
		];

		DB::table('users')->insert($users);
	}
}
