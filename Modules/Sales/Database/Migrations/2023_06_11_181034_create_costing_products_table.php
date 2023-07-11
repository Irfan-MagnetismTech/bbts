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
        Schema::create('costing_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('costing_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity');
            $table->decimal('rate', 8, 2);
            $table->string('unit');
            $table->decimal('sub_total', 10, 2);
            $table->decimal('product_vat', 10, 2);
            $table->decimal('product_vat_amount', 10, 2);
            $table->decimal('operation_cost', 10, 2);
            $table->decimal('operation_cost_total', 10, 2);
            $table->decimal('offer_price', 10, 2);
            $table->decimal('total', 10, 2);
            // Add foreign key constraints if necessary
            $table->foreign('costing_id')->references('id')->on('costings');
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
        Schema::dropIfExists('costing_products');
    }
};
