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
        Schema::create('connectivity_product_requirement_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('connectivity_requirement_id');
            $table->integer('category_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->string('capacity')->nullable();
            $table->string('sla')->nullable();
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
        Schema::dropIfExists('connectivity_product_requirement_details');
    }
};
