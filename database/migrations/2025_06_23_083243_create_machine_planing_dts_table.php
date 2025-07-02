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
        Schema::create('machine_planing_dts', function (Blueprint $table) {
            $table->id('machine_planing_dt_id');
            $table->unsignedBigInteger('machine_planing_hd_id');
            $table->foreign('machine_planing_hd_id')->references('machine_planing_hd_id')->on('machine_planing_hds')->onDelete('cascade');
            $table->integer('machine_planing_dt_listno');
            $table->string('machine_planing_dt_remark');
            $table->boolean('machine_planing_dt_flag')->default(true); 
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
        Schema::dropIfExists('machine_planing_dts');
    }
};
