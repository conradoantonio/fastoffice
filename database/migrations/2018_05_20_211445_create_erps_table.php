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
			$table->integer('branch_id')->default(0);
			$table->integer('office_id')->default(0);
			$table->integer('category_id');
			$table->integer('egress_type_id')->default(0);
			$table->string('concept')->nullable();
			$table->float('amount');
			$table->integer('type')->comment("1 ingreso, 2 egreso");
			$table->date('date');
			$table->string('file',200);
			$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
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
