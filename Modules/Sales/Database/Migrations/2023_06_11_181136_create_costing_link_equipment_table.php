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
        Schema::create('costing_link_equipment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('costing_id');
            $table->unsignedBigInteger('costing_link_id');
            $table->unsignedBigInteger('material_id');
            $table->string('unit');
            $table->string('ownership');
            $table->integer('quantity');
            $table->decimal('rate', 8, 2);
            $table->decimal('total', 10, 2);
            $table->timestamps();
            // Add foreign key constraints if necessary
            $table->foreign('costing_id')->references('id')->on('costings');
            $table->foreign('costing_link_id')->references('id')->on('costing_links');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('costing_link_equipment');
    }
};
