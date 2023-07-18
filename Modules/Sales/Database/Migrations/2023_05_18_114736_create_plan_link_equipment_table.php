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
        Schema::create('plan_link_equipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('planning_id')->constrained('plannings')->onDelete('cascade');
            $table->integer('final_survey_id')->nullable();
            $table->foreignId('plan_link_id')->constrained('plan_links')->onDelete('cascade');
            $table->integer('material_id')->nullable();
            $table->integer('brand_id')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('model')->nullable();
            $table->string(('unit'))->nullable();
            $table->string('description')->nullable();
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
        Schema::dropIfExists('plan_link_equipment');
    }
};
