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
            $table->foreignId('sale_id')->constrained('sales')->onDelete('cascade');
            $table->string('client_no')->nullable();
            $table->integer('billing_address_id')->nullable();
            $table->integer('collection_address_id')->nullable();
            $table->string('fr_no')->nullable();
            $table->integer('costing_id')->nullable();
            $table->string('checked')->nullable();
            $table->float('total_mrc', 8, 2)->nullable();
            $table->string('bill_payment_date')->nullable();
            $table->string('checked')->default(0);
            $table->string('payment_status')->nullable();
            $table->float('otc', 8, 2)->nullable();
            $table->float('mrc', 8, 2)->nullable();
            $table->float('total', 8, 2)->nullable();
            $table->float('vat_percent', 8, 2)->default(0);
            $table->float('vat_amount', 8, 2)->default(0);
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
