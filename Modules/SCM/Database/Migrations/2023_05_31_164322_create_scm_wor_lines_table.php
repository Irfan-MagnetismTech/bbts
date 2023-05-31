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
        Schema::create('scm_wor_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scm_wor_id')->constrained('scm_wors', 'id')->cascadeOnDelete();
            $table->string('received_type')->nullable();
            $table->unsignedBigInteger('material_id');
            $table->string('item_code')->nullable();
            $table->string('serial_code')->nullable();
            $table->unsignedBigInteger('brand_id');
            $table->string('model')->nullable();
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
        Schema::dropIfExists('scm_wor_lines');
    }
};
