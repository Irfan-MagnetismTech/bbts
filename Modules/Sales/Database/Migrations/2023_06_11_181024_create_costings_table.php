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
            $table->unsignedBigInteger('fr_id');
            $table->integer('is_modified')->default(0)->comment([0 => 'not modified', 1 => 'modified']);
            $table->string('fr_no');
            $table->string('mq_no');
            $table->string('client_no');
            $table->string('connectivity_point');
            $table->string('month');
            $table->decimal('product_total_cost', 10, 2);
            $table->decimal('total_operation_cost', 10, 2);
            $table->decimal('total_cost_amount', 10, 2);
            $table->decimal('product_grand_total', 10, 2);
            $table->decimal('equipment_wise_total', 10, 2);
            $table->decimal('client_equipment_total', 10, 2);
            $table->decimal('equipment_partial_total', 10, 2);
            $table->decimal('equipment_deployment_cost', 10, 2);
            $table->decimal('equipment_interest', 10, 2);
            $table->decimal('equipment_vat', 10, 2);
            $table->decimal('equipment_tax', 10, 2);
            $table->decimal('equipment_grand_total', 10, 2);
            $table->decimal('equipment_otc', 10, 2);
            $table->decimal('equipment_roi', 10, 2);
            $table->decimal('total_investment', 10, 2);
            $table->decimal('total_otc', 10, 2);
            $table->decimal('total_product_cost', 10, 2);
            $table->decimal('total_service_cost', 10, 2);
            $table->decimal('total_mrc', 10, 2);
            $table->decimal('management_perchantage', 10, 2);
            $table->decimal('management_cost_amount', 10, 2);
            $table->decimal('management_cost_total', 10, 2);
            $table->decimal('equipment_price_for_client', 10, 2);
            $table->decimal('total_otc_with_client_equipment', 10, 2);
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
