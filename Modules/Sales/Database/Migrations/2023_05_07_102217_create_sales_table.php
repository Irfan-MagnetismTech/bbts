<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('account_holder')->nullable();
            $table->unsignedBigInteger('contact_duration')->nullable();
            $table->unsignedBigInteger('effective_date')->nullable();
            $table->unsignedBigInteger('work_order')->nullable();
            $table->unsignedBigInteger('wo_no')->nullable();
            $table->unsignedBigInteger('offer_id')->nullable();
            $table->unsignedBigInteger('mq_id')->nullable();
            $table->unsignedBigInteger('sla')->nullable();
            $table->float('otc', 8, 2)->nullable();
            $table->float('mrc', 8, 2)->nullable();
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
        Schema::dropIfExists('sales');
    }
};
