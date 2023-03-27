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
        Schema::create('fiber_trackings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('branch_id');
            $table->string('serial_code')->nullable();
            $table->string('cp_serial_code')->nullable()->comment('Cut Peace Serial Code');
            $table->bigInteger('initial_mark')->nullable();
            $table->bigInteger('final_mark')->nullable();
            $table->double('quantity', 8, 2)->nullable();
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
        Schema::dropIfExists('fiber_trackings');
    }
};
