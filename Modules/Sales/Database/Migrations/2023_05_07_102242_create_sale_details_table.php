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
        Schema::create('sale_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sale_id')->nullable();
            $table->string('client_no')->nullable();
            $table->integer('billing_address_id')->nullable();
            $table->integer('collection_address_id')->nullable();
            $table->string('fr_no')->nullable();
            $table->string('billpayment_date')->nullable();
            $table->string('payment_status')->nullable();
            $table->float('otc', 8, 2)->nullable();
            $table->float('mrc', 8, 2)->nullable();
            $table->float('total', 8, 2)->nullable();
            $table->date('delivery_date')->nullable();
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
        Schema::dropIfExists('sale_details');
    }
};
