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
        Schema::create('machine_checksheet_docu_dts', function (Blueprint $table) {
            $table->id('machine_checksheet_docu_dt_id');
            $table->unsignedBigInteger('machine_checksheet_docu_hd_id');
            $table->foreign('machine_checksheet_docu_hd_id')->references('machine_checksheet_docu_hd_id')->on('machine_checksheet_docu_hds')->onDelete('cascade');
            $table->BigInteger('machine_checksheet_dt_id');
            $table->integer('machine_checksheet_dt_listno');
            $table->string('machine_checksheet_dt_remark');
            $table->boolean('machine_checksheet_docu_dt_flag')->default(true); 
            $table->boolean('check_01')->default(false); 
            $table->boolean('check_02')->default(false); 
            $table->boolean('check_03')->default(false); 
            $table->boolean('check_04')->default(false); 
            $table->boolean('check_05')->default(false); 
            $table->boolean('check_06')->default(false); 
            $table->boolean('check_07')->default(false); 
            $table->boolean('check_08')->default(false); 
            $table->boolean('check_09')->default(false); 
            $table->boolean('check_10')->default(false); 
            $table->boolean('check_11')->default(false); 
            $table->boolean('check_12')->default(false); 
            $table->boolean('check_13')->default(false); 
            $table->boolean('check_14')->default(false); 
            $table->boolean('check_15')->default(false); 
            $table->boolean('check_16')->default(false); 
            $table->boolean('check_17')->default(false); 
            $table->boolean('check_18')->default(false); 
            $table->boolean('check_19')->default(false); 
            $table->boolean('check_20')->default(false); 
            $table->boolean('check_21')->default(false); 
            $table->boolean('check_22')->default(false); 
            $table->boolean('check_23')->default(false); 
            $table->boolean('check_24')->default(false); 
            $table->boolean('check_25')->default(false); 
            $table->boolean('check_26')->default(false); 
            $table->boolean('check_27')->default(false); 
            $table->boolean('check_28')->default(false); 
            $table->boolean('check_29')->default(false); 
            $table->boolean('check_30')->default(false); 
            $table->boolean('check_31')->default(false); 
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
        Schema::dropIfExists('machine_checksheet_docu_dts');
    }
};
