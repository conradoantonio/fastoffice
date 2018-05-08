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
				'email' => 'admin@hotmail.com',
				'password' => bcrypt('contra'),
				'phone' => 3310980989,
				'role_id' => 1,
			],
			[
				'fullname' => "Franquisatario",
				'email' => 'franquisatario@hotmail.com',
				'password' => bcrypt('contra'),
				'phone' => 3310980989,
				'role_id' => 2,
			],
			[
				'fullname' => "Recepcionista",
				'email' => 'recepcion@hotmail.com',
				'password' => bcrypt('contra'),
				'phone' => 3310980989,
				'role_id' => 3,
			],
			[
				'fullname' => "Usuario",
				'email' => 'usuario@hotmail.com',
				'password' => bcrypt('contra'),
				'phone' => 3310980989,
				'role_id' => 4,
			]
		];

		DB::table('users')->insert($users);
	}
}
