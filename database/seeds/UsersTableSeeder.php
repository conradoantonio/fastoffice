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
				'fullname' => "Jorge Enrique Benard Solorzano",
				'email' => 'admin@hotmail.com',
				'password' => bcrypt('contra'),
				'phone' => 3310980989,
				'regime' => null,
				'rfc' => null,
				'branch_id' => 0,
				'role_id' => 1,
			],
			[
				'fullname' => "Franquisatario",
				'email' => 'franquisatario@hotmail.com',
				'password' => bcrypt('contra'),
				'phone' => 3310980989,
				'regime' => 'Persona física',
				'rfc' => 'CACR880326HLO',
				'branch_id' => 0,
				'role_id' => 2,
			],
			[
				'fullname' => "Recepcionista",
				'email' => 'recepcion@hotmail.com',
				'password' => bcrypt('contra'),
				'phone' => 3310980989,
				'regime' => null,
				'rfc' => null,
				'branch_id' => 1,
				'role_id' => 3,
			],
			[
				'fullname' => "Juan josé",
				'email' => 'usuario@hotmail.com',
				'password' => bcrypt('contra'),
				'phone' => 3310980989,
				'regime' => 'Persona física',
				'rfc' => 'VECJ880326RGT',
				'branch_id' => 0,
				'role_id' => 4,
			]
		];

		DB::table('users')->insert($users);
	}
}
