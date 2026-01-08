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
        Schema::create('iso_master_lists', function (Blueprint $table) {
            $table->id('iso_master_lists_id');
            $table->integer('iso_master_lists_listno');
            $table->string('iso_master_lists_refdocu')->nullable();
            $table->string('iso_master_lists_docuno');
            $table->string('iso_master_lists_department');
            $table->string('iso_master_lists_name');
            $table->string('iso_master_lists_rev');
            $table->date('iso_master_lists_date');
            $table->string('iso_master_lists_timeline');
            $table->string('iso_master_lists_remark')->nullable();
            $table->string('iso_master_lists_file1')->nullable();
            $table->string('iso_master_lists_file2')->nullable();
            $table->boolean('iso_master_lists_flag')->default(true); 
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
        Schema::dropIfExists('iso_master_lists');
    }
};
