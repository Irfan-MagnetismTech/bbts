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
        Schema::create('scm_mur_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scm_mur_id')->constrained('scm_murs', 'id')->cascadeOnDelete();
            $table->bigInteger('material_id')->nullable();
            $table->string('description')->nullable();
            $table->bigInteger('brand_id')->nullable();
            $table->string('model')->nullable();
            $table->string('serial_code')->nullable();
            $table->string('quantity')->nullable();
            $table->bigInteger('receivable_id')->nullable();
            $table->string('receivable_type')->nullable();
            $table->string('utilized_quantity')->nullable();
            $table->string('bbts_ownership')->nullable();
            $table->string('client_ownership')->nullable();
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
        Schema::dropIfExists('scm_mur_lines');
    }
};
