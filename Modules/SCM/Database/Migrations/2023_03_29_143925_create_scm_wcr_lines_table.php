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
            $table->string('received_type')->nullable();
            $table->unsignedBigInteger('receiveable_id')->nullable();
            $table->unsignedBigInteger('material_id');
            $table->string('item_code')->nullable();
            $table->string('serial_code')->nullable();
            $table->unsignedBigInteger('brand_id');
            $table->string('model')->nullable();
            $table->string('challan_no')->nullable();
            $table->string('receiving_date')->nullable();
            $table->string('warranty_period')->nullable();
            $table->string('remaining_days')->nullable();
            $table->string('description')->nullable();
            $table->string('warranty_composite_key')->nullable();
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
