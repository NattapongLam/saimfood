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
        Schema::create('iso_distribution_lists', function (Blueprint $table) {
            $table->id('iso_distribution_lists_id');
            $table->BigInteger('iso_master_lists_id');           
            $table->string('iso_master_lists_docuno');
            $table->string('iso_master_lists_department');
            $table->string('iso_master_lists_name');
            $table->string('iso_master_lists_rev');
            $table->string('ms_documenttype_name');
            $table->date('iso_distribution_lists_date');
            $table->string('iso_distribution_lists_person');
            $table->string('iso_distribution_lists_empcode')->nullable();
            $table->string('iso_distribution_lists_status');
            $table->boolean('iso_distribution_lists_flag')->default(true); 
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
        Schema::dropIfExists('iso_distribution_lists');
    }
};
