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
        Schema::create('scm_wcrr_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scm_wcrr_id')->constrained('scm_wcrrs', 'id')->cascadeOnDelete();
            $table->unsignedBigInteger('material_id');
            $table->string('item_code')->nullable();
            $table->string('material_type')->nullable();
            $table->string('serial_code')->nullable();
            $table->unsignedBigInteger('brand_id');
            $table->string('model')->nullable();
            $table->string('description')->nullable();
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
        Schema::dropIfExists('scm_wcrr_lines');
    }
};
