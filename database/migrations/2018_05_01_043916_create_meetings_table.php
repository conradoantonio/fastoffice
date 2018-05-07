<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeetingsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('meetings', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->default(0);
			$table->integer('office_id');
			$table->string('title');
			$table->text('description');
			$table->datetime('datetime_start');
			$table->datetime('datetime_end');
			$table->integer('status')->default(1);
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
		Schema::dropIfExists('meetings');
	}
}
