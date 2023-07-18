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
        Schema::create('bandwidth_destributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('logical_connectivity_id')->constrained('logical_connectivities')->onDelete('cascade');
            $table->integer('ip_id')->nullable();
            $table->string('bandwidth')->nullable();
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
        Schema::dropIfExists('bandwidth_destributions');
    }
};
