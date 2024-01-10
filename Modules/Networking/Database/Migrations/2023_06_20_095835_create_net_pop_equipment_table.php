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
        Schema::create('net_pop_equipment', function (Blueprint $table) {
            $table->id();
            $table->integer('pop_id')->unsigned();
            $table->integer('material_id')->nullable();
            $table->string('serial_code')->nullable();
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('equipment_type')->nullable();
            $table->double('quantity',20,2)->nullable();
            $table->string('status')->nullable();
            $table->string('tower_type')->nullable();
            $table->string('tower_height')->nullable();
            $table->string('made_by')->nullable();
            $table->date('maintenance_date')->nullable();
            $table->string('capacity')->nullable();
            $table->string('port_no')->nullable();
            $table->date('installation_date')->nullable();
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
        Schema::dropIfExists('net_pop_equipment');
    }
};
