<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->integer('designation_id')->nullable();
            $table->foreignId('departments_id')->nullable();
            $table->integer('pre_thana_id')->nullable();
            $table->integer('per_thana_id')->nullable();
            $table->string('name')->nullable();
            $table->string('nid')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('father')->nullable();
            $table->string('mother')->nullable();
            $table->date('joining_date')->nullable();
            $table->string('reference')->nullable();
            $table->string('job_experience')->nullable();
            $table->string('emergency')->nullable();
            $table->date('dob')->nullable();
            $table->string('contact')->nullable();
            $table->string('email')->nullable();
            $table->string('pre_street_address')->nullable();
            $table->string('per_street_address')->nullable();
            $table->string('picture')->nullable();
            $table->tinyInteger('address_status')->nullable();
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
        Schema::dropIfExists('employees');
    }
};
