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
        Schema::create('equipment_transfer_hds', function (Blueprint $table) {
            $table->id('equipment_transfer_hd_id');
            $table->BigInteger('equipment_transfer_status_id');
            $table->date('equipment_transfer_hd_date');
            $table->string('equipment_transfer_hd_docuno');
            $table->integer('equipment_transfer_hd_docunum');
            $table->string('equipment_transfer_hd_remark')->nullable();
            $table->string('customer_fullname');
            $table->string('customer_address');
            $table->string('person_at');
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
        Schema::dropIfExists('equipment_transfer_hds');
    }
};
