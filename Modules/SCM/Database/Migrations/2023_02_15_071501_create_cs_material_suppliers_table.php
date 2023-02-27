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
        Schema::create('cs_material_suppliers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cs_id')->constrained('cs', 'id')->cascadeOnDelete();
            $table->foreignId('cs_supplier_id')->constrained('cs_suppliers', 'id')->cascadeOnDelete();
            $table->foreignId('cs_material_id')->constrained('cs_materials', 'id')->cascadeOnDelete();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->decimal('price', 20, 2)->nullable();
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
        Schema::dropIfExists('cs_material_suppliers');
    }
};
