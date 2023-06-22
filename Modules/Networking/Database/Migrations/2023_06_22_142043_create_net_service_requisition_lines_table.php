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
        Schema::create('net_service_requisition_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('net_service_requisition_id')->constrained('net_service_requisitions', 'id')->cascadeOnDelete();
            $table->integer('service_id');
            $table->integer('quantity');
            $table->string('remarks');
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
        Schema::dropIfExists('net_service_requisition_lines');
    }
};
