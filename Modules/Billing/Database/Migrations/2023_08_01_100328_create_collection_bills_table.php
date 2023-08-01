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
        Schema::create('collection_bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('collection_id')->constrained('collections', 'id')->cascadeOnDelete();
            $table->string('bill_no');
            $table->bigInteger('amount')->default(0);
            $table->bigInteger('discount')->default(0);
            $table->bigInteger('penalty')->default(0);
            $table->bigInteger('net_amount')->default(0);
            $table->bigInteger('receive_amount')->default(0);
            $table->bigInteger('previous_due')->default(0);
            $table->bigInteger('due')->default(0);
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
        Schema::dropIfExists('collection_bills');
    }
};
