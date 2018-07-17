<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('application_id')->nullable();
            $table->integer('office_id');
            $table->date('contract_date');
            $table->string('provider_name');

            //Physical customer fields (only nullables)
            $table->string('provider_ine_number')->nullable();
            $table->string('customer_ine_number')->nullable();
            $table->string('customer_activity')->nullable();
            $table->string('customer_address');

            //Moral customer fields
            $table->string('customer_company')->nullable();
            $table->string('act_number')->nullable();
            $table->string('notary_number')->nullable();
            $table->string('notary_state_id')->nullable();
            $table->string('notary_name')->nullable();
            $table->string('deed_number')->nullable();
            $table->string('deed_date')->nullable();
            $table->string('customer_social_object')->nullable()->comment('Probablemente sea el mismo que customer_activity');

            //General contract fields
            $table->date('start_date_validity');
            $table->date('end_date_validity');
            $table->string('monthly_payment_str');
            $table->integer('payment_range_start');
            $table->integer('payment_range_end');
            $table->string('monthly_payment_delay_str');
            $table->integer('status')->default(1)->comment('0 por pagar, 1 pagado, 2 retrasado');
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
        Schema::dropIfExists('contracts');
    }
}
