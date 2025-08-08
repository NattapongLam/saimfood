<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_transfer_docus', function (Blueprint $table) {
            $table->id('customer_transfer_docu_id');
            $table->BigInteger('customer_transfer_status_id');
            $table->BigInteger('customer_id');
            $table->string('customer_fullname');
            $table->string('customer_address');         
            $table->string('contact_person');
            $table->string('contact_tel');
            $table->BigInteger('equipment_transfer_dt_id');
            $table->string('person_at');
            $table->string('person_remark');
            $table->date('approved_date')->nullable();
            $table->string('approved_at')->nullable();
            $table->string('approved_remark')->nullable();
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
        Schema::dropIfExists('customer_transfer_docus');
    }
};
