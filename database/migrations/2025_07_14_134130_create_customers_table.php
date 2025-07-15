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
        Schema::create('customers', function (Blueprint $table) {
            $table->id('customer_id');
            $table->string('customer_code');
            $table->string('customer_name');
            $table->boolean('customer_flag')->default(true); 
            $table->string('customer_address');
            $table->string('customer_province');
            $table->string('customer_zone');
            $table->string('person_at');
            $table->string('contact_person')->nullable();
            $table->string('contact_tel')->nullable();
            $table->string('branch_type')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('branch_number')->nullable();
            $table->timestamps();
            $table->unique(['customer_code', 'customer_flag'], 'uq_customer_code_flag');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
};
