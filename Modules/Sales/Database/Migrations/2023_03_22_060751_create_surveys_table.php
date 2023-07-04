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
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('feasibility_requirement_details_id')->nullable();
            $table->string('fr_no');
            $table->string('client_no');
            $table->string('lead_generation_id');
            $table->string('mq_no')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('branch_id')->nullable();
            $table->date('date')->nullable();
            $table->string('connectivity_remarks')->nullable();
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
        Schema::dropIfExists('serveys');
    }
};
