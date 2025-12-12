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
        Schema::create('machine_issuestock_dts', function (Blueprint $table) {
            $table->id('machine_issuestock_dt_id');
            $table->unsignedBigInteger('machine_issuestock_hd_id');
            $table->foreign('machine_issuestock_hd_id')->references('machine_issuestock_hd_id')->on('machine_issuestock_hds')->onDelete('cascade');
            $table->integer('machine_issuestock_dt_listno');
            $table->string('machine_issuestock_dt_code')->nullable();
            $table->string('machine_issuestock_dt_name')->nullable();
            $table->string('machine_issuestock_dt_unit')->nullable();
            $table->decimal('machine_issuestock_dt_qty', 18, 2)->default(0);
            $table->decimal('machine_issuestock_dt_price', 18, 2)->default(0);
            $table->decimal('machine_issuestock_dt_total', 18, 2)->default(0);
            $table->string('machine_issuestock_dt_note')->nullable();
            $table->boolean('machine_issuestock_dt_flag')->default(true); 
            $table->string('person_at');
            $table->string('poststock');
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
        Schema::dropIfExists('machine_issuestock_dts');
    }
};
