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
        Schema::create('customer_repair_docus', function (Blueprint $table) {
            $table->id('customer_repair_docu_id');
            $table->string('customer_repair_docu_docuno');
            $table->integer('customer_repair_docu_docunum');
            $table->BigInteger('transfer_id');
            $table->string('transfer_docuno');
            $table->BigInteger('customer_id');
            $table->string('customer_fullname');
            $table->string('customer_address');
            $table->string('contact_person');
            $table->string('contact_tel');
            $table->BigInteger('equipment_id');
            $table->string('equipment_code');
            $table->string('equipment_name');
            $table->BigInteger('customer_repair_status_id');
            $table->string('customer_repair_docu_case');
            $table->string('person_at')->nullable();
            $table->date('person_date')->nullable();
            $table->timestamp('person_datetime')->nullable();
            $table->string('person_result')->nullable();
            $table->string('result_remark')->nullable();
            $table->string('person_note')->nullable();
            $table->string('approved_at')->nullable();
            $table->date('approved_date')->nullable();
            $table->string('approved_remark')->nullable();
            $table->string('result_at')->nullable();
            $table->date('result_date')->nullable();
            $table->string('result_note')->nullable();
            $table->string('delivery_at')->nullable();
            $table->date('delivery_date')->nullable();
            $table->string('delivery_address')->nullable();
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
        Schema::dropIfExists('customer_repair_docus');
    }
};
