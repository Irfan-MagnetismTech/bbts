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
        Schema::create('service_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('planning_id')->constrained('plannings')->onDelete('cascade');
            $table->unsignedBigInteger('connectivity_product_requirement_details_id');
            $table->foreign('connectivity_product_requirement_details_id', 'fk_service_plans_conn_req_prod_details_id')
                ->references('id')->on('connectivity_product_requirement_details')
                ->onDelete('cascade');
            $table->integer('plan')->nullable();
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
        Schema::dropIfExists('service_plans');
    }
};
