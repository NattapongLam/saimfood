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
        Schema::create('iso_ncr_products', function (Blueprint $table) {
            $table->id('iso_ncr_products_id');
            $table->unsignedBigInteger('iso_ncr_lists_id');
            $table->foreign('iso_ncr_lists_id')->references('iso_ncr_lists_id')->on('iso_ncr_lists')->onDelete('cascade');
            $table->string('following_productname')->nullable();
            $table->string('following_productcode')->nullable();
            $table->string('following_productlot')->nullable();
            $table->string('following_productqty')->nullable();
            $table->string('following_productnote')->nullable();
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
        Schema::dropIfExists('iso_ncr_products');
    }
};
