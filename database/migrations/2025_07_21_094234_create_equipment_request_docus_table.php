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
        Schema::create('equipment_request_docus', function (Blueprint $table) {
            $table->id('equipment_request_docu_id');
            $table->BigInteger('equipment_request_status_id');
            $table->BigInteger('customer_id');
            $table->string('customer_fullname');
            $table->string('customer_address');         
            $table->string('contact_person');
            $table->string('contact_tel');
            $table->date('equipment_request_docu_date');
            $table->string('equipment_request_docu_docuno');
            $table->integer('equipment_request_doc_docunum');
            $table->date('equipment_request_docu_duedate');
            $table->integer('equipment_request_doc_qty');
            $table->string('equipment_request_docu_remark');
            $table->string('person_at');
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
        Schema::dropIfExists('equipment_request_docus');
    }
};
