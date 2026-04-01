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
        Schema::create('iso_car_lists', function (Blueprint $table) {
            $table->id('iso_car_lists_id');
            $table->string('iso_car_lists_docuno');     
            $table->string('iso_car_lists_refno')->nullable();
            $table->string('type_name');    
            $table->string('type_remark')->nullable();
            $table->string('iso_car_lists_problem')->nullable();
            $table->string('iso_car_lists_requirement')->nullable();
            $table->string('iso_car_lists_person');    
            $table->string('iso_car_lists_position')->nullable(); 
            $table->date('iso_car_lists_date');
            $table->string('cause_name')->nullable(); 
            $table->string('cause_remark')->nullable(); 
            $table->string('cause_analysis')->nullable(); 
            $table->string('cause_actions')->nullable(); 
            $table->string('cause_recurrence')->nullable();
            $table->date('cause_duedate')->nullable();
            $table->string('cause_person')->nullable();   
            $table->string('cause_position')->nullable(); 
            $table->date('cause_date')->nullable(); 
            $table->string('cause_correction_person')->nullable();   
            $table->string('cause_correction_position')->nullable(); 
            $table->date('cause_correction_date')->nullable(); 
            $table->string('cause_management_person')->nullable();   
            $table->date('cause_management_date')->nullable(); 
            $table->boolean('measuresone_check')->default(false); 
            $table->boolean('measuresone_next')->default(false); 
            $table->date('measuresone_date')->nullable(); 
            $table->string('measuresone_remark')->nullable();
            $table->string('measuresone_person')->nullable();   
            $table->string('measuresone_position')->nullable(); 
            $table->date('measuresone_persondate')->nullable(); 
            $table->string('measuresone_correction_person')->nullable();   
            $table->string('measuresone_correction_position')->nullable(); 
            $table->date('measuresone_correction_date')->nullable(); 
            $table->string('measuresone_management_person')->nullable();   
            $table->date('measuresone_management_date')->nullable(); 
            $table->boolean('measurestwo_check')->default(false); 
            $table->boolean('measurestwo_next')->default(false); 
            $table->string('measurestwo_remark')->nullable();
            $table->string('measurestwo_person')->nullable();   
            $table->string('measurestwo_position')->nullable(); 
            $table->date('measurestwo_date')->nullable(); 
            $table->string('measurestwo_correction_person')->nullable();   
            $table->string('measurestwo_correction_position')->nullable(); 
            $table->date('measurestwo_correction_date')->nullable(); 
            $table->string('measurestwo_management_person')->nullable();   
            $table->date('measurestwo_management_date')->nullable(); 
            $table->boolean('close_car')->default(false); 
            $table->boolean('new_car')->default(false); 
            $table->string('new_docuno')->nullable();   
            $table->string('car_remark')->nullable(); 
            $table->string('car_management_person')->nullable();   
            $table->date('car_management_date')->nullable(); 
            $table->integer('status');         
            $table->boolean('flag')->default(true); 
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
        Schema::dropIfExists('iso_car_lists');
    }
};
