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
        Schema::create('equipment_transfer_dts', function (Blueprint $table) {
            $table->id('equipment_transfer_dt_id');
            $table->unsignedBigInteger('equipment_transfer_hd_id');
            $table->foreign('equipment_transfer_hd_id')->references('equipment_transfer_hd_id')->on('equipment_transfer_hds')->onDelete('cascade');
            $table->integer('equipment_transfer_dt_listno');
            $table->string('equipment_code');
            $table->string('equipment_name');
            $table->string('serial_number')->nullable();
            $table->string('equipment_transfer_dt_remark')->nullable();
            $table->boolean('equipment_transfer_dt_flag')->default(true); 
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
        Schema::dropIfExists('equipment_transfer_dts');
    }
};
