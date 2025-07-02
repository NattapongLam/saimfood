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
        Schema::create('machine_planingdocu_subs', function (Blueprint $table) {
            $table->id('machine_planingdocu_sub_id');
            $table->unsignedBigInteger('machine_planingdocu_dt_id');
            $table->foreign('machine_planingdocu_dt_id')->references('machine_planingdocu_dt_id')->on('machine_planingdocu_dts')->onDelete('cascade');
            $table->BigInteger('machine_planing_dt_id');
            $table->integer('machine_planing_dt_listno');
            $table->string('machine_planing_dt_remark');
            $table->boolean('machine_planing_sub_action')->default(true); 
            $table->string('machine_planing_sub_note')->nullable();
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
        Schema::dropIfExists('machine_planingdocu_subs');
    }
};
