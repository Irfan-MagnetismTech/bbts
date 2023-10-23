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
        Schema::create('scm_purchase_requisition_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('scm_purchase_requisition_id');
            $table->string('req_key')->comment('requisition_composite_Key');
            $table->integer('material_id')->nullable();
            $table->string('item_code')->nullable();
            $table->integer('brand_id')->nullable();
            $table->string('model')->nullable();
            $table->double('quantity', 8, 2)->nullable();
            $table->double('unit_price', 22, 2)->nullable();
            $table->double('total_amount', 22, 2)->nullable();
            $table->string('purpose')->nullable();
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('scm_purchase_requisition_details');
    }
};
