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
        Schema::create('iso_airtest_records', function (Blueprint $table) {
            $table->id('iso_airtest_records_id');
            $table->unsignedBigInteger('iso_airtest_plans_id');
            $table->foreign('iso_airtest_plans_id')->references('iso_airtest_plans_id')->on('iso_airtest_plans')->onDelete('cascade');
            $table->timestamp('iso_airtest_records_date')->nullable();
            $table->string('iso_airtest_records_department')->nullable();
            $table->string('iso_airtest_records_area')->nullable();
            $table->string('iso_airtest_records_qty')->nullable();
            $table->string('iso_airtest_records_result')->nullable();
            $table->string('iso_airtest_records_status')->nullable();
            $table->string('iso_airtest_records_review')->nullable();
            $table->string('iso_airtest_records_recheck')->nullable();
            $table->string('iso_airtest_records_acknowledge')->nullable();
            $table->string('iso_airtest_records_note')->nullable();
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
        Schema::dropIfExists('iso_airtest_records');
    }
};
