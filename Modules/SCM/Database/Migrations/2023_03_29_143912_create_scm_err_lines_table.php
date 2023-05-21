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
            $table->string('description')->nullable();
            $table->double('utilized_quantity', 8, 2)->nullable();
            $table->string('item_code')->nullable();
            $table->bigInteger('brand_id')->nullable();
            $table->string('model')->nullable();
            $table->string('serial_code')->nullable();
            $table->string('bbts_ownership')->nullable();
            $table->string('client_ownership')->nullable();
            $table->string('bbts_damaged')->nullable();
            $table->string('client_damaged')->nullable();
            $table->string('bbts_useable')->nullable();
            $table->string('client_useable')->nullable();
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
        Schema::dropIfExists('scm_err_lines');
    }
};
