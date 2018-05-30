<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->default(0);
            $table->string('fullname')->nullable();
            $table->string('email')->nullable();
            $table->string('phone',10)->nullable();
            $table->integer('status')->default(0)->comment("0 Prospecto, 1 Cliente (está contratado), 2 Concretado (Fue cliente pero terminó contrato), 3 No concretado (Describir razón)");
            $table->text('comment')->comment("La razón por la que NO se cerró el contrato")->nullable();
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
        Schema::dropIfExists('applications');
    }
}
