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
        Schema::create('stock_ledgers', function (Blueprint $table) {
            $table->id();
            $table->string('stockable_type');
            $table->bigInteger('stockable_id');
            $table->bigInteger('branch_id');
            $table->bigInteger('material_id');
            $table->string('item_code');
            $table->string('unit');
            $table->bigInteger('brand_id');
            $table->string('model');
            $table->string('serial_code');
            $table->bigInteger('initial_mark');
            $table->bigInteger('final_mark');
            $table->string('receivable_type');
            $table->bigInteger('receivable_id')->comment('MRR/ERR/WCR');
            $table->double('quantity', 8, 2)->nullable();
            $table->double('unit_price', 22, 2)->nullable();
            $table->integer('warranty_period');
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
        Schema::dropIfExists('stock_ledgers');
    }
};
