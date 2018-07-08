<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfficesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('offices', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('branch_id');
			$table->integer('user_id')->default(0);
			$table->integer('office_type_id');
			$table->integer('state_id');
			$table->integer('municipality_id');
			$table->string('name');
			$table->text('address');
			$table->text('phone');
			$table->float('price');
			$table->integer('num_people');
			$table->text('description');
			$table->string('photo')->nullable();
			$table->integer('status')->default(1);
			$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('offices');
	}
}
