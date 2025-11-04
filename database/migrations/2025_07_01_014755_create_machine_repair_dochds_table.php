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
        Schema::create('machine_repair_dochds', function (Blueprint $table) {
            $table->id('machine_repair_dochd_id');
            $table->date('machine_repair_dochd_date');
            $table->date('machine_repair_dochd_duedate');
            $table->string('docutype');
            $table->timestamp('machine_repair_dochd_datetime');
            $table->string('machine_repair_dochd_docuno');
            $table->integer('machine_repair_dochd_docunum');
            $table->string('machine_code');
            $table->string('machine_repair_dochd_type');
            $table->string('machine_repair_dochd_case');
            $table->string('machine_repair_dochd_location');
            $table->string('person_at');
            $table->BigInteger('machine_repair_status_id');
            $table->string('accepting_at')->nullable();
            $table->date('accepting_date')->nullable();
            $table->date('accepting_duedate')->nullable();
            $table->timestamp('accepting_datetime')->nullable();
            $table->string('accepting_note')->nullable();
            $table->string('approval_at')->nullable();
            $table->date('approval_date')->nullable();
            $table->string('approval_note')->nullable();
            $table->string('repairer_at')->nullable();
            $table->date('repairer_date')->nullable();
            $table->timestamp('repairer_datetime')->nullable();
            $table->string('repairer_type')->nullable();
            $table->string('repairer_problem')->nullable();
            $table->string('repairer_pic1')->nullable();
            $table->string('repairer_pic2')->nullable();
            $table->string('repairer_note')->nullable();
            $table->string('inspector_at')->nullable();
            $table->date('inspector_date')->nullable();
            $table->string('inspector_note')->nullable();
            $table->string('closing_at')->nullable();
            $table->date('closing_date')->nullable();
            $table->string('closing_note')->nullable();
            $table->string('safety_at')->nullable();
            $table->date('safety_date')->nullable();
            $table->string('safety_note')->nullable();
            $table->string('safety_type')->nullable();
            $table->string('safety_pic1')->nullable();
            $table->string('safety_pic2')->nullable();
            $table->string('safety_ppe')->nullable();
            $table->string('machine_repair_dochd_part')->nullable();
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
        Schema::dropIfExists('machine_repair_dochds');
    }
};
