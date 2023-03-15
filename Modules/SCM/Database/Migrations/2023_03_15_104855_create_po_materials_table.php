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
        Schema::create('po_materials', function (Blueprint $table) {
            $table->id();
            $table->string('po_composite_key')->unique();
            $table->unsignedBigInteger('material_id')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->double('quantity', 8, 2)->nullable();
            $table->double('unit_price', 22, 2)->nullable();
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
        Schema::dropIfExists('po_materials');
    }
};
