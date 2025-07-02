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
        Schema::create('machine_checksheet_docu_hds', function (Blueprint $table) {
            $table->id('machine_checksheet_docu_hd_id');
            $table->date('machine_checksheet_docu_hd_date');
            $table->string('machine_code');
            $table->string('machine_checksheet_docu_hd_note')->nullable();
            $table->boolean('machine_checksheet_docu_hd_flag')->default(true); 
            $table->string('person_at');
            $table->string('approved_at')->nullable();
            $table->date('approved_date')->nullable();
            $table->string('approved_note')->nullable();
            $table->timestamps();
            $table->unique(['machine_code', 'machine_checksheet_docu_hd_date','machine_checksheet_docu_hd_flag'], 'uq_machine_code_flag');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('machine_checksheet_docu_hds');
    }
};
