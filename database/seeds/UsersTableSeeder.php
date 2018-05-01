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
				'email' => 'geno_1940@hotmail.com',
				'password' => bcrypt('contra'),
				'phone' => 3310980989,
				'role_id' => 1,
			]
		];

		DB::table('users')->insert($users);
	}
}
