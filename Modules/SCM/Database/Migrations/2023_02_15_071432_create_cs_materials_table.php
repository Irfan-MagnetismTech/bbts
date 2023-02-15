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
        Schema::create('cs_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cs_id')->constrained('cs', 'id')->cascadeOnDelete();
            $table->foreignId('material_id')->constrained('materials', 'id')->cascadeOnDelete();
            $table->foreignId('brand_id')->constrained('brands', 'id')->cascadeOnDelete();
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
        Schema::dropIfExists('cs_materials');
    }
};
