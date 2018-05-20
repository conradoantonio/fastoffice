<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateErpsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('erps', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('office_id');
			$table->string('category_id');
			$table->string('concept')->nullable();
			$table->float('amount');
			$table->integer('type')->comment("1 ingreso, 2 egreso");
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('erps');
	}
}
