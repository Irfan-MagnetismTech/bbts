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
        Schema::create('costing_links', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('costing_id');
            $table->string('link_type');
            $table->string('option');
            $table->string('transmission_capacity');
            $table->integer('quantity');
            $table->decimal('rate', 8, 2);
            $table->decimal('total', 10, 2);
            $table->decimal('plan_all_equipment_total', 10, 2);
            $table->decimal('plan_client_equipment_total', 10, 2);
            $table->decimal('partial_total', 10, 2);
            $table->decimal('deployment_cost', 10, 2);
            $table->decimal('interest', 10, 2);
            $table->decimal('grand_total', 10, 2);
            $table->decimal('vat', 10, 2);
            $table->decimal('tax', 10, 2);
            $table->decimal('investment', 10, 2);
            $table->decimal('otc', 10, 2);
            $table->decimal('roi', 10, 2);
            $table->decimal('capacity_amount', 10, 2);
            $table->decimal('operation_cost', 10, 2);
            $table->decimal('total_mrc', 10, 2);
            $table->timestamps();
            // Add foreign key constraints if necessary
            $table->foreign('costing_id')->references('id')->on('costings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('costing_links');
    }
};
