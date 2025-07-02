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
        Schema::create('machine_checksheet_hds', function (Blueprint $table) {
            $table->id('machine_checksheet_hd_id');
            $table->string('machine_code');
            $table->string('machine_checksheet_hd_note')->nullable();
            $table->boolean('machine_checksheet_hd_flag')->default(true); 
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
        Schema::dropIfExists('machine_checksheet_hds');
    }
};
