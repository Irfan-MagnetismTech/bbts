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
        Schema::create('costing_link_equipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('costing_id')->constrained('costings')->onDelete('cascade');
            $table->foreignId('costing_link_id')->constrained('costing_links')->onDelete('cascade');
            $table->unsignedBigInteger('material_id');
            $table->string('unit');
            $table->string('ownership');
            $table->integer('quantity');
            $table->decimal('rate', 8, 2);
            $table->decimal('total', 10, 2);
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
        Schema::dropIfExists('costing_link_equipment');
    }
};
