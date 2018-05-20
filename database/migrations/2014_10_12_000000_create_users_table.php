<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('branch_id')->default(0);
			$table->string('fullname');
			$table->string('email');
			$table->string('password')->nullable();
			$table->rememberToken();
			$table->string('phone',10)->nullable();
			$table->string('photo')->default('/img/profiles/avatar.jpg');
			$table->integer('role_id');
			$table->string('player_id')->nullable();
			$table->integer('social')->default(0);
			$table->integer('status')->default(1)->comment("0 inactivo, 1 activo, 2 bloqueado");
			$table->integer('branch_id')->default(0);
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
		Schema::dropIfExists('users');
	}
}
