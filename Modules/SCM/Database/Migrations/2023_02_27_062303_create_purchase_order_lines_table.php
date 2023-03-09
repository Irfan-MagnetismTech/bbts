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
        Schema::create('purchase_order_lines', function (Blueprint $table) {
            $table->id();
			$table->foreignId('purchase_order_id')->constrained('purchase_orders', 'id')->cascadeOnDelete();
			$table->bigInteger('scm_purchase_requisition_id')->nullable();
			$table->string('po_composit_key')->nullable();
            $table->bigInteger('cs_id')->nullable();
            $table->string('quotation_no')->nullable();
			$table->bigInteger('material_id')->nullable();
            $table->text('description')->nullable();
			$table->float('quantity')->nullable();
			$table->float('warranty_period')->nullable();
			$table->float('installation_cost')->nullable();
			$table->float('transport_cost')->nullable();
			$table->float('unit_price')->nullable();
			$table->string('vat')->nullable();
			$table->string('tax')->nullable();
			$table->float('total_amount')->nullable();
			$table->date('required_date')->nullable();
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
        Schema::dropIfExists('purchase_order_lines');
    }
};
