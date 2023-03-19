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
        Schema::create('scm_mir_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scm_mir_id')->constrained('scm_mirs', 'id')->cascadeOnDelete();
            $table->integer('material_id')->nullable();
            $table->string('item_code')->nullable();
            $table->string('description')->nullable();
            $table->string('received_type')->nullable();
            $table->integer('brand_id')->nullable();
            $table->string('model')->nullable();
            $table->bigInteger('initial_mark')->nullable();
            $table->bigInteger('final_mark')->nullable();
            $table->double('quantity', 8, 2)->nullable();
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
        Schema::dropIfExists('scm_mir_lines');
    }
};
