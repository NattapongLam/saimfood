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
        Schema::create('clb_measuring_plans', function (Blueprint $table) {
            $table->id('clb_measuring_plans_id');
            $table->date('clb_measuring_lists_date');
            $table->BigInteger('clb_measuring_lists_id');      
            $table->integer('clb_measuring_lists_listno');         
            $table->string('clb_measuring_lists_code');
            $table->string('clb_measuring_lists_name');
            $table->string('clb_measuring_lists_department')->nullable();
            $table->string('clb_measuring_lists_frequency')->nullable();
            $table->string('actualuseperiod')->nullable();
            $table->string('acceptancecriteria')->nullable();
            $table->boolean('plan_jan')->default(false); 
            $table->boolean('plan_feb')->default(false); 
            $table->boolean('plan_mar')->default(false); 
            $table->boolean('plan_apr')->default(false); 
            $table->boolean('plan_may')->default(false); 
            $table->boolean('plan_jun')->default(false); 
            $table->boolean('plan_jul')->default(false); 
            $table->boolean('plan_aug')->default(false); 
            $table->boolean('plan_sep')->default(false); 
            $table->boolean('plan_oct')->default(false); 
            $table->boolean('plan_nov')->default(false); 
            $table->boolean('plan_dec')->default(false); 
            $table->boolean('action_jan')->default(false); 
            $table->boolean('action_feb')->default(false); 
            $table->boolean('action_mar')->default(false); 
            $table->boolean('action_apr')->default(false); 
            $table->boolean('action_may')->default(false); 
            $table->boolean('action_jun')->default(false); 
            $table->boolean('action_jul')->default(false); 
            $table->boolean('action_aug')->default(false); 
            $table->boolean('action_sep')->default(false); 
            $table->boolean('action_oct')->default(false); 
            $table->boolean('action_nov')->default(false); 
            $table->boolean('action_dec')->default(false); 
            $table->string('clb_measuring_lists_inside')->nullable();
            $table->string('clb_measuring_lists_external')->nullable();
            $table->string('clb_measuring_lists_remark')->nullable();
            $table->boolean('clb_measuring_lists_flag')->default(true); 
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
        Schema::dropIfExists('clb_measuring_plans');
    }
};
