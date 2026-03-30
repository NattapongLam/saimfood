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
        Schema::create('iso_dar_lists', function (Blueprint $table) {
            $table->id('iso_dar_lists_id');
            $table->string('iso_dar_lists_department');                
            $table->string('iso_dar_lists_objective'); 
            $table->string('objective_remark')->nullable();
            $table->string('iso_dar_lists_docutype');  
            $table->string('docutype_remark')->nullable();
            $table->string('iso_dar_lists_reason');  
            $table->string('iso_dar_lists_file')->nullable();
            $table->string('iso_dar_lists_person');  
            $table->date('iso_dar_lists_date');
            $table->string('iso_dar_lists_reviewer')->nullable();
            $table->date('iso_dar_lists_reviewerdate')->nullable();
            $table->string('iso_dar_lists_reviewernote')->nullable();
            $table->string('approved_status')->nullable();
            $table->string('approved_by')->nullable();
            $table->date('approved_date')->nullable();
            $table->string('approved_remark')->nullable();
            $table->string('dc_remark')->nullable();
            $table->string('dc_ref1')->nullable();
            $table->string('dc_ref2')->nullable();
            $table->date('effective_date1')->nullable();
            $table->date('effective_date2')->nullable();
            $table->date('start_date1')->nullable();
            $table->date('start_date2')->nullable();
            $table->string('dc_by')->nullable();
            $table->date('dc_date')->nullable();
            $table->boolean('flag')->default(true);     
            $table->string('docutype')->nullable();
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
        Schema::dropIfExists('iso_dar_lists');
    }
};
