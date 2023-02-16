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
        Schema::create('cs_suppliers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cs_id')->constrained('cs', 'id')->cascadeOnDelete();
            $table->foreignId('supplier_id')->constrained('suppliers', 'id')->cascadeOnDelete();
            $table->string('quotattion_no')->nullable();
            $table->string('vat_tax')->nullable();
            $table->string('credit_period')->nullable();
            $table->boolean('is_checked')->default(false);
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
        Schema::dropIfExists('cs_suppliers');
    }
};
