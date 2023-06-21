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
        Schema::create('offer_details', function (Blueprint $table) {
            $table->id();
            $table->integer('offer_id')->nullable();
            $table->string('fr_no')->nullable();
            $table->double('client_equipment_total')->nullable();
            $table->double('total_otc')->nullable();
            $table->double('total_roi')->nullable();
            $table->double('total_offer_otc')->nullable();
            $table->double('grand_total_otc')->nullable();
            $table->double('total_offer_mrc')->nullable();
            $table->double('product_equipment_price')->nullable();
            $table->double('equipment_otc')->nullable();
            $table->double('equipment_roi')->nullable();
            $table->double('equipment_offer_price')->nullable();
            $table->double('equipment_total_otc')->nullable();
            $table->double('equipment_total_mrc')->nullable();
            $table->double('product_amount')->nullable();
            $table->double('offer_product_amount')->nullable();
            $table->double('management_cost')->nullable();
            $table->double('offer_management_cost')->nullable();
            $table->double('grand_total')->nullable();
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
        Schema::dropIfExists('offer_details');
    }
};
