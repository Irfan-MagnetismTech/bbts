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
        Schema::create('scm_mrr_serial_code_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scm_mrr_line_id')->constrained('scm_mrr_lines', 'id')->cascadeOnDelete();
            $table->bigInteger('opening_stock_line_id')->nullable();
            $table->string('serial_or_drum_key')->nullable();
            $table->string('serial_or_drum_code')->nullable();
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
        Schema::dropIfExists('scm_mrr_serial_code_lines');
    }
};
