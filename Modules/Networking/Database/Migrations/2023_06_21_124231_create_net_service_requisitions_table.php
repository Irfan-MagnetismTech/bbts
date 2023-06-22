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
        Schema::create('net_service_requisitions', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->integer('from_pop_id');
            $table->integer('to_pop_id');
            $table->string('capacity_type');
            $table->string('capacity');
            $table->string('client_no');
            $table->date('date');
            $table->date('required_date');
            $table->integer('vendor_id');
            $table->string('remark');
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
        Schema::dropIfExists('net_service_requisitions');
    }
};
