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
        Schema::create('scm_mrr_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scm_mrr_id')->constrained('scm_mrrs', 'id')->cascadeOnDelete();
            $table->integer('material_id');
            $table->bigInteger('description');
            $table->string('po_composit_key');
            $table->bigInteger('brand_id');
            $table->bigInteger('model');
            $table->bigInteger('initial_mark');
            $table->bigInteger('final_mark');
            $table->bigInteger('warranty_period');
            $table->string('item_code');
            $table->bigInteger('quantity');
            $table->decimal('unit_price');
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
        Schema::dropIfExists('scm_mrr_lines');
    }
};
