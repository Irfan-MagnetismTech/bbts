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
        Schema::create('scm_gate_pass_lines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('scm_gate_pass_id');
            $table->unsignedBigInteger('challan_id')->nullable();
            $table->unsignedBigInteger('mir_id')->nullable();
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
        Schema::dropIfExists('scm_gate_pass_lines');
    }
};
