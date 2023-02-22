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
            $table->text('address')->nullable();
            $table->integer('division')->nullable();
            $table->integer('district')->nullable();
            $table->integer('thana')->nullable();
            $table->string('landmark')->nullable();
            $table->string('lat_long')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('designation')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('email')->nullable();
            $table->string('client_type')->nullable();
            $table->string('business_type')->nullable();
            $table->string('website')->nullable();
            $table->string('docuemnt')->nullable();
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
