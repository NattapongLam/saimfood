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
        Schema::create('machines', function (Blueprint $table) {
            $table->id('machine_id');
            $table->date('machine_date');
            $table->string('machine_code');
            $table->string('machine_name');
            $table->BigInteger('machinegroup_id');
            $table->string('serial_number')->nullable();
            $table->date('insurance_date')->nullable();
            $table->date('last_repair')->nullable();
            $table->date('last_planned')->nullable();
            $table->string('machine_details')->nullable();
            $table->string('machine_pic1')->nullable();
            $table->string('machine_pic2')->nullable();
            $table->string('machine_pic3')->nullable();
            $table->string('machine_pic4')->nullable();
            $table->boolean('machine_flag')->default(true); 
            $table->string('person_at');
            $table->timestamps();
            $table->unique(['machine_code', 'machine_flag'], 'uq_machine_code_flag');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('machines');
    }
};
