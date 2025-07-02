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
        Schema::create('machine_repair_docdts', function (Blueprint $table) {
            $table->id('machine_repair_docdt_id');
            $table->unsignedBigInteger('machine_repair_dochd_id');
            $table->foreign('machine_repair_dochd_id')->references('machine_repair_dochd_id')->on('machine_repair_dochds')->onDelete('cascade');
            $table->integer('machine_repair_docdt_listno');
            $table->string('machine_repair_docdt_remark');
            $table->decimal('machine_repair_docdt_cost', 18, 2)->default(0);
            $table->boolean('machine_repair_docdt_flag')->default(true); 
            $table->string('machine_repair_docdt_note')->nullable();
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
        Schema::dropIfExists('machine_repair_docdts');
    }
};
