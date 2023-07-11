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
        Schema::create('billing_otc_bill_lines', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('billing_otc_bill_id');
            $table->foreign('billing_otc_bill_id')->references('id')->on('billing_otc_bills');
            $table->bigInteger('material_id');
            $table->bigInteger('quantity');
            $table->bigInteger('rate');
            $table->bigInteger('amount');
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
        Schema::dropIfExists('billing_otc_bill_lines');
    }
};
