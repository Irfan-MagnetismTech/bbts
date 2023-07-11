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
        Schema::create('physical_connectivity_lines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('physical_connectivity_id');
            $table->string('link_type')->nullable();
            $table->string('method')->nullable();
            $table->string('pop')->nullable();
            $table->string('ldp')->nullable();
            $table->string('link_id')->nullable();
            $table->string('device_ip')->nullable();
            $table->string('port')->nullable();
            $table->string('vlan')->nullable();
            $table->string('connectivity_details')->nullable();
            $table->string('comment')->nullable();
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
        Schema::dropIfExists('physical_connectivity_lines');
    }
};
