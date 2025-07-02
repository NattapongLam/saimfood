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
        Schema::create('machine_planing_hds', function (Blueprint $table) {
            $table->id('machine_planing_hd_id');
            $table->string('machine_code');
            $table->boolean('machine_planing_hd_flag')->default(true); 
            $table->string('machine_planing_hd_note')->nullable();
            $table->string('person_at');
            $table->timestamps();
            $table->unique(['machine_code', 'machine_planing_hd_flag'], 'uq_machine_code_flag');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('machine_planing_hds');
    }
};
