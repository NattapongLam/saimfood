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
        Schema::create('iso_airtest_plans', function (Blueprint $table) {
            $table->id('iso_airtest_plans_id');
            $table->date('iso_airtest_plans_date');
            $table->integer('iso_airtest_plans_listno');  
            $table->string('iso_airtest_plans_remark');
            $table->string('iso_airtest_plans_frequency');
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
            $table->boolean('iso_airtest_plans_flag')->default(true);     
            $table->string('iso_airtest_plans_person')->nullable();
            $table->string('iso_airtest_plans_review')->nullable();
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
        Schema::dropIfExists('iso_airtest_plans');
    }
};
