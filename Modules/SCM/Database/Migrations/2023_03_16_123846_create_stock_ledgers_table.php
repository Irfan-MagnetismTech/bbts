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
            $table->string('stockable_type')->nullable();
            $table->bigInteger('stockable_id')->nullable();
            $table->bigInteger('branch_id')->nullable();
            $table->bigInteger('material_id')->nullable();
            $table->string('item_code')->nullable();
            $table->string('unit')->nullable();
            $table->bigInteger('brand_id')->nullable();
            $table->string('model')->nullable();
            $table->string('serial_code')->nullable();
            $table->bigInteger('initial_mark')->nullable();
            $table->bigInteger('final_mark')->nullable();
            $table->string('received_type')->nullable();
            $table->string('receiveable_type')->nullable();
            $table->bigInteger('receiveable_id')->nullable()->comment('MRR/ERR/WCR');
            $table->double('quantity', 8, 2)->nullable();
            $table->double('damaged_quantity', 8, 2)->nullable();
            $table->double('unit_price', 22, 2)->nullable();
            $table->integer('warranty_period')->nullable();
            $table->bigInteger('left_initial_mark')->nullable();
            $table->bigInteger('left_final_mark')->nullable();
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
