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
        Schema::create('equipment', function (Blueprint $table) {
            $table->id('equipment_id');
            $table->date('equipmente_date');
            $table->string('equipment_code');
            $table->string('equipment_name');
            $table->boolean('equipment_flag')->default(true); 
            $table->string('person_at');
            $table->string('equipment_pic1')->nullable();
            $table->string('equipment_pic2')->nullable();
            $table->string('equipment_pic3')->nullable();
            $table->string('equipment_pic4')->nullable();
            $table->date('insurance_date')->nullable();
            $table->date('last_repair')->nullable();
            $table->date('last_planned')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('equipment_details')->nullable();
            $table->string('equipment_location')->nullable();
            $table->date('last_transfer')->nullable();
            $table->BigInteger('equipment_status_id');
            $table->timestamps();
            $table->unique(['equipment_code', 'equipment_flag'], 'uq_equipment_code_flag');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipment');
    }
};
