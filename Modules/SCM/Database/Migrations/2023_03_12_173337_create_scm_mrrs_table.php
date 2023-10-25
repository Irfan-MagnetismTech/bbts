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
        Schema::create('scm_mrrs', function (Blueprint $table) {
            $table->id();
            $table->string('mrr_no')->nullable();
            $table->date('date')->nullable();
            $table->bigInteger('purchase_order_id')->nullable();
            $table->bigInteger('supplier_id')->nullable();
            $table->bigInteger('branch_id')->nullable();
            $table->string('challan_no')->nullable();
            $table->date('challan_date')->nullable();
            $table->string('bill_reg_no')->nullable();
            $table->string('bill_date')->nullable();
            $table->bigInteger('created_by')->nullable();
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
        Schema::dropIfExists('scm_mrrs');
    }
};
