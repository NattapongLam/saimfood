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
        Schema::create('machine_checksheet_dts', function (Blueprint $table) {
            $table->id('machine_checksheet_dt_id');
            $table->unsignedBigInteger('machine_checksheet_hd_id');
            $table->foreign('machine_checksheet_hd_id')->references('machine_checksheet_hd_id')->on('machine_checksheet_hds')->onDelete('cascade');
            $table->integer('machine_checksheet_dt_listno');
            $table->string('machine_checksheet_dt_remark');
            $table->boolean('machine_checksheet_dt_flag')->default(true); 
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
        Schema::dropIfExists('machine_checksheet_dts');
    }
};
