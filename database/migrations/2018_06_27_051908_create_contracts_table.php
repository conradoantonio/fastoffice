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
            //General contract fields
            $table->integer('user_id');
            $table->integer('application_id')->nullable();
            $table->integer('office_id');
            $table->date('contract_date');
            $table->date('start_date_validity');
            $table->date('end_date_validity');
            $table->string('monthly_payment_str')->nullable();
            $table->string('monthly_payment_delay_str')->nullable();
            $table->date('actual_pay_date')->nullable();//Only for paymentstatus cronjob
            $table->integer('payment_range_start')->nullable();
            $table->integer('payment_range_end')->nullable();
            $table->integer('status')->default(0)->comment('0 por pagar, 1 pagado, 2 retrasado');
            //Virtual office
            $table->integer('office_type_category_id')->nullable();
            //Meeting room
            $table->time('start_hour')->nullable();
            $table->time('end_hour')->nullable();
            $table->integer('total_hours')->nullable();

            //Provider fields
            $table->string('provider_name');
            $table->string('provider_address');
            //Physical fields
            $table->string('provider_ine_number')->nullable();
            //Moral fields
            $table->string('provider_act_number')->nullable();
            $table->string('provider_notary_number')->nullable();
            $table->string('provider_notary_state_id')->nullable();
            $table->string('provider_notary_name')->nullable();

            //Customer fields
            $table->string('customer_address');
            //Physical
            $table->string('customer_ine_number')->nullable();
            $table->string('customer_activity')->nullable();
            //Moral
            $table->string('customer_company')->nullable();
            $table->string('customer_act_number')->nullable();
            $table->string('customer_notary_number')->nullable();
            $table->string('customer_notary_state_id')->nullable();
            $table->string('customer_notary_name')->nullable();
            $table->string('customer_deed_number')->nullable();
            $table->string('customer_deed_date')->nullable();
            $table->string('customer_social_object')->nullable()->comment('Probablemente sea el mismo que customer_activity');
            
            //Timestamps
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
