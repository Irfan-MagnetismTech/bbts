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
        Schema::create('broken_days_bill_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('broken_days_bill_id')->constrained('broken_days_bills', 'id')->cascadeOnDelete();
            $table->string('particular')->nullable();
            $table->string('description')->nullable();
            $table->bigInteger('product_id')->nullable();
            $table->double('quantity', 8, 2)->nullable();
            $table->double('unit_price', 8, 2)->nullable();
            $table->double('total_price', 8, 2)->nullable();
            $table->double('vat', 8, 2)->nullable();
            $table->double('total_amount', 8, 2)->nullable();
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
        Schema::dropIfExists('broken_days_bill_details');
    }
};
