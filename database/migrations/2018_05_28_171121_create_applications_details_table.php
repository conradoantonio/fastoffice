<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('application_id');
            $table->integer('state_id');
            $table->double('badget', 8, 2)->nullable();
            $table->integer('num_people')->nullable();
            $table->integer('office_type_id')->nullable();
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
        Schema::dropIfExists('applications_details');
    }
}
