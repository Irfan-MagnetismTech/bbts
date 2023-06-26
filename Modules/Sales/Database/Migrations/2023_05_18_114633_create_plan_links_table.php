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
        Schema::create('plan_links', function (Blueprint $table) {
            $table->id();
            $table->integer('planning_id')->nullable();
            $table->string('link_type')->nullable();
            $table->string(('existing_infrastructure'))->nullable();
            $table->string('option')->nullable();
            $table->integer('existing_transmission_capacity')->nullable();
            $table->integer('increase_capacity')->nullable();
            $table->string('link_availability_status')->nullable();
            $table->integer('new_transmission_capacity')->nullable();
            $table->string('link_remarks')->nullable();
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
        Schema::dropIfExists('plan_links');
    }
};
