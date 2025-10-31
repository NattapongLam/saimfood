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
        Schema::create('assetinout_dts', function (Blueprint $table) {
            $table->id('assetinout_dt_id');
            $table->unsignedBigInteger('assetinout_hd_id');
            $table->foreign('assetinout_hd_id')->references('assetinout_hd_id')->on('assetinout_hds')->onDelete('cascade');
            $table->integer('assetinout_dt_listno');
            $table->string('assetinout_dt_name');
            $table->string('assetinout_dt_qty')->nullable();
            $table->string('assetinout_dt_note')->nullable();
            $table->boolean('assetinout_dt_flag')->default(true); 
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
        Schema::dropIfExists('assetinout_dts');
    }
};
