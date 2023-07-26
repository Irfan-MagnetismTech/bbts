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
        Schema::create('c_c_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('fr_no')->nullable();
            $table->string('client_no')->nullable();
            $table->string('approved_type')->nullable();
            $table->date('client_readyness_date')->nullable();
            $table->date('nttn_date')->nullable();
            $table->date('equipment_readyness_date')->nullable();
            $table->date('field_operation_date')->nullable();
            $table->date('schedule_date')->nullable();
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
        Schema::dropIfExists('c_c_schedules');
    }
};
