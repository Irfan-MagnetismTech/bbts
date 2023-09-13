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
        Schema::create('feasibility_requirement_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('feasibility_requirement_id');
            $table->foreign('feasibility_requirement_id', 'fk_feasibility_req_details_feasibility_req_id')
                ->references('id')->on('feasibility_requirements')
                ->onDelete('cascade');
            $table->string('client_no');
            $table->string('aggregation_type');
            $table->string('fr_no')->nullable();
            $table->string('connectivity_point')->nullable();
            $table->string('agreegation_type')->nullable();
            $table->integer('branch_id')->nullable();
            $table->integer('division_id')->nullable();
            $table->integer('district_id')->nullable();
            $table->integer('thana_id')->nullable();
            $table->string('location', 255)->nullable();
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('contact_designation')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('contact_email')->nullable();
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
        Schema::dropIfExists('feasibility_requirement_details');
    }
};
