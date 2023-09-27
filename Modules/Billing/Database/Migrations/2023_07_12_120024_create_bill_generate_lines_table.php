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
        Schema::create('bill_generate_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bill_generate_id')->constrained('bill_generates', 'id')->cascadeOnDelete();
            $table->string('fr_no')->nullable();
            $table->string('particular')->nullable();
            $table->bigInteger('otc_bill_id')->nullable();
            $table->bigInteger('billing_address_id')->nullable();
            $table->bigInteger('broken_days_bill_id')->nullable();
            $table->string('bill_type')->comment('OTC/Monthly Bill/Broken days');
            $table->bigInteger('product_id')->nullable();
            $table->double('quantity', 8, 2)->nullable();
            $table->double('unit_price', 8, 2)->nullable();
            $table->double('total_price', 8, 2)->nullable();
            $table->double('vat', 8, 2)->nullable();
            $table->double('total_product_price', 8, 2)->nullable();
            $table->double('total_amount', 8, 2)->nullable();
            $table->double('net_amount', 8, 2)->nullable();
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
        Schema::dropIfExists('bill_generate_lines');
    }
};
