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
            $table->string('feasibility_requirement_id');
            $table->string('fr_no')->nullable();
            $table->string('link_name')->nullable();
            $table->string('agreegation_type')->nullable();
            $table->integer('division_id')->nullable();
            $table->integer('district_id')->nullable();
            $table->integer('thana_id')->nullable();
            $table->string('location', 255)->nullable();
            $table->string('lat_long')->nullable();
            $table->string('client_no')->nullable();
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
