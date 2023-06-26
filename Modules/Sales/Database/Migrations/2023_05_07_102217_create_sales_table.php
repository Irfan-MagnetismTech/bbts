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
            $table->string('client_no')->nullable();
            $table->string('account_holder')->nullable();
            $table->integer('offer_id')->nullable();
            $table->string('contract_duration')->nullable();
            $table->date('effective_date')->nullable();
            $table->string('remarks')->nullable();
            $table->string('wo_no')->nullable();
            $table->string('mq_no')->nullable();
            $table->float('grand_total', 8, 2)->nullable();
            $table->string('work_order')->nullable()->comment('file_path');
            $table->string('sla')->nullable()->comment('file_path');
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
