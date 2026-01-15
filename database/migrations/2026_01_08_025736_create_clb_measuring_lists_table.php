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
        Schema::create('clb_measuring_lists', function (Blueprint $table) {
            $table->id('clb_measuring_lists_id');
            $table->integer('clb_measuring_lists_listno');
            $table->string('clb_measuring_lists_code');
            $table->string('clb_measuring_lists_name');
            $table->string('clb_measuring_lists_brand')->nullable();
            $table->string('clb_measuring_lists_model')->nullable();
            $table->string('clb_measuring_lists_serialno')->nullable();
            $table->string('clb_measuring_lists_department')->nullable();
            $table->string('actualuseperiod')->nullable();
            $table->string('resolution')->nullable();
            $table->string('acceptancecriteria')->nullable();
            $table->string('clb_measuring_lists_start')->nullable();
            $table->string('clb_measuring_lists_note')->nullable();
            $table->string('clb_measuring_lists_remark')->nullable();
            $table->boolean('clb_measuring_lists_flag')->default(true);
            $table->string('clb_measuring_lists_file1')->nullable();
            $table->string('clb_measuring_lists_file2')->nullable();
            $table->string('clb_measuring_lists_file3')->nullable(); 
            $table->string('clb_measuring_lists_file4')->nullable(); 
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
        Schema::dropIfExists('clb_measuring_lists');
    }
};
