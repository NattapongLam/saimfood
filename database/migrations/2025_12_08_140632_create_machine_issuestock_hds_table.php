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
        Schema::create('machine_issuestock_hds', function (Blueprint $table) {
            $table->id('machine_issuestock_hd_id');
            $table->BigInteger('machine_issuestock_statuses_id');
            $table->date('machine_issuestock_hd_date');
            $table->string('machine_issuestock_hd_docuno');
            $table->integer('machine_issuestock_hd_docunum');
            $table->string('machine_issuestock_hd_vendor')->nullable();
            $table->string('machine_issuestock_hd_contact')->nullable();
            $table->string('machine_issuestock_hd_tel')->nullable();
            $table->string('machine_issuestock_hd_note')->nullable();
            $table->string('machine_issuestock_hd_file1')->nullable();
            $table->string('machine_issuestock_hd_file2')->nullable();
            $table->string('person_at');
            $table->date('approved_date')->nullable();
            $table->string('approved_at')->nullable();
            $table->string('approved_remark')->nullable();
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
        Schema::dropIfExists('machine_issuestock_hds');
    }
};
