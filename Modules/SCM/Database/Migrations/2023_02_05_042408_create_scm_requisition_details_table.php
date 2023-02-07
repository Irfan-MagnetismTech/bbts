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
        Schema::create('scm_requisition_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('scm_requisition_id');
            $table->integer('material_id')->nullable();
            $table->string('description')->nullable();
            $table->string('item_code')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('brand_id')->nullable();
            $table->string('model')->nullable();
            $table->string('purpose')->nullable();
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
        Schema::dropIfExists('scm_requisition_details');
    }
};
