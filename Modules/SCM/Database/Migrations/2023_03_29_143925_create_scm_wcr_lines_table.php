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
        Schema::create('scm_wcr_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scm_wcr_id')->constrained('scm_wcrs', 'id')->cascadeOnDelete();
            $table->unsignedBigInteger('material_id');
            $table->string('item_code');
            $table->string('serial_code');
            $table->unsignedBigInteger('brand_id');
            $table->string('model');
            $table->string('challan_no');
            $table->double('quantity', 8, 2)->nullable();
            $table->string('remarks');
            $table->string('warranty_composite_key');
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
        Schema::dropIfExists('scm_wcr_lines');
    }
};
