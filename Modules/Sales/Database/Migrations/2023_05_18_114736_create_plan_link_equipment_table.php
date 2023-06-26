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
        Schema::create('plan_link_equipment', function (Blueprint $table) {
            $table->id();
            $table->integer('planning_id')->nullable();
            $table->integer('final_survey_id')->nullable();
            $table->integer('plan_link_id')->nullable();
            $table->string('material_name')->nullable();
            $table->integer('quantity')->nullable();
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
        Schema::dropIfExists('plan_link_equipment');
    }
};
