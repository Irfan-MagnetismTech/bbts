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
        Schema::create('connectivity_requirements', function (Blueprint $table) {
            $table->id();
            $table->string('fr_no');
            $table->string('client_no');
            $table->string('mq_no');
            $table->integer('is_modified')->default(0)->comment([0 => 'not modified', 1 => 'modified']);
            $table->string('from_location')->nullable();
            $table->string('aggregation_type')->nullable();
            $table->date('date')->nullable();
            $table->date('activation_date')->nullable();
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->string('existing_mrc')->nullable();
            $table->string('decrease_mrc')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('branch_id')->nullable();
            $table->string('document')->nullable();
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
        Schema::dropIfExists('connectivity_requirement');
    }
};
