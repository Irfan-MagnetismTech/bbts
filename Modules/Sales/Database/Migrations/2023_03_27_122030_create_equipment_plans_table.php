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
        Schema::create('equipment_plans', function (Blueprint $table) {
            $table->id();
            $table->integer('planning_id')->nullable();
            $table->integer('material_id')->nullable();
            $table->integer('brand_id')->nullable();
            $table->integer('quantity')->nullable();
            $table->string(('model'))->nullable();
            $table->string('description')->nullable();
            $table->string(('unit'))->nullable();
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('equipment_plans');
    }
};
