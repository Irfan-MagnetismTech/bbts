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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
			$table->string('po_no')->nullable();
			$table->date('date')->nullable();
			$table->bigInteger('comparative_statement_id')->nullable();
			$table->bigInteger('indent_id')->nullable();
			$table->text('remarks')->nullable();
			$table->string('terms_of_supply')->nullable();
			$table->string('terms_of_payment')->nullable();
			$table->string('terms_of_condition')->nullable();
			$table->string('delivery_location')->nullable();
			$table->bigInteger('created_by')->nullable();
			$table->bigInteger('branch_id')->nullable();
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
        Schema::dropIfExists('purchase_orders');
    }
};
