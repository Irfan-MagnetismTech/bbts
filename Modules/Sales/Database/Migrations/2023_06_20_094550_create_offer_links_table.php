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
        Schema::create('offer_links', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('offer_id');
            $table->unsignedBigInteger('offer_details_id');
            $table->foreign('offer_id')->references('id')->on('offers')->onDelete('cascade');
            $table->foreign('offer_details_id')->references('id')->on('offer_details')->onDelete('cascade');

            // $table->foreign('feasibility_requirement_id', 'fk_feasibility_req_details_feasibility_req_id')
            //     ->references('id')->on('feasibility_requirements')
            //     ->onDelete('cascade');

            $table->string('link_id')->nullable();
            $table->string('link_type')->nullable();
            $table->string('link_status')->nullable();
            $table->string('link_no')->nullable();
            $table->string('option')->nullable();
            $table->string('connectivity_status')->nullable();
            $table->string('method')->nullable();
            $table->string('vendor')->nullable();
            $table->string('bts_pop_ldp')->nullable();
            $table->string('distance')->nullable();
            $table->double('client_equipment_amount')->nullable();
            $table->double('otc')->nullable();
            $table->double('mo_cost')->nullable();
            $table->double('offer_otc')->nullable();
            $table->double('total_cost')->nullable();
            $table->double('offer_mrc')->nullable();
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
        Schema::dropIfExists('offer_links');
    }
};
