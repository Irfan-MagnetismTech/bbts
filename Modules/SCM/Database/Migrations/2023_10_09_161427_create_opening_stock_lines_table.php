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
        Schema::create('opening_stock_lines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('opening_stock_id');
            $table->integer('material_id')->nullable();
            $table->integer('brand_id')->nullable();
            $table->string('model')->nullable();
            $table->string('serial_code')->nullable();
            $table->double('quantity', 8, 2)->nullable();
            $table->double('unit_price', 22, 2)->nullable();
            $table->double('total_amount', 22, 2)->nullable();
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
        Schema::dropIfExists('opening_stock_lines');
    }
};
