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
        Schema::create('machine_checksheet_docu_emps', function (Blueprint $table) {
            $table->id('machine_checksheet_docu_emp_id');
            $table->unsignedBigInteger('machine_checksheet_docu_hd_id');
            $table->foreign('machine_checksheet_docu_hd_id')->references('machine_checksheet_docu_hd_id')->on('machine_checksheet_docu_hds')->onDelete('cascade');
            $table->string('emp_01')->nullable();
            $table->timestamp('date_01')->nullable();
            $table->string('emp_02')->nullable();
            $table->timestamp('date_02')->nullable();
            $table->string('emp_03')->nullable();
            $table->timestamp('date_03')->nullable();
            $table->string('emp_04')->nullable();
            $table->timestamp('date_04')->nullable();
            $table->string('emp_05')->nullable();
            $table->timestamp('date_05')->nullable();
            $table->string('emp_06')->nullable();
            $table->timestamp('date_06')->nullable();
            $table->string('emp_07')->nullable();
            $table->timestamp('date_07')->nullable();
            $table->string('emp_08')->nullable();
            $table->timestamp('date_08')->nullable();
            $table->string('emp_09')->nullable();
            $table->timestamp('date_09')->nullable();
            $table->string('emp_10')->nullable();
            $table->timestamp('date_10')->nullable();
            $table->string('emp_11')->nullable();
            $table->timestamp('date_11')->nullable();
            $table->string('emp_12')->nullable();
            $table->timestamp('date_12')->nullable();
            $table->string('emp_13')->nullable();
            $table->timestamp('date_13')->nullable();
            $table->string('emp_14')->nullable();
            $table->timestamp('date_14')->nullable();
            $table->string('emp_15')->nullable();
            $table->timestamp('date_15')->nullable();
            $table->string('emp_16')->nullable();
            $table->timestamp('date_16')->nullable();
            $table->string('emp_17')->nullable();
            $table->timestamp('date_17')->nullable();
            $table->string('emp_18')->nullable();
            $table->timestamp('date_18')->nullable();
            $table->string('emp_19')->nullable();
            $table->timestamp('date_19')->nullable();
            $table->string('emp_20')->nullable();
            $table->timestamp('date_20')->nullable();
            $table->string('emp_21')->nullable();
            $table->timestamp('date_21')->nullable();
            $table->string('emp_22')->nullable();
            $table->timestamp('date_22')->nullable();
            $table->string('emp_23')->nullable();
            $table->timestamp('date_23')->nullable();
            $table->string('emp_24')->nullable();
            $table->timestamp('date_24')->nullable();
            $table->string('emp_25')->nullable();
            $table->timestamp('date_25')->nullable();
            $table->string('emp_26')->nullable();
            $table->timestamp('date_26')->nullable();
            $table->string('emp_27')->nullable();
            $table->timestamp('date_27')->nullable();
            $table->string('emp_28')->nullable();
            $table->timestamp('date_28')->nullable();
            $table->string('emp_29')->nullable();
            $table->timestamp('date_29')->nullable();
            $table->string('emp_30')->nullable();
            $table->timestamp('date_30')->nullable();
            $table->string('emp_31')->nullable();
            $table->timestamp('date_31')->nullable();
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
        Schema::dropIfExists('machine_checksheet_docu_emps');
    }
};
