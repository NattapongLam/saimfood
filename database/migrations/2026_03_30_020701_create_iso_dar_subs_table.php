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
        Schema::create('iso_dar_subs', function (Blueprint $table) {
            $table->id('iso_dar_subs_id');
            $table->unsignedBigInteger('iso_dar_lists_id');
            $table->foreign('iso_dar_lists_id')->references('iso_dar_lists_id')->on('iso_dar_lists')->onDelete('cascade');
            $table->integer('iso_dar_subs_listno');
            $table->string('iso_dar_subs_code');           
            $table->string('iso_dar_subs_rev1')->nullable();
            $table->string('iso_dar_subs_rev2')->nullable();
            $table->string('iso_dar_subs_name'); 
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
        Schema::dropIfExists('iso_dar_subs');
    }
};
