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
        Schema::create('final_survey_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('survey_id')->nullable();
            $table->string('link_type')->nullable();
            $table->string('link_no')->nullable();
            $table->string('option')->nullable();
            $table->string('status')->nullable();
            $table->string('method')->nullable();
            $table->string('vendor')->nullable();
            $table->string('bts_pop_ldp')->nullable();
            $table->string('gps')->nullable();
            $table->string('distance')->nullable();
            $table->string('current_capacity')->nullable();
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
        Schema::dropIfExists('final_survey_details');
    }
};
