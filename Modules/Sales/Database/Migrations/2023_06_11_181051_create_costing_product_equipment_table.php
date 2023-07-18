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
        Schema::create('costing_product_equipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('costing_id')->constrained('costings')->onDelete('cascade');
            $table->unsignedBigInteger('material_id');
            $table->integer('quantity');
            $table->string('unit');
            $table->string('ownership');
            $table->decimal('rate', 8, 2);
            $table->decimal('total', 10, 2);
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
        Schema::dropIfExists('costing_product_equipment');
    }
};
