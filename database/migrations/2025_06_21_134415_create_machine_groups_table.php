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
        Schema::create('machine_groups', function (Blueprint $table) {
            $table->id('machinegroup_id');
            $table->string('machinegroup_code')->unique(); 
            $table->string('machinegroup_name');
            $table->boolean('machinegroup_flag')->default(true); 
            $table->string('person_at');
            $table->timestamps();
            $table->unique(['machinegroup_code', 'machinegroup_flag'], 'uq_machinegroup_code_flag');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('machine_groups');
    }
};
