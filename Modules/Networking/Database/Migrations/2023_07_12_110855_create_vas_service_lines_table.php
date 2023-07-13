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
        Schema::create('vas_service_lines', function (Blueprint $table) {
            $table->id();
            $table->string('vas_service_id');
            $table->integer('product_id')->nullable();
            $table->string('unit')->nullable();
            $table->integer('quantity')->nullable();
            $table->double('rate', 8, 2)->nullable();
            $table->double('total', 8, 2)->nullable();
            $table->string('description')->nullable();
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
        Schema::dropIfExists('vas_service_lines');
    }
};
