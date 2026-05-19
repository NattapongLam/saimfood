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
        Schema::create('iso_swabtest_allergen_records', function (Blueprint $table) {
            $table->id('iso_swabtest_allergen_records_id');
            $table->unsignedBigInteger('iso_swabtest_plans_id');
            $table->foreign('iso_swabtest_plans_id')->references('iso_swabtest_plans_id')->on('iso_swabtest_plans')->onDelete('cascade');
            $table->timestamp('iso_swabtest_allergen_records_datetime')->nullable();
            $table->string('iso_swabtest_allergen_records_area')->nullable();
            $table->string('iso_swabtest_allergen_records_productname')->nullable();
            $table->string('iso_swabtest_allergen_records_productcode')->nullable();
            $table->string('iso_swabtest_allergen_records_lotno')->nullable();
            $table->string('iso_swabtest_allergen_records_bactchno')->nullable();
            $table->string('iso_swabtest_allergen_records_name')->nullable();
            $table->string('iso_swabtest_allergen_records_remark')->nullable();
            $table->string('iso_swabtest_allergen_records_color')->nullable();
            $table->string('iso_swabtest_allergen_records_result')->nullable();
            $table->string('iso_swabtest_allergen_records_status')->nullable();
            $table->string('iso_swabtest_allergen_records_review')->nullable();
            $table->string('iso_swabtest_allergen_records_recheck')->nullable();
            $table->string('iso_swabtest_allergen_records_acknowledge')->nullable();
            $table->string('iso_swabtest_allergen_records_note')->nullable();
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
        Schema::dropIfExists('iso_swabtest_allergen_records');
    }
};
