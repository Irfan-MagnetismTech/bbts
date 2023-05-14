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
        Schema::create('lead_generations', function (Blueprint $table) {
            $table->id();
            $table->string('client_name')->nullable();
            $table->integer('client_no')->nullable();
            $table->text('address')->nullable();
            $table->integer('division_id')->nullable();
            $table->integer('district_id')->nullable();
            $table->integer('thana_id')->nullable();
            $table->string('landmark')->nullable();
            $table->string('lat_long')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('designation')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('email')->nullable();
            $table->string('client_type')->nullable();
            $table->string('business_type')->nullable();
            $table->string('website')->nullable();
            $table->string('document')->nullable();
            $table->string('current_provider')->nullable();
            $table->string('existing_bandwidth')->nullable();
            $table->string('existing_mrc')->nullable();
            $table->string('chance_of_business')->nullable();
            $table->string('potentiality')->nullable();
            $table->string('remarks')->nullable();
            $table->string('status')->nullable()->default('Pending');
            $table->string('created_by')->nullable();
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
        Schema::dropIfExists('lead_generations');
    }
};
