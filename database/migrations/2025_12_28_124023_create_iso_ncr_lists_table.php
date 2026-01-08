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
        Schema::create('iso_ncr_lists', function (Blueprint $table) {
            $table->id('iso_ncr_lists_id');
            $table->date('iso_ncr_lists_date');
            $table->string('iso_ncr_lists_docuno');       
            $table->string('iso_ncr_lists_to');     
            $table->string('iso_ncr_lists_copy');     
            $table->string('iso_ncr_lists_person');
            $table->string('iso_ncr_lists_refdocu');
            $table->string('ms_processtype_name');
            $table->string('iso_ncr_lists_problem');
            $table->string('iso_ncr_lists_file1')->nullable();
            $table->string('iso_ncr_lists_file2')->nullable();
            $table->boolean('iso_ncr_lists_flag')->default(true); 
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
        Schema::dropIfExists('iso_ncr_lists');
    }
};
