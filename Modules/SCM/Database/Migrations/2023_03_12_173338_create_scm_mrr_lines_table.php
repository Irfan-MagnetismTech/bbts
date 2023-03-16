
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
            $table->integer('material_id')->nullable();
            $table->string('description')->nullable();
            $table->string('po_composit_key')->nullable();
            $table->bigInteger('brand_id')->nullable();
            $table->bigInteger('model')->nullable();
            $table->bigInteger('initial_mark')->nullable();
            $table->bigInteger('final_mark')->nullable();
            $table->bigInteger('warranty_period')->nullable();
            $table->string('item_code')->nullable();
            $table->double('quantity', 8, 2)->nullable();
            $table->double('unit_price', 22, 2)->nullable();
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
