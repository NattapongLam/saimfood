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
        Schema::create('assetinout_hds', function (Blueprint $table) {
            $table->id('assetinout_hd_id');
            $table->BigInteger('assetinout_statuses_id');
            $table->date('assetinout_hd_date');
            $table->string('assetinout_hd_docuno');
            $table->integer('assetinout_hd_docunum');
            $table->string('assetinout_hd_vendor')->nullable();
            $table->string('assetinout_hd_contact')->nullable();
            $table->string('assetinout_hd_tel')->nullable();
            $table->string('assetinout_hd_note')->nullable();
            $table->string('assetinout_hd_file1')->nullable();
            $table->string('assetinout_hd_file2')->nullable();
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
        Schema::dropIfExists('assetinout_hds');
    }
};
