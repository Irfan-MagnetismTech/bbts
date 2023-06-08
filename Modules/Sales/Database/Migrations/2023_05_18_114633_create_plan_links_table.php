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
            $table->string(('link_type'))->nullable();
            $table->string('option')->nullable();
            $table->integer('existing_capacity')->nullable();
            $table->integer('new_capacity')->nullable();
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
