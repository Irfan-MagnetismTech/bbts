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
            $table->unsignedBigInteger('survey_detail_id');
            $table->bigInteger('planning_id')->nullable();
            $table->bigInteger('plan_link_id')->nullable();
            $table->string('link_type')->nullable();
            $table->string('link_no')->nullable();
            $table->string('option')->nullable();
            $table->string('status')->nullable();
            $table->string('method')->nullable();
            $table->string('vendor_id')->nullable();
            $table->integer('pop_id')->nullable();
            $table->string('ldp')->nullable();
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            $table->string('distance')->nullable();
            $table->string('current_capacity')->nullable();
            $table->string('remarks')->nullable();
            // $table->foreign('survey_detail_id')->references('id')->on('survey_details')->onDelete('cascade');
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
