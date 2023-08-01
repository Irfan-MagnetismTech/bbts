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
        Schema::create('collection_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('collection_id')->constrained('collections', 'id')->cascadeOnDelete();
            $table->string('payment_method');
            $table->string('instrument_date')->nullable();
            $table->string('instrument_no')->nullable();
            $table->bigInteger('amount')->default(0);
            $table->string('bank_name')->nullable();
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
        Schema::dropIfExists('collection_lines');
    }
};
