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
        Schema::create('connectivities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sale_id');
            $table->string('client_no');
            $table->string('fr_no')->nullable();
            $table->string('connectivity_requirement_id')->nullable();
            $table->integer('attendant_engineer')->nullable();
            $table->date('commissioning_date')->nullable();
            $table->date('modified_date')->nullable();
            $table->integer('is_modify')->default('0');
            $table->integer('billing_date')->nullable();
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
        Schema::dropIfExists('connectivities');
    }
};
