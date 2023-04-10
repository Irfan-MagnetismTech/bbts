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
        Schema::create('scm_challan_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scm_challan_id')->constrained('scm_challans', 'id')->cascadeOnDelete();
            $table->string('received_type')->nullable();
            $table->string('type_id')->nullable();
            $table->string('item_code')->nullable();
            $table->string('purpose')->nullable();
            $table->bigInteger('brand_id')->nullable();
            $table->bigInteger('material_id')->nullable();
            $table->string('model')->nullable();
            $table->string('serial_code')->nullable();
            $table->string('unit')->nullable();
            $table->string('quantity')->nullable();
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
        Schema::dropIfExists('scm_challan_lines');
    }
};
