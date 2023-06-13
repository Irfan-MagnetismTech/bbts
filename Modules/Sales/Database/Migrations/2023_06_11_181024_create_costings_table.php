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
        Schema::create('costings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->string('connectivity_point_name');
            $table->string('month');
            $table->decimal('product_total_cost', 10, 2);
            $table->decimal('total_operation_cost', 10, 2);
            $table->decimal('product_total_operation_cost', 10, 2);
            $table->decimal('product_total_margin_amount', 10, 2);
            $table->decimal('equipment_partial_total', 10, 2);
            $table->decimal('equipment_development_cost', 10, 2);
            $table->decimal('equipment_interest', 10, 2);
            $table->decimal('equipment_vat', 10, 2);
            $table->decimal('equipment_tax', 10, 2);
            $table->decimal('equipment_grand_total', 10, 2);
            $table->decimal('euipment_otc', 10, 2);
            $table->decimal('equipment_roi', 10, 2);
            $table->decimal('total_investment', 10, 2);
            $table->decimal('total_otc', 10, 2);
            $table->decimal('total_product_cost', 10, 2);
            $table->decimal('total_service_cost', 10, 2);
            $table->decimal('total_mrc', 10, 2);
            $table->decimal('management_cost_perchant', 10, 2);
            $table->decimal('management_cost_amount', 10, 2);
            $table->decimal('management_cost_with_mrc', 10, 2);
            $table->decimal('client_ownership_cost', 10, 2);
            $table->decimal('client_total_otc', 10, 2);
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
        Schema::dropIfExists('costings');
    }
};
