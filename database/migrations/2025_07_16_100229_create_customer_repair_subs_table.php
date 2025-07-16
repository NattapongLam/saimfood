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
        Schema::create('customer_repair_subs', function (Blueprint $table) {
            $table->id('customer_repair_sub_id');
            $table->BigInteger('customer_repair_docu_id');
            $table->integer('customer_repair_sub_listno');
            $table->string('customer_repair_sub_remark');
            $table->string('customer_repair_sub_vendor')->nullable();
            $table->decimal('customer_repair_sub_cost', 18, 2)->default(0);
            $table->string('customer_repair_sub_file')->nullable();
            $table->boolean('customer_repair_sub_flag')->default(true); 
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
        Schema::dropIfExists('customer_repair_subs');
    }
};
