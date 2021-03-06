<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		#$this->call(NewsTableSeeder::class);
		$this->call(CategoriesTableSeeder::class);
		$this->call(FaqsTableSeeder::class);
		$this->call(RolesTableSeeder::class);
		$this->call(UsersTableSeeder::class);
		#$this->call(BannersTableSeeder::class);
		$this->call(CompaniesTableSeeder::class);
		$this->call(BranchesTableSeeder::class);
		$this->call(OfficesTableSeeder::class);
		$this->call(OfficeTypeTableSeeder::class);
		$this->call(StatesTableSeeder::class);
		$this->call(MunicipalitiesTableSeeder::class);
		$this->call(QuestionCategoryTableSeeder::class);
		$this->call(QuestionTableSeeder::class);
		$this->call(OfficeTypeCategoryTableSeeder::class);
		$this->call(EgressTypeSeeder::class);
	}
}
