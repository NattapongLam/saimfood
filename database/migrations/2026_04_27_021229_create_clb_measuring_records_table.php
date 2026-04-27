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
        Schema::create('clb_measuring_records', function (Blueprint $table) {
            $table->id('clb_measuring_records_id');
            $table->unsignedBigInteger('clb_measuring_lists_id');
            $table->foreign('clb_measuring_lists_id')->references('clb_measuring_lists_id')->on('clb_measuring_lists')->onDelete('cascade');
            $table->integer('clb_measuring_records_listno');
            $table->date('clb_measuring_records_date');
            $table->string('clb_measuring_records_remark'); 
            $table->string('clb_measuring_records_timeline'); 
            $table->boolean('clb_measuring_records_calibate')->default(false); 
            $table->string('clb_measuring_records_certno'); 
            $table->boolean('clb_measuring_records_repaircheck')->default(false); 
            $table->string('clb_measuring_records_repairdocu');
            $table->string('clb_measuring_records_person'); 
            $table->string('clb_measuring_records_review');
            $table->string('clb_measuring_records_location');
            $table->string('clb_measuring_records_status');
            $table->string('clb_measuring_records_note');
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
        Schema::dropIfExists('clb_measuring_records');
    }
};
