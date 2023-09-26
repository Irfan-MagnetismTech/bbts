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
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->string('client_no')->nullable();
            $table->string('date')->nullable();
            $table->string('mr_no')->nullable();
            $table->string('remarks')->nullable();
            $table->integer('total_amount')->default(0);
            $table->integer('total_net_amount')->default(0);
            $table->integer('total_vat')->default(0);
            $table->integer('total_tax')->default(0);
            $table->integer('grand_total')->default(0);
            $table->integer('total_bill_amount')->default(0);
            $table->integer('total_previous_due')->default(0);
            $table->integer('total_receive_amount')->default(0);
            $table->integer('total_due')->default(0);
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
        Schema::dropIfExists('collections');
    }
};
