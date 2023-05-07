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
        Schema::create('scm_err_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scm_err_id')->constrained('scm_errs', 'id')->cascadeOnDelete();
            $table->bigInteger('material_id')->nullable();
            $table->string('item_code')->nullable();
            $table->bigInteger('description')->nullable();
            $table->bigInteger('brand_id')->nullable();
            $table->string('model')->nullable();
            $table->bigInteger('serial_code')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('status')->comment('Damage/Usable')->nullable();
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
        Schema::dropIfExists('scm_err_lines');
    }
};
