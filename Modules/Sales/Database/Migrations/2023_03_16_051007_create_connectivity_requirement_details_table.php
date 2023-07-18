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
        Schema::create('connectivity_requirement_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('connectivity_requirement_id');
            $table->foreign('connectivity_requirement_id', 'fk_connectivity_req_details_connectivity_req_id')
                ->references('id')->on('connectivity_requirements')
                ->onDelete('cascade');
            $table->string('link_type')->nullable();
            $table->string('method')->nullable();
            $table->string('connectivity_capacity')->nullable();
            $table->string('sla')->nullable();
            $table->string('vendor_id')->nullable();
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
        Schema::dropIfExists('connectivity_requirement_details');
    }
};
