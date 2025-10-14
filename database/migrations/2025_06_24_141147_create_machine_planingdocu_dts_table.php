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
        Schema::create('machine_planingdocu_dts', function (Blueprint $table) {
            $table->id('machine_planingdocu_dt_id');
            $table->unsignedBigInteger('machine_planingdocu_hd_id');
            $table->foreign('machine_planingdocu_hd_id')->references('machine_planingdocu_hd_id')->on('machine_planingdocu_hds')->onDelete('cascade');
            $table->string('machine_code');
            $table->date('machine_planingdocu_dt_date');
            $table->string('machine_planingdocu_dt_note')->nullable();
            $table->boolean('machine_planingdocu_dt_flag')->default(true); 
            $table->boolean('machine_planingdocu_dt_plan')->default(true); 
            $table->boolean('machine_planingdocu_dt_action'); 
            $table->string('person_at');
            $table->string('action_at')->nullable();
            $table->string('review_at')->nullable();
            $table->date('review_date')->nullable();
            $table->string('review_remark')->nullable();
            $table->timestamps();
            $table->unique(['machine_code', 'machine_planingdocu_hd_id','machine_planingdocu_dt_flag'], 'uq_machine_code_flag');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('machine_planingdocu_dts');
    }
};
